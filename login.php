<?php
require_once "connect.php";
session_start();
$username = $_POST["username"];
$password = $_POST["password"];
if ($username == "admin" && $password == "adminbook") {
    header("location: admin.php");
    $_SESSION["status"] = "admin";
} else if ($password == "orderbook") {
    echo $sql = "select pe.people_id,pe.people_name,pe.people_surname,pr.people_id,pr.dep_name 
    from people pe
    inner join people_real pr on pr.people_id = pe.people_id
    where pe.people_id = '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $countRow = mysqli_num_rows($res);

    if ($countRow > 0) {
        $_SESSION["people_id"] = $row["people_id"];
        $_SESSION["status"] = "user";
        $_SESSION["leader"] = get_leader($row["dep_name"]);
        $_SESSION["dep_name"] = $row["dep_name"];
        $_SESSION["username"] = $row["people_name"] . " " . $row["people_surname"];
        header("location: form_order.php");
    } else {
        //header("location: error-page.php?text-error=เข้าสูระบบไม่สำเร็จกรุณาลองใหม่อีกครั้ง <a href='index.php'>เข้าสู่ระบบ</a>");
    }
} else {
    header("location: error-page.php?text-error=เข้าสูระบบไม่สำเร็จกรุณาลองใหม่อีกครั้ง <a href='index.php'>เข้าสู่ระบบ</a>");
}
function get_leader($dep_name)
{
    global $conn;
    $sql = "select * from people_real where dep_name = '$dep_name' and dep_status = '1'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["people_name"] . " " . $row["people_surname"];
}
