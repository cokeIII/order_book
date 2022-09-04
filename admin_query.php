<?php
require_once "connect.php";
if (!empty($_POST)) {
    if ($_POST["act"] == "getGroupStd") {
        $group_id = $_POST["group_id"];
        $sql = "select * from group_std_real where group_id = '$group_id'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        $data = array();
        $data["group_id"] = $row["group_id"];
        $data["qty_std"] = $row["qty_std"];
        $data["group_name"] = $row["group_name"];
        $data["level"] = $row["level"];
        $data["major_name"] = $row["major_name"];
        echo json_encode($data);
    } else if ($_POST["act"] == "editGroupStd") {
        $group_id = $_POST["group_id"];
        $qty_std = $_POST["qty_std"];
        $group_name = $_POST["group_name"];
        $level = $_POST["level"];
        $major_name = $_POST["major_name"];

        $sql = "update group_std_real set 
        qty_std = '$qty_std',
        group_name = '$group_name',
        level = '$level',
        major_name = '$major_name'
        where group_id = '$group_id'
        ";

        $res = mysqli_query($conn, $sql);
        if ($res) {
            header("location: admin.php");
        } else {
            echo $sql;
        }
    } else if ($_POST["act"] == "delGroupStd") {
        $group_id = $_POST["group_id"];
        $sql = "delete from group_std_real where group_id='$group_id'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            header("location: admin.php");
        } else {
            echo $sql;
        }
    } else if ($_POST["act"] == "insertGroupStd") {
        $group_id = $_POST["group_id"];
        $qty_std = $_POST["qty_std"];
        $group_name = $_POST["group_name"];
        $level = $_POST["level"];
        $major_name = $_POST["major_name"];

        $sql = "insert into group_std_real
        (group_id,qty_std,group_name,level,major_name)
        values(
            '$group_id',
            '$qty_std',
            '$group_name',
            '$level',
            '$major_name'
        )
        ";

        $res = mysqli_query($conn, $sql);
        if ($res) {
            header("location: admin.php");
        } else {
            echo $sql;
        }
    }
}
