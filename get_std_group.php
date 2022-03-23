<?php
require_once "connect.php";
header('Content-Type: text/html; charset=UTF-8');

// $subject_id = $_POST["subject_id"];
// $people_id = $_POST["people_id"];
// $term = $_POST["term"];
// $sql = "select * from student_group order by student_group_id desc";
// $res = mysqli_query($conn, $sql);
// $opt = '<option value=""> -- เลือกกลุ่มเรียน --</option>';
// while ($row = mysqli_fetch_array($res)) {
//     if (substr($row['student_group_id'], 2, 1) == 2) {
//         $opt .= '<option value="' . $row["student_group_id"].'"> (' . $row["student_group_id"] . ') ' . $row["student_group_short_name"].'</option>';
//     }
// }
$sql = "select * from group_std_real order by group_id desc";
$res = mysqli_query($conn, $sql);
$opt = '<option value=""> -- เลือกกลุ่มเรียน --</option>';
while ($row = mysqli_fetch_array($res)) {
    // if (substr($row['group_id'], 2, 1) == 2) {
        $opt .= '<option value="' . $row["group_id"] . '"> (' . $row["group_id"] . ') ' . $row["level"] .' กลุ่ม '.$row["group_name"].' '.$row["major_name"].'</option>';
    // }
}
echo $opt;
