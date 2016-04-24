<?php
    include "dbhelper.php";
    $action=$_GET["action"];
    $select=$_GET["select"];
    $helper=new DBHelper();
    $helper->connectDB();
    if($action=="search" && $select=="0"){
        $key=$_GET["key"];
        $rs=$helper->getBookByTitle($key);
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
    }
    else if($action=="search" && $select=="1"){
        $key=$_GET["key"];
        $rs=$helper->getBookByAuthor($key);
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
    }
    else if($action=="search" && $select=="2"){
        $key=$_GET["key"];
        $rs=$helper->getBookByPublisher($key);
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
    }
    else{
        $rs=$helper->getRecommendedBook();
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
    }

?>