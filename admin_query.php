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
        $sql = "update ";

    }
}
