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
                <th colspan="8">
                    <p><?php echo "รายชื่อหนังสือที่สั่ง เฉพาะ ปวช.1 ".$rowDep["dep_name"]; ?></p>
                </th>
            </tr>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อ</th>
                <th>ผู้แต่ง</th>
                <th>สำนักพิมพ์</th>
                <th>ราคา</th>
                <th>ราคารวม</th>
                <th>จำนวนที่สั่ง</th>
                <th>ชื่อผู้สั่ง</th>
            </tr>
            <?php
            $dep_name = $rowDep["dep_name"];
            $sqlBo = "select *,sum(total) as totalSum from order_books o
            inner join book b on b.author_id = o.author_id and b.pub_id = o.pub_id and b.subject_id = o.subject_id_book
            inner join author a on a.author_id = o.author_id
            inner join publisher pu on pu.pub_id  = o.pub_id
            inner join people p on p.people_id = o.people_id
            inner join group_std_real sg on sg.group_id = o.student_group_id

            where o.dep_name = '$dep_name' and sg.level = 'ปวช.1' group by o.subject_id,o.people_id";
            $resBo = mysqli_query($conn, $sqlBo);
            $i = 0;
            while ($rowBo = mysqli_fetch_array($resBo)) { ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $rowBo["name_book"]; ?></td>
                    <td><?php echo $rowBo["author_name"];?></td>
                    <td><?php echo $rowBo["pub_name"];?></td>
                    <td><?php echo $rowBo["price"];?></td>
                    <td><?php echo $rowBo["totalSum"];?></td>
                    <td><?php echo number_format($rowBo["totalSum"]*$rowBo["price"]);?></td>
                    <td><?php echo $rowBo["people_name"]." ".$rowBo["people_surname"]; ?></td>
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