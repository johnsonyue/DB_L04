<!DOCTYPE html>
<html>

<?php
include "dbhelper.php";

if(!isset($_GET["isbn"])){
    echo("Bad Parameter</br>");
    exit();
}
$isbn = $_GET["isbn"];

$helper=new DBHelper();
$helper->connectDB();
$rs=$helper->getBookByISBN($isbn);
$row=mysql_num_rows($rs);
if($row==0){
    echo("Book Not Found</br>");
    exit();
}
$line=mysql_fetch_row($rs);

$provider_rs=$helper->getProviderByISBN($isbn);
$provider_line=mysql_fetch_row($provider_rs);

?>

<head lang="en">
    <meta charset="UTF-8">
    <title>Book Detail</title>
    <link href="twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">
    <link href="jquery-ui/jquery-ui.min.css" rel="stylesheet">

    <style>
        p{
            line-height:200%;
            margin:30px;
            padding:30px;
            font-size:20px;
        }
        h1{
            margin:0px;
            margin-bottom:30px;
            color:red;
        }
        h2{
            margin:20px;
        }
        #item-num{
            font-size:20px;
        }
        #item-num input{
            height:30px;
        }
        #tot-price{
            font-size:40px;
            color:blue;
            margin-top:30px;
            margin-bottom:30px;
        }

        #provider-info p{
            margin:0px;
            padding:10px;
            line-height:100%;
        }
    </style>
    <script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>
    <script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-carousel.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
    <script>
        function refreshTotalPrice(){
            var price=$("#price").val();
            var item_num=$("#spinner").attr("value");
            $("#tot-price").html(item_num*price + "$");
        }
        $(function(){
            $("#spinner").spinner({
                required:true,
                increment:1,
                min:1
            });
            $("#spinner").keyup(refreshTotalPrice);
            $(".ui-spinner-button").click(refreshTotalPrice);
            refreshTotalPrice();

            $("#purchase_form").submit(
                function(){
                    if($("#is_logged_in").val()=="true"){
                        var num=$("#spinner").val();
                        $("#num").val(num);
                        return true;
                    }
                    alert("Please Log in First.");
                    return  false;
                }
            );
        });
    </script>
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
            <div id="myCarousel" class="carousel slide">
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="active item"><img src="img/example.png" alt="thumbnail 1" width="500" height="99" /></div>
                    <div class="item"><img src="img/example2.jpg" alt="thumbnail 2" width="500" height="99" /></div>
                </div>
                <!-- Carousel nav -->
                <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>
        </div>

        <div class="span6">
            <h1>
                <?php echo($line[0]);?>
            </h1>

            <form id="purchase_form" method="post">
                <?php
                    if($_SESSION["is_logged_in"]==true){
                        echo('<input id="is_logged_in" type="hidden" value="true">');
                    }
                    echo('<input id="user_name" type="hidden" name="user_name" value="'.$_SESSION["user_name"].'">');
                    echo('<input type="hidden" name="isbn" value="'.$isbn.'">');
                ?>

                <div id="item-num">Select Purchase Number <input id="spinner" value="1" name="item_num"></div>
                <div id="tot-price"></div>
                <button class="btn" formaction="cart.php">Add To Cart <i class="icon-shopping-cart"></i></button>
                <button id="direct_checkout" class="btn btn-success" formaction="checkout.php">Purchase Now <i class="icon-star"></i></button>
                <input id="hidden_action" name="action" type="hidden">
            </form>
        </div>

        <div class="span3 well pull-right" id="provider-info">
            <p>PROVIDER</p>
            <p>
                <?php
                echo('name '.$provider_line[0].'</br>');
                echo('email '.$provider_line[1].'</br>');
                echo('phone '.$provider_line[2].'</br>');
                ?>
            </p>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-primary" href="provider_detail.php?id=<?php echo($provider_line[3]); ?>">view details &raquo;</a></p>
        </div>
    </div>

    <div class="row-fluid">
        <div class="well">
            <h2>Book Digest</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <h2>About Author</h2>
            <p>
                <?php
                    echo($line[2]);
                ?>
            </p>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <h2>About Publisher</h2>
            <p>
                <?php
                echo($line[4]);
                ?>
            </p>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
    </div>
</div>

<input type="hidden" id="price" value="<?php echo($line[6]); ?>">

<script>
    function user_submit(){
        $("#user_submit_form").submit();
    }

    function direct_checkout_submit(){
        $("#hidden_action").val("direct");
        return true;
    }

    $(
        function(){
            $("#user_name_href").click(user_submit);
            $("#direct_checkout").click(direct_checkout_submit);
        }
    );
</script>

</body>
</html>