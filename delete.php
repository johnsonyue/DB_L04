<?php
error_reporting(0);

include "dbhelper.php";
$helper=new DBHelper();
$helper->connectDB();
if(isset($_POST["id"]) && isset($_POST["isbn"])){
    $arr_isbn=explode('|',$_POST["isbn"]);
    for($i=0;$i<sizeof($arr_isbn);$i++){
        $helper->deleteItemInCart($arr_isbn[$i], $_POST["id"]);
    }
    header("Location:index.php");
}
else if(!isset($_POST["id"])){
    echo('<p style="font-size:20px">Bad Parameters</p>');
    exit();
}
?>