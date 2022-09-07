<?php
require_once "connect.php";
session_start();

$subject_id_book = $_POST["subject_id_book"];
$author_id = $_POST["author_id"];
$pub_id = $_POST["pub_id"];
$people_id = $_POST["people_id"];
$student_group_id = $_POST["student_group_id"];
$subject = $_POST["subject"];
$subjectArr = explode(",", $subject);
$subject_id = $subjectArr[0];
$subject_name = $subjectArr[1];
$note = $_POST["note"];
$total = count_group_std($_POST["student_group_id"]);
$dep_name = $_SESSION["dep_name"];
if ($note == "อื่นๆ") {
    $note = $_POST["other"];
}

$term = $_POST["term"];
$NO = getNO($subject_id, $term, $people_id);
$sql = "insert into order_books 
    (
        subject_id,
        subject_name,
        subject_id_book,
        author_id,
        pub_id, 
        people_id, 
        student_group_id,
        note,
        status,
        term,
        total,
        dep_name,
        select_no
     ) value(
        '$subject_id',
        '$subject_name',
        '$subject_id_book',
        '$author_id',
        '$pub_id',
        '$people_id',
        '$student_group_id',
        '$note',
        '0',
        '$term',
        '$total',
        '$dep_name',
        '$NO'
    )";

$res = mysqli_query($conn, $sql);
if ($res) {
    header("location: book_pick.php");
}

function count_group_std($group_id)
{
    global $conn;
    // $sql = "select count(student_id) as countStd from student where status = '0' and  group_id = '$group_id'";
    $sql = "select qty_std from group_std_real where group_id = '$group_id'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["qty_std"];
}
function getNO($subject_id, $term, $people_id)
{
    global $conn;
    $sqlNo = "select count(order_id) as getNo from order_books where subject_id = '$subject_id' and term = '$term' and people_id = '$people_id'";
    $resNo = mysqli_query($conn, $sqlNo);
    $NO = mysqli_fetch_array($resNo);
    return $NO["getNo"] + 1;
}
