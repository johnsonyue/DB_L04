<body>

<?php
    include "dbhelper.php";
    $helper=new DBHelper();
    $helper->connectDB();
    $action=$_POST["action"];

    session_start();
    $user_name=$_POST["user_name"];

    if($action=="register") {
        $rs = $helper->getCustomerByName($_POST["user_name"]);
        if (mysql_num_rows($rs) != 0) {
            echo('<p style="font-size:30px;">');
            echo("User Already Exists!</br></p>");
            echo('<input id="link" value="register.html" type="hidden">');
        } else {
            $helper->insertCustomer($_POST["user_name"], $_POST["password"], $_POST["phone"], $_POST["email"]);
            echo('<p style="font-size:30px;">');
            echo("Successful Registration</br></p>");
            echo('<input id="link" value="index.php" type="hidden">');
        }
        if( !isset($_SESSION["user_name"]) ){
            $_SESSION["user_name"]=$user_name;
        }
        if( !isset($_SESSION["is_logged_in"])){
            $_SESSION["is_logged_in"]=true;
        }
    }
    else if($action=="login"){
        if($helper->authenticateCustomer($_POST["user_name"], $_POST["password"])) {
            echo('<p style="font-size:30px;">');
            echo("Successfully Logged In.</br></p>");
            echo('<input id="link" value="index.php" type="hidden">');

            $_SESSION["user_name"] = $user_name;
            $_SESSION["is_logged_in"] = true;
        }
        else{
            echo('<p style="font-size:30px;">');
            echo("Wrong name or password!</br></p>");
            echo('<input id="link" value="index.php" type="hidden">');

            $_SESSION["is_logged_in"] = false;
        }
    }
    else if($action=="logout"){
        $_SESSION["is_logged_in"] = false;
        echo('<p style="font-size:30px;">');
        echo("Logged out.</br></p>");
        echo('<input id="link" value="index.php" type="hidden">');
    }
?>

<div id="count-down" style="font-size:20px"></div>

<script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>
<script>
    var i=2;
    var interval_id=setInterval("count_down();",1000);

    function count_down(){
        if(i==0){
            window.location.href=$("#link").val();
            clearInterval(interval_id);
        }
        $("#count-down").html("Auto Redirect in "+i+" Second(s)");
        i--;
    }

</script>

</body>