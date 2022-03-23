<?php
require_once "connect.php";

$subject_id_book = $_POST["subject_id_book"];
$author_id = $_POST["author_id"];
$pub_id = $_POST["pub_id"];
$people_id = $_POST["people_id"];
$student_group_id = $_POST["student_group_id"];

$sql = "delete from order_books where 
subject_id_book = '$subject_id_book'
and author_id = '$author_id'
and pub_id = '$pub_id'
and people_id = '$people_id'
and student_group_id = '$student_group_id'
and status = 0";

$res = mysqli_query($conn,$sql);
if($res){
    header("location: book_pick.php");
}
