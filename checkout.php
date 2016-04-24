<?php
error_reporting(0);

include "dbhelper.php";
$helper=new DBHelper();
$helper->connectDB();
$id=0;

if($_POST["action"]=="direct" && isset($_POST["user_name"]) && isset($_POST["item_num"]) && isset($_POST["isbn"])){
    $id=$helper->getIdByName($_POST["user_name"]);
    $helper->generateOrderFromBook($id, $_POST["item_num"], $_POST["isbn"]);
}
else if(isset($_POST["id"]) && isset($_POST["isbn"])){
    $id=$_POST["id"];
    $isbn=explode('|',$_POST["isbn"]);
    if($_POST["isbn"]!="") {
        $helper->generateOrderFromCart($id, $isbn);
    }
}
else if(!isset($_POST["id"])){
    echo('<p style="font-size:20px">Bad Parameters</p>');
    exit();
}
?>

<html lang="zh-CN">
<head>
    <title>Online Book Store</title>
    <link href="twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">
    <script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>
    <script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-collapse.js"></script>
</head>

<body>
<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#">ONLINE BOOK STORE</a>
            <div class="nav-collapse collapse">
                <?php
                session_start();
                if(isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"]==true){
                    echo('

                        <form class="navbar-form pull-right" method="post" action="result.php" style="font-size:20px;color:white">
                            <input name="action" value="logout" type="hidden">
                            <button type="submit" class="btn btn-primary" style="margin-left:20px">Log Out</button>
                            <a href="register.html" class="btn btn-danger" style="margin-left:20px">Register New Account</a>
                        </form>
                        <form id="user_submit_form" class="navbar-form pull-right" method="post" action="cart.php" style="font-size:20px;color:white;">
                            Welcome, <a id="user_name_href">'.$_SESSION["user_name"].'</a>
                            <input name="user_name" type="hidden" value="'.$_SESSION["user_name"].'">
                        </form>
                        ');
                }
                else{
                    echo('
                        <form class="navbar-form pull-right" method="post" action="result.php">
                            <input name="user_name" class="span2" type="text" placeholder="user Name">
                            <input name="password" class="span2" type="password" placeholder="password">
                            <input name="action" value="login" type="hidden">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a href="register.html" class="btn btn-danger">Register</a>
                        </form>
                        ');
                }
                ?>
                <ul class="nav">
                    <li><a href="index.php">Book</a></li>
                    <li><a href="index.php?action=author">Author</a></li>
                    <li><a href="index.php?action=publisher">Publisher</a></li>
                    <li><a href="about.html">About</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div clsss="container-fluid">
    <div class="row">
        <div class="span12">
            <?php
                $rs=$helper->getOrderByCustomer($id);
                $row=mysql_num_rows($rs);
                for($i=0;$i<$row;$i++){
                    $line=mysql_fetch_row($rs);
                    $book_rs=$helper->getBookByOrder($line[0]);
                    $book_row=mysql_num_rows($book_rs);

                    $content='';
                    for($j=0;$j<$book_row;$j++){
                        $book_line=mysql_fetch_row($book_rs);
                        $content.='<tr>';
                        $content.='<td>'.$book_line[0].'</td>';
                        $content.='<td>'.$book_line[1].'</td>';
                        $content.='</tr>';
                    }

                    $table='
                    <table class="table table-bordered">
                    <tbody>
                        '.$content.'
                    </tbody>
                    </table>
                    ';

                    echo('
                    <div class="accordion" id="accordion'.$i.'">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <div class="row">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion'.$i.'" href="#collapse'.$i.'" style="font-size:15px">
                                    id: '.$line[0].' time: '.$line[1].' total price: '.$line[2].'
                                </a>
                                <form action="delete_order.php" method="post" class="delete_form pull-right" style="margin:0px">
                                    <input type="hidden" name="order_id" value="'.$line[0].'">
                                    <a class="delete_href">delete</a>
                                </form>
                                </div>
                            </div>
                            <div id="collapse'.$i.'" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    '.$table.'
                                </div>
                            </div>
                        </div>
                    </div>
                ');
                }
            ?>
        </div>
    </div>

</body>
<script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>
<script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-dropdown.js"></script>
<script>
    function user_submit(){
        $("#user_submit_form").submit();
    }

    function delete_submit(){
        $(this).parent().submit();
    }

    $(
        function(){
            $("img").css("height","200px");
            $("img").css("width","160px");

            $(".td-img").css("width","160px");
            $(".td-text").css("text-align","center");
            $(".td-text").css("vertical-align","middle");
            $("#user_name_href").click(user_submit);
            $(".delete_href").click(delete_submit);
        }
    );
</script>
</html>