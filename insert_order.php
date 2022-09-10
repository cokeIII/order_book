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
$price = $_POST["price"];
$qty_page = $_POST["qty_page"];
$total = count_group_std($_POST["student_group_id"]);
$dep_name = $_SESSION["dep_name"];
if ($note == "อื่นๆ") {
    $note = $_POST["other"];
}

$term = $_POST["term"];
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
        price,
        qty_page
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
        '$price',
        '$qty_page'
    )";

$res = mysqli_query($conn, $sql);
if ($res) {
    updateNO($subject_id, $term, $people_id,$subject_id_book,$author_id,$pub_id);
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
function updateNO($subject_id, $term, $people_id,$subject_id_book,$author_id,$pub_id)
{
    global $conn;
    $sqlNo = "select count(order_id) as getNo from order_books where subject_id = '$subject_id' and term = '$term' and people_id = '$people_id' group by subject_id_book,author_id,pub_id";
    // $sqlNo = "select count(order_id) as getNo from order_books where subject_id = '$subject_id' and term = '$term' and people_id = '$people_id'";
    $resNo = mysqli_query($conn, $sqlNo);
    $NO = mysqli_fetch_array($resNo);
    $noNum = mysqli_num_rows($resNo);
    if($noNum == 0) {
        $noNum = 1;
    }
    echo $sqlUp = "update order_books set select_no = '$noNum' 
    where subject_id_book = '$subject_id_book' and
    author_id = '$author_id' and 
    pub_id = '$pub_id' and 
    people_id = '$people_id' and
    term = '$term' and
    subject_id = '$subject_id' and
    status = 0
    ";
    mysqli_query($conn,$sqlUp);
    // return $NO["getNo"] + 1;
    // return $noNum;
}
