<?php 
require_once "connect.php";
$sqlR = "select * from people_real";
$resR = mysqli_query($conn,$sqlR);
while($rowR = mysqli_fetch_array($resR)){
    $people_name = $rowR["people_name"];
    $people_surname = $rowR["people_surname"];
    echo $sql = "select * from people where people_name like '%".$people_name."%' and people_surname like '%".$people_surname."%'";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($res);
    $people_id = $row["people_id"];
    $people_idR = $rowR["people_id"];
    $sqlUp = "update people_real set people_id = '$people_id' where people_id = '$people_idR'";
    mysqli_query($conn,$sqlUp);
}
