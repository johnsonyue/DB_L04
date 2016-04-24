<?php
error_reporting(0);

include "dbhelper.php";
$helper=new DBHelper();
$helper->connectDB();
if(isset($_POST["order_id"])){
    $id=$_POST["order_id"];
    $helper->deleteOrder($id);
    header("Location:index.php");
}
else if(!isset($_POST["id"])){
    echo('<p style="font-size:20px">Bad Parameters</p>');
    exit();
}
?>