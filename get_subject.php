<?php
require_once "connect.php";
header('Content-Type: text/html; charset=UTF-8');

$sql = "select * from subject group by subject_id order by subject_id desc";
$res = mysqli_query($conn, $sql);
$opt = '<option value=""> -- เลือกวิชา --</option>';
while ($row = mysqli_fetch_array($res)) {
    $opt .= '<option value="' . $row["subject_id"] . ',' . $row["subject_name"] . '"> (' . $row["subject_id"] . ') ' . $row["subject_name"] . '</option>';
}
echo $opt;
