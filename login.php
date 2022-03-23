<?php
require_once "connect.php";
session_start();
$username = $_POST["username"];
$password = $_POST["password"];
if($password == "orderbook") {
    $sql = "select pe.people_id,pe.people_name,pe.people_surname,pr.people_dep_id,pd.people_dep_name 
    from people pe
    inner join people_pro pr on pr.people_id = pe.people_id
    inner join people_dep pd on pd.people_dep_id = pr.people_dep_id
    where pe.people_id = '$username' and pd.people_depgroup_id = 3";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($res);
    $countRow = mysqli_num_rows($res);
    
    if($countRow > 0){
        $_SESSION["people_id"] = $row["people_id"];
        $_SESSION["status"] = "user";
        $_SESSION["dep_id"] = $row["people_dep_id"];
        $_SESSION["dep_name"] = $row["people_dep_name"];
        $_SESSION["username"] = $row["people_name"]." ".$row["people_surname"];
        header("location: form_order.php");
    }
} else {
    header("location: error-page.php?text-error=เข้าสูระบบไม่สำเร็จกรุณาลองใหม่อีกครั้ง <a href='index.php'>เข้าสู่ระบบ</a>");
}
