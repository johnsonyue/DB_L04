<?php
include "dbhelper.php";
$helper=new DBHelper();
$helper->connectDB();
$rs=$helper->getPublisher();
$row=mysql_num_rows($rs);
$col=mysql_num_fields($rs);

for($i=0;$i<$row;$i++){
    $line=mysql_fetch_row($rs);
    echo ('<tr>');
    echo ('<td class="td-img"><img src="img/hit.jpg"></td>');
    echo('<td class="td-text"><a href="publisher_detail.php?id='.$line[0].'">'.$line[1].'</a></td>');
    for($j=2;$j<$col;$j++){
        echo('<td class="td-text">'.$line[$j].'</td>');
    }
    echo ('</tr>');
}