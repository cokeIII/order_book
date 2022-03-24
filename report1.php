<?php
// header("Content-type:application/pdf");
require_once 'vendor/autoload.php';
require_once 'vendor/mpdf/mpdf/mpdf.php';
require_once "connect.php";
//custom font
// session_start();
header('Content-Type: text/html; charset=UTF-8');
error_reporting(error_reporting() & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
$terms = $_POST["term"];
$usernames = $_POST["username"];
$people_ids = $_POST["people_id"];
$fontData = $defaultFontConfig['fontdata'];
$sql = "select subject_id,subject_name,subject_id_book from order_books 
where status = 0 and term = '$terms' and people_id='$people_ids' group by subject_id,subject_name";
$res = mysqli_query($conn, $sql);
$termArr = explode("/", $terms);
session_start();
$mpdf = new mPDF();
ob_start();
?>

<style>
    page-break {
        page-break-after: auto
    }

    .content-text {
        font-size: 20px;
        font-family: "thsarabun";
    }

    div,
    table {
        font-family: "thsarabun";
    }

    .text-center {
        text-align: center;
    }

    .table,
    tr,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }

    .table-nobor {
        border: 0px solid black;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }

    .no-bor {
        border: 0px solid black;
    }

    .w-100 {
        width: 100%;
    }
    .text-right {
        text-align: right;
    }
</style>
<?php
while ($row = mysqli_fetch_array($res)) {

    $subject_id = $row["subject_id"];
    $subject_name = $row["subject_name"];
    $sqlData = "select 
*,sum(o.total) as sumStd
from order_books o
inner join book b on b.author_id = o.author_id and b.pub_id = o.pub_id and b.subject_id = o.subject_id_book
inner join people p on p.people_id = o.people_id
inner join author a on a.author_id = o.author_id
inner join publisher pu on pu.pub_id  = o.pub_id
where o.people_id = '$people_ids' and o.status = '0' and o.term = '$terms' and o.subject_id = '$subject_id' and o.subject_name = '$subject_name' group by o.subject_id_book,b.name_book limit 3";
    $resData = mysqli_query($conn, $sqlData);
    $resData2 = mysqli_query($conn, $sqlData);
    $rowData = mysqli_fetch_array($resData);
?>
    <div class="content-text text-center">
        <div><strong>แบบเสนอรายชื่อหนังสือเรียนเพื่อประกอบการพิจารณาการจัดซื้อสำหรับครูผู้สอน</strong></div>
        <div><strong>ตามโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษาตั้งแต่ระดับอนุบาลจนจบการศึกษาขั้นพื้นฐาน</strong></div>
        <div><strong>ภาคเรียนที่ <?php echo $termArr[0]; ?></strong><strong> ปีการศึกษา <?php echo $termArr[1]; ?></strong></div>
        <div><strong>รหัสวิชา <?php echo $subject_id; ?> ชื่อวิชา <?php echo $rowData["subject_name"]; ?> ระดับชั้น <?php echo $rowData["grade_name"]; ?> ครูผู้สอน <?php echo $usernames; ?></strong></div>
    </div>
    <table class="table content-text text-center w-100">
        <tr>
            <th rowspan="2">ลำดับที่</th>
            <th colspan="2">ข้อมูลการอนุญาติ</th>
            <th rowspan="2">ชื่อผู้แต่ง</th>
            <th rowspan="2">สำนักพิมพ์</th>
            <th colspan="3">สำนักพิมพ์</th>
            <th colspan="3">รูปแบบการพิมพ์</th>
            <th colspan="3">ขนาดรูปเล่ม</th>
            <th rowspan="2">ราคา</th>
            <th rowspan="2">จำนวน</th>
            <th rowspan="2">เหตุผลที่เลือก</th>
        </tr>
        <tr>
            <th>ลำดับที่</th>
            <th>ปี พ.ศ.</th>
            <th>ปอนด์</th>
            <th>ถนอมสายตา</th>
            <th>อาร์ต</th>
            <th>1 สี</th>
            <th>2 สี</th>
            <th>4 สี</th>
            <th>8 หน้ายก</th>
            <th>A4</th>
            <th>อื่นๆ</th>
        </tr>
        <?php $i = 1;
        while ($rowData2 = mysqli_fetch_array($resData2)) {
            $sqlUpstatus = "update order_books set status = '1' where people_id = '$people_ids' and status = '0' and term = '$terms' and subject_id = '$subject_id'";
            mysqli_query($conn, $sqlUpstatus);
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $rowData2["no"]; ?></td>
                <td><?php echo $rowData2["year_edu"]; ?></td>
                <td><?php echo $rowData2["author_name"]; ?></td>
                <td><?php echo $rowData2["pub_name"]; ?></td>
                <td><?php if ($rowData2["paper_pattern"] == "ปอนด์") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["paper_pattern"] == "ถนอมสายตา") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["paper_pattern"] == "อาร์ต") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["print_pattern"] == "1 สี") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["print_pattern"] == "2 สี") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["print_pattern"] == "4 สี") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["size_book"] == "8 หน้ายก") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["size_book"] == "A4") {
                        echo "/";
                    }; ?></td>
                <td><?php if ($rowData2["size_book"] == "อื่นๆ") {
                        echo "/";
                    }; ?></td>
                <td><?php echo $rowData2["price"]; ?></td>
                <td><?php echo $rowData2["sumStd"]; ?></td>
                <td><?php echo $rowData2["note"]; ?></td>

            </tr>
        <?php $i++;
        } ?>
        <?php
        if ($i - 1 == 1) {
            echo "<tr>
            <td>$i</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>";
            echo "<tr>
            <td>" . ($i + 1) . "</td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>";
        } else if ($i - 1 == 2) {
            echo "<tr>
            <td>$i</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>";
        }

        ?>
    </table>
    <div class="content-text">
        <p><strong><u>หมายเหตุ</u></strong> ลำดับที่เลือกอันดับแรกเป็นหนังสือที่มีความต้องการจัดซื้อ</p>
        <p>กรณีผู้สอนเสนอรายชื่อหนังสือน้อยกว่า 3 เล่ม เนื่องจาก............................................................................................................................................................................................................</p>
        <table class="table-nobor content-text w-100 text-center">
            <tr class="no-bor">
                <td class="no-bor"><br>ลงชื่อ.......................................................ครูผู้สอน</td>
                <td class="no-bor"><br>ลงชื่อ.......................................................ครูผู้สอน</td>
                <td class="no-bor"><br>ลงชื่อ.......................................................ครูผู้สอน</td>
            </tr>
            <tr class="no-bor">
                <td class="no-bor">(<?php echo $usernames; ?>)</td>
                <td class="no-bor">(.....................................................)</td>
                <td class="no-bor">(.....................................................)</td>
            </tr>

            <tr class="no-bor">
                <td class="no-bor" colspan="3"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ.......................................................หัวหน้าแผนกวิชา</td>
            </tr>
            <tr class="no-bor">
                <td class="no-bor" colspan="3">(<?php echo $_SESSION["leader"];?>)</td>
            </tr>
        </table>
    </div>
    <pagebreak type="NEXT-ODD" resetpagenum="1" pagenumstyle="i" suppress="off" />
<?php

}
?>
<?php
$mpdf->SetHTMLHeader("<div class='content-text text-right'>แบบฟอร์ม สมอ.1</div>");
$html = ob_get_contents();
$mpdf->AddPage('L');
$mpdf->WriteHTML($html);
$taget = "pdf/report1.pdf";
$mpdf->Output($taget);
ob_end_flush();
echo "<script>window.location.href='$taget';</script>";
exit;
?>