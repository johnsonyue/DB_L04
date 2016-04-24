<!DOCTYPE html>
<?php
error_reporting(0);

include "dbhelper.php";
$helper=new DBHelper();
$helper->connectDB();

if(isset($_POST["user_name"]) && isset($_POST["isbn"]) && isset($_POST["item_num"])){
    $id=$helper->getIdByName($_POST["user_name"]);
    if(!$helper->putBookIntoCart($_POST["isbn"],$id,$_POST["item_num"])){
        echo('<p style="font-size:20px">Item Already Exists in Your Cart.</p>');
        exit();
    }
}
else if(!isset($_POST["user_name"])){
    echo('<p style="font-size:20px">Bad Parameters</p>');
    exit();
}
?>
<html lang="zh-CN">
<head>
    <title>Online Book Store</title>
    <link href="twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">
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

<div class="container-fluid">
    <div class="span12">
        <form method="post">
            <span id="hint">Check All</span> <input id="check_all" type="checkbox">
            <input id="isbn_array" name="isbn" type="hidden">
            <input id="num_array" name="num" type="hidden">
            <input name="id" type="hidden" value="<?php echo($helper->getIdByName($_POST["user_name"])); ?>">
            <button id="delete_btn" type="submit" formaction="delete.php" class="btn btn-danger" style="margin-left:20px">delete</button>
            <button id="check_out_btn" type="submit" formaction="checkout.php" class="btn btn-success" style="margin-left:20px">check out</button>
        </form>
        </br>
    </div>
    <div class="span12">
        <table class="table table-bordered" id="cart_table">
            <tbody>
                <?php
                $id=$helper->getIdByName($_POST["user_name"]);
                $rs=$helper->getBookByCart($id);
                $row=mysql_num_rows($rs);

                for($i=0;$i<$row;$i++){
                    $line=mysql_fetch_row($rs);
                    echo ('<tr>');
                    echo ('<td class="td-checkbox"><input type="checkbox" value="'.$line[0].'|'.$line[8].'"></td>');
                    echo ('<td class="td-img"><img src="img/example.png"></td>');
                    echo('<td class="td-text"><a href="book_detail.php?isbn='.$line[0].'">'.$line[1].'</a></td>');
                    echo('<td class="td-text"><a href="author_detail.php?id='.$line[2].'">'.$line[3].'</a></td>');
                    echo('<td class="td-text"><a href="publisher_detail.php?id='.$line[4].'">'.$line[5].'</a></td>');
                    for($j=6;$j<9;$j++){
                        echo('<td class="td-text">'.$line[$j].'</td>');
                    }
                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
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
        var arr_isbn = [];
        $("#cart_table").find(":checkbox:checked").each(
            function(i){
                var arr=$(this).val().split('|');
                arr_isbn.push(arr[0]);
            }
        );
        $("#isbn_array").val(arr_isbn.join('|'));
        return true;
    }

    function checkout_submit(){
        var arr_isbn = [], arr_num =[];
        $("#cart_table").find(":checkbox:checked").each(
            function(i){
                var arr=$(this).val().split('|');
                arr_isbn.push(arr[0]);
                arr_num.push(arr[1]);
            }
        );
        $("#isbn_array").val(arr_isbn.join('|'));
        $("#num_array").val(arr_num.join('|'));
        return true;
    }

    function checkbox_click(){
        if($("#check_all").attr("checked")){
            $("#cart_table input[type=checkbox]").attr("checked",true);
            $("hint").html("Uncheck All");
        }
        else{
            $("#cart_table input[type=checkbox]").attr("checked",false);
            $("hint").html("Uncheck All");
        }
    }

    $(
        function(){
            $("img").css("height","200px");
            $("img").css("width","160px");

            $(".td-img").css("width","160px");
            $(".td-checkbox").css("vertical-align","middle");
            $(".td-text").css("text-align","center");
            $(".td-text").css("vertical-align","middle");
            $("#user_name_href").click(user_submit);
            $("#check_all").click(checkbox_click);
            $("#delete_btn").click(delete_submit);
            $("#check_out_btn").click(checkout_submit);
        }
    );
</script>
</html>
