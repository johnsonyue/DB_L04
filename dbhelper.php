<?php
error_reporting(0);

class DBHelper
{
    function connectDB()
    {
        $link = mysql_connect("localhost", "root", "");
        if (!link) {
            die("Failed to connect to DB" . mysql_error() . "<br/>");
        }
        if (!mysql_select_db("book_store")) {
            die("Cannot choose DB" . mysql_error() . "<br/>");
        }
    }

    function getCustomerByName($name){
        $sql='SELECT * FROM customer WHERE name="'.$name.'"';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Insertion failed! " . mysql_error() . "</br>");
        }
        return $rs;
    }

    function authenticateCustomer($name, $pw){
        $sql='SELECT * FROM customer WHERE name="'.$name.'" and pw_hash="'.$pw.'"';
        $rs = mysql_query($sql);
        $row= mysql_num_rows($rs);
        if (!$rs) {
            die("Insertion failed! " . mysql_error() . "</br>");
        }
        if($row==0){
            return false;
        }
        else{
            return true;
        }
    }

    function insertCustomer($name, $pw, $email, $phone)
    {
        $sql = 'INSERT INTO customer VALUE (NULL,"' . $name . '","' . $pw . '","' . $email . '","' . $phone . '")';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Insertion failed! " . mysql_error() . "</br>");
        }
    }

    function getBookByISBN($isbn)
    {
        $sql = 'SELECT book.name,author.id,author.name,publisher_id,publisher.name,publish_date,price FROM book,written_by,author,publisher WHERE book.ISBN=' . $isbn . ' and ' . "written_by.ISBN=book.ISBN and written_by.author_id=author.id and publisher.id=book.publisher_id";
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getBookByTitle($title)
    {
        $sql = 'SELECT book.ISBN,book.name,author.id,author.name,publisher_id,publisher.name,publish_date,price FROM book,written_by,author,publisher WHERE book.name like "%' . $title . '%" and ' . "written_by.ISBN=book.ISBN and written_by.author_id=author.id and publisher.id=book.publisher_id";
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getBookByAuthor($name)
    {
        $sql = 'SELECT book.ISBN,book.name,author.id,author.name,publisher_id,publisher.name,publish_date,price FROM book,written_by,author,publisher WHERE author.name like "%' . $name . '%" and ' . "written_by.ISBN=book.ISBN and written_by.author_id=author.id and publisher.id=book.publisher_id";
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getBookByPublisher($name)
    {
        $sql = 'SELECT book.ISBN,book.name,author.id,author.name,publisher_id,publisher.name,publish_date,price FROM book,written_by,author,publisher WHERE publisher.name like "%' . $name . '%" and ' . "written_by.ISBN=book.ISBN and written_by.author_id=author.id and publisher.id=book.publisher_id";
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getRecommendedBook()
    {
        $sql = 'SELECT book.ISBN,book.name,author.id,author.name,publisher_id,publisher.name,publish_date,price FROM book,written_by,author,publisher WHERE ' . "written_by.ISBN=book.ISBN and written_by.author_id=author.id and publisher.id=book.publisher_id LIMIT 20";
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getAuthor()
    {
        $sql = 'SELECT * FROM author';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getAuthorById($id){
        $sql = 'SELECT * FROM author WHERE id='.$id;
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getPublisher()
    {
        $sql = 'SELECT * FROM publisher';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getPublisherById($id){
        $sql = 'SELECT * FROM publisher WHERE id='.$id;
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getProviderByISBN($isbn){
        $sql='SELECT name,email,phone,id FROM sell,provider WHERE sell.ISBN='.$isbn.' and provider_id=id';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getProviderById($id){
        $sql='SELECT name,email,phone FROM provider WHERE id='.$id;
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getBookByProvider($id){
        $sql = 'SELECT book.ISBN,book.name,author.id,author.name,publisher_id,publisher.name,publish_date,price FROM sell,book,written_by,author,publisher WHERE sell.provider_id=' . $id . ' and sell.ISBN=book.ISBN and ' . 'written_by.ISBN=book.ISBN and written_by.author_id=author.id and publisher.id=book.publisher_id';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function putBookIntoCart($isbn,$cart_id,$item_num){
        $sql='INSERT INTO put_into VALUE("'.$isbn.'",'.$cart_id.','.$item_num.')';
        $rs = mysql_query($sql);
        if (!$rs) {
            //die("Search failed! " . mysql_error() . "</br>");
            return false;
        }
        return true;
    }

    function getIdByName($name){
        $sql='SELECT id FROM customer WHERE name="'.$name.'"';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }
        $line=mysql_fetch_row($rs);
        return $line[0];
    }

    function getBookByCart($cart_id){
        $sql = 'SELECT book.ISBN,book.name,author.id,author.name,publisher_id,publisher.name,publish_date,price,item_num FROM put_into,book,written_by,author,publisher WHERE put_into.cart_id=' . $cart_id . ' and put_into.ISBN=book.ISBN and ' . 'written_by.ISBN=book.ISBN and written_by.author_id=author.id and publisher.id=book.publisher_id';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function deleteItemInCart($isbn, $cart_id){
        $sql = 'DELETE FROM put_into WHERE cart_id='.$cart_id.' and isbn="'.$isbn.'"';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }
    }

    function generateOrderFromCart($cart_id, $isbn){
        $sql = 'SELECT price,item_num,book.ISBN FROM put_into,book WHERE put_into.ISBN=book.ISBN and put_into.cart_id='.$cart_id;
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }
        $row=mysql_num_rows($rs);

        $tot_price=0;
        for($i=0;$i<$row;$i++){
            $line=mysql_fetch_row($rs);
            $tot_price+=$line[0]*$line[1];
        }

        $time=date("Y-m-d H:i:s");
        $sql2 = 'INSERT INTO order_form VALUE(NULL,'.$cart_id.',"'.$time.'",'.$tot_price.')';
        $rs2 = mysql_query($sql2);
        if (!$rs2) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        $sql3 = 'SELECT id FROM order_form WHERE cart_id='.$cart_id.' and time="'.$time.'"';
        $rs3 = mysql_query($sql3);
        if (!$rs3) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        $line2=mysql_fetch_row($rs3);
        $order_id=$line2[0];

        for($i=0;$i<sizeof($isbn);$i++){
            $sql4 = 'INSERT INTO consist_of (SELECT '.$order_id.', ISBN, item_num FROM put_into WHERE cart_id='.$cart_id.' and ISBN="'.$isbn[$i].'")';
            $rs4 = mysql_query($sql4);
            if (!$rs4) {
                die("Search failed! " . mysql_error() . "</br>");
            }
        }

        for($i=0;$i<sizeof($isbn);$i++) {
            $sql5 = 'DELETE FROM put_into WHERE cart_id=' . $cart_id.' and ISBN="'.$isbn[$i].'"';
            $rs5 = mysql_query($sql5);
            if (!$rs5) {
                die("Search failed! " . mysql_error() . "</br>");
            }
        }
    }

    function generateOrderFromBook($id, $num, $isbn){
        $sql = 'SELECT price FROM book WHERE isbn="'.$isbn.'"';
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }
        $line=mysql_fetch_row($rs);
        $tot_price=$line[0]*$num;

        $time=date("Y-m-d H:i:s");
        $sql2 = 'INSERT INTO order_form VALUE(NULL, '.$id.',"'.$time.'",'.$tot_price.')';
        $rs2 = mysql_query($sql2);
        if (!$rs2) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        $sql3 = 'SELECT id FROM order_form WHERE cart_id='.$id.' and time="'.$time.'"';
        $rs3 = mysql_query($sql3);
        if (!$rs3) {
            die("Search failed! " . mysql_error() . "</br>");
        }
        $line2 = mysql_fetch_row($rs3);

        $sql4 = 'INSERT INTO consist_of VALUE('.$line2[0].', "'.$isbn.'", '.$num.')';
        $rs4 = mysql_query($sql4);
        if (!$rs4) {
            die("Search failed! " . mysql_error() . "</br>");
        }
    }

    function getOrderByCustomer($id){
        $sql = 'SELECT id,time,total_price FROM order_form WHERE cart_id='.$id;
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function getBookByOrder($id){
        $sql = 'SELECT name,item_num FROM book,consist_of WHERE consist_of.ISBN=book.ISBN and order_id='.$id;
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        return $rs;
    }

    function deleteOrder($id){
        $sql = 'DELETE FROM consist_of WHERE order_id='.$id;
        $rs = mysql_query($sql);
        if (!$rs) {
            die("Search failed! " . mysql_error() . "</br>");
        }

        $sql2 = 'DELETE FROM order_form WHERE id='.$id;
        $rs2 = mysql_query($sql2);
        if (!$rs2) {
            die("Search failed! " . mysql_error() . "</br>");
        }
    }

    function getAuthorWorksNum($id){
        $sql = 'SELECT COUNT(ISBN) FROM author, written_by WHERE written_by.author_id=author.id and author.id='.$id.' GROUP BY written_by.author_id ';
        $rs = mysql_query($sql);
        if(!$rs){
            die("Search failed! " . mysql_error() . "</br>");
        }
        $line=mysql_fetch_row($rs);
        return $line[0];
    }
}
?>