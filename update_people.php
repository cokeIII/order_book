<?php
require_once "connect.php";
header('Content-Type: text/html; charset=utf-8');
function getDep($p_id)
{
    global $conn;
    echo $sql = "select * people_pro pr
    inner join people_dep pd on pd.people_dep_id = pr.people_dep_id
    where pr.people_id = '$p_id' and pd.people_depgroup_id = 3
    ";
    echo "<br>";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["people_dep_name"];
}
$sqlCheckP = "select * from people p
where p.people_id not in(select pl.people_id from people_real pl)";
$resCheckP = mysqli_query($conn, $sqlCheckP);
while ($rowCheckP = mysqli_fetch_array($resCheckP)) {
    echo "-----------------------INSERT-------------------------------<br>";
    $people_id = $rowCheckP["people_id"];
    $people_name = $rowCheckP["people_name"];
    $people_surname = $rowCheckP["people_surname"];
    $people_dep_name = getDep($people_id);
    $sqlAddP = "insert into people_real 
    (people_name,people_surname,dep_name)
    value('$people_name','$people_surname','$people_dep_name')
    ";
    mysqli_query($conn, $sqlAddP);
}
echo "-----------------------UPDATE-------------------------------<br>";
$sqlR = "select * from people_real";
$resR = mysqli_query($conn, $sqlR);
while ($rowR = mysqli_fetch_array($resR)) {
    $people_name = $rowR["people_name"];
    $people_surname = $rowR["people_surname"];
    echo $sql = "select * from people where people_name like '%" . $people_name . "%' and people_surname like '%" . $people_surname . "%'";
    echo "<br>";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $people_id = $row["people_id"];
    $people_idR = $rowR["people_id"];
    echo $sqlUp = "update people_real set people_id = '$people_id' where people_name like '%" . $people_name . "%' and people_surname like '%" . $people_surname . "%'";
    mysqli_query($conn, $sqlUp);
    echo "<br>";
}
