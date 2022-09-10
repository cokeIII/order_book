<?php
require_once "connect.php";
$sql = "select * from order_books o
inner join book b on b.author_id = o.author_id and b.pub_id = o.pub_id and b.subject_id = o.subject_id_book
where order_id != 868 
";
$res = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($res)){
    $order_id = $row["order_id"];
    $price = $row["price"];
    $qty_page = $row["qty_page"];
    echo $sqlUp = "update order_books set price = '$price', qty_page = '$qty_page' where order_id = '$order_id'";
    mysqli_query($conn,$sqlUp);
}