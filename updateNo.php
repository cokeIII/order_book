<?php 
require_once "connect.php";
$sql = "select * from order_books";
$res = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($res)){
    $people_id = $row["people_id"];
    $subject_id = $row["subject_id"];
    $sql2 = "select * from order_books where 
    people_id='$people_id'
    and subject_id = '$subject_id'
    and status = '1'
    group by subject_id_book,author_id,pub_id
    ";
    $res2 = mysqli_query($conn,$sql2);
    $i = 1;
    while($row2 = mysqli_fetch_array($res2)){
        $select_no = $i++;
        $author_id = $row2["author_id"];
        $pub_id = $row2["pub_id"];
        $people_id = $row2["people_id"];
        $subject_id = $row2["subject_id"];
        $subject_id_book = $row2["subject_id_book"];

        echo $sqlUp = "update order_books set select_no = '$select_no' 
        where term = '1/2565' 
        and author_id='$author_id' 
        and pub_id='$pub_id' 
        and people_id='$people_id' 
        and subject_id = '$subject_id' 
        and subject_id_book ='$subject_id_book'
        ";
        mysqli_query($conn,$sqlUp);
    }
}


