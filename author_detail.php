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
    <div class="span4">
        <img src="img/obama.jpg">
    </div>
    <div class="span8 well">
        <?php
            include "dbhelper.php";
            $id=$_GET["id"];
            $helper=new DBHelper();
            $helper->connectDB();
            $rs=$helper->getAuthorById($id);
            $line=mysql_fetch_row($rs);
            $works_num=$helper->getAuthorWorksNum($id);
            echo ('<p>name:' .$line[1].'</p>');
            echo ('<p>email:' .$line[2].'</p>');
            echo ('<p>phone:' .$line[3].'</p>');
            echo ('<p>works num:' .$works_num.'</p>');
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

    $(
        function(){
            $("img").css("height","200px");
            $("img").css("width","160px");

            $("#user_name_href").click(user_submit);
        }
    );
</script>
</html>
