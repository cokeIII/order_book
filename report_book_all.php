<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>report Book</title>
</head>

<body>
    <?php
    header('Content-Type: text/html; charset=UTF-8');
    require_once "connect.php";
    ?>
    <table border="1">
        <tr>
            <th>ลำดับ</th>
            <th>รหัสวิชา(หนังสือ)</th>
            <th>ชื่อหนังสือ</th>
            <th>ผู้แต่ง</th>
            <th>สำนักพิมพ์</th>
            <th>รหัสวิชาที่สั่ง</th>
            <th>ผู้สั่ง</th>
            <th>ราคา</th>
            <th>จำนวนที่สั่ง</th>
            <th>ราคารวม</th>
        </tr>
        <?php
        $sql = "select *,sum(o.total) as totalSum,o.subject_id as subject_id_o from order_books o
            inner join book b on b.author_id = o.author_id and b.pub_id = o.pub_id and b.subject_id = o.subject_id_book
            inner join people p on p.people_id = o.people_id
            inner join author a on a.author_id = o.author_id
            inner join publisher pu on pu.pub_id  = o.pub_id
            where o.select_no = '1'
            group by b.name_book,o.author_id,o.pub_id and o.status = 1
            ";
        $res = mysqli_query($conn, $sql);
        $i = 1;
        $sumPrice = 0;
        $sumTotal = 0;
        while ($row = mysqli_fetch_array($res)) {
            $sumPrice += $row["totalSum"] * $row["price"];
            $sumTotal += $row["totalSum"];
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row["subject_id_book"]; ?></td>
                <td><?php echo $row["name_book"]; ?></td>
                <td><?php echo $row["author_name"]; ?></td>
                <td><?php echo $row["pub_name"]; ?></td>
                <td><?php echo $row["subject_id_o"]; ?></td>
                <td><?php echo $row["people_name"]; ?></td>
                <td><?php echo number_format($row["price"]); ?></td>
                <td><?php echo number_format($row["totalSum"]); ?></td>
                <td><?php echo number_format($row["totalSum"] * $row["price"]); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th colspan="8">รวม</th>
            <td><?php echo  number_format($sumTotal); ?></td>
            <td><?php echo  number_format($sumPrice); ?></td>
        </tr>
    </table>
</body>

</html>