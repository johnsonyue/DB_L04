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


<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">BOOK</li>
                    <li><a href="index.php?action=recommened"><i class="icon-chevron-right"></i>RECOMMEND</a></li>
                    <li><a href="index.php?action=latest"><i class="icon-chevron-right"></i>LATEST</a></li>
                    <li><a href="index.php?action=classic"><i class="icon-chevron-right"></i>CLASSIC</a></li>

                    <li class="nav-header">AUTHOR</li>
                    <li><a href="index.php?action=author"><i class="icon-chevron-right"></i>POPULAR</a></li>
                    <li><a href="index.php?action=story"><i class="icon-chevron-right"></i>STORY</a></li>

                    <li class="nav-header">PUBLISHER</li>
                    <li><a href="index.php?action=publisher"><i class="icon-chevron-right"></i>POPULAR</a></li>
                </ul>
            </div><!--/.well -->
        </div><!--/span-->

        <div class="span10">
            <div class="container-fluid">
                <div class="navbar-search span12">
                <?php
                    $action=$_GET["action"];
                    if($action!="author"&&$action!="story"&&$action!="publisher"){
                        echo('
                        <div class="banner span2">
                            <h3>SEARCH BOOK</h3>
                        </div>
                        <form method="get">
                            <input name="action" value="search" type="hidden">
                            <input name="key" type="text" class="span4" placeholder="search key">
                            <select name="select" class="span4">
                                <option value="0">by title</option>
                                <option value="1">by author</option>
                                <option value="2">by publisher</option>
                            </select>
                            <button type="submit" class="btn btn-success">Search</button>
                        </form>
                        </div>
                        ');
                    }
                ?>
                <table class="table table-bordered">
                    <tbody>
                        <?php
                            if($action!="author"&&$action!="story"&&$action!="publisher") {
                                include "book_list.php";
                            }
                            else if($action=="author"||$action=="story"){
                                include "author_list.php";
                            }
                            else if($action=="publisher"){
                                include "publisher_list.php";
                            }
                        ?>
                    </tbody>
                </table>

            </div>
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
