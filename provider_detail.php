<!DOCTYPE html>
<?php
error_reporting(0);
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

<div clsss="container-fluid">
    <div class="row">
        <div class="span4">
            <img src="img/hit_cs.jpg">
        </div>
        <div class="span8 well">
            <?php
            include "dbhelper.php";
            $id=$_GET["id"];
            $helper=new DBHelper();
            $helper->connectDB();
            $rs=$helper->getProviderById($id);
            $line=mysql_fetch_row($rs);
            echo ('<p>name:' .$line[0].'</p>');
            echo ('<p>email:' .$line[1].'</p>');
            echo ('<p>phone:' .$line[2].'</p>');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="span12">
            <table class="table table-bordered">
                <tbody>
                <?php
                $id=$_GET["id"];
                $rs=$helper->getBookByProvider($id);
                $row=mysql_num_rows($rs);

                for($i=0;$i<$row;$i++){
                    $line=mysql_fetch_row($rs);
                    echo ('<tr>');
                    echo ('<td class="td-img"><img src="img/example.png"></td>');
                    echo('<td class="td-text"><a href="book_detail.php?isbn='.$line[0].'">'.$line[1].'</a></td>');
                    echo('<td class="td-text"><a href="author_detail.php?id='.$line[2].'">'.$line[3].'</a></td>');
                    echo('<td class="td-text"><a href="publisher_detail.php?id='.$line[4].'">'.$line[5].'</a></td>');
                    for($j=6;$j<8;$j++){
                        echo('<td class="td-text">'.$line[$j].'</td>');
                    }
                    echo ('</tr>');
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
<script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>
<script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-dropdown.js"></script>
<script>
    function user_submit(){
        $("#user_submit_form").submit();
    }

    $(
        function(){
            $("img").css("height","200px");
            $("img").css("width","160px");

            $(".td-img").css("width","160px");
            $(".td-text").css("text-align","center");
            $(".td-text").css("vertical-align","middle");
            $("#user_name_href").click(user_submit);
        }
    );
</script>
</html>
