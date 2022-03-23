<?php
require_once "connect.php";

$subject_id = $_POST["subject_id"];
$people_id = $_POST["people_id"];
$term = $_POST["term"];

$sql = "delete from order_books where 
people_id = '$people_id'
and subject_id = '$subject_id' 
and term = '$term'
and status = 1";
$res = mysqli_query($conn,$sql);
if($res){
    header("location: list_orders.php");
}
