<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>report</title>
</head>

<body>
    <?php
    header('Content-Type: text/html; charset=UTF-8');

    require_once "connect.php";
    $sqldep = "select * from people_real group by dep_name";

    $resDep = mysqli_query($conn, $sqldep);
    while ($rowDep = mysqli_fetch_array($resDep)) {
    ?>
        <table border="1">
            <tr>
                <th colspan="3">
                    <p><?php echo $rowDep["dep_name"]; ?></p>
                </th>
            </tr>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อ</th>
                <th>รายวิชาที่สั่ง</th>
            </tr>
            <?php
            $dep_name = $rowDep["dep_name"];
            $sqlPe = "select * from people_real where dep_name = '$dep_name'";
            $resPe = mysqli_query($conn, $sqlPe);
            $i = 0;
            while ($rowPe = mysqli_fetch_array($resPe)) { ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $rowPe["people_name"] . " " . $rowPe["people_surname"]; ?></td>
                    <td><?php echo checkSubject($rowPe["people_id"]); ?></td>
                </tr>
            <?php } ?>
        </table>
        <br>
    <?php } ?>
</body>

</html>
<?php
function checkSubject($people_id)
{
    global $conn;
    $sqlOrder = "select * from order_books o 
        inner join subject sj on sj.subject_id = o.subject_id
        where o.status = '1' and o.people_id = '$people_id' group by o.subject_id";
    $ret = "";
    $j = 0;
    $resOrder = mysqli_query($conn, $sqlOrder);
    while ($rowOrder = mysqli_fetch_array($resOrder)) {
        $ret .= (++$j) . ". " . $rowOrder["subject_name"] . "<br>";
    }
    return $ret;
}
?>