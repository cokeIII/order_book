<?php

require_once 'vendor/autoload.php';
require_once 'vendor/mpdf/mpdf/mpdf.php';
require_once "connect.php";
// header("Content-type:application/pdf");
//custom font
header('Content-Type: text/html; charset=UTF-8');
error_reporting(error_reporting() & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
session_start();
$mpdf = new mPDF();
ob_start();
// $mpdf = new \Mpdf\Mpdf();
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
iconv_set_encoding('internal_encoding', 'UTF-8');
iconv_set_encoding('output_encoding', 'UTF-8');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
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
        font-family: "thsarabun";
    }

    .table,
    tr,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
        font-family: "thsarabun";
    }

    .table-nobor {
        border: 0px solid black;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
        font-family: "thsarabun";
    }

    .no-bor {
        border: 0px solid black;
    }

    .w-100 {
        width: 100%;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .content-text-bottom {
        font-size: 20px;
    }
</style>
<?php
$term = $_SESSION["term"];
$termArr = explode("/", $term);
// $dep_id = $_SESSION["dep_id"];
$dep_name = $_SESSION["dep_name"];
$sql = "select 
o.people_id,
o.subject_id_book,
b.name_book,
a.author_name,
pu.pub_name,
b.price,
sum(o.total) as sumTotal,
pe.people_name,
pe.people_surname
from order_books o
inner join people pe on pe.people_id = o.people_id
inner join author a on a.author_id = o.author_id
inner join publisher pu on pu.pub_id  = o.pub_id
inner join book b on b.author_id = o.author_id and b.pub_id = o.pub_id and b.subject_id = o.subject_id_book
where o.dep_name = '$dep_name' and o.term = '$term' and select_no = '1' and o.status = '1' group by b.name_book,o.author_id,o.pub_id
";
$res = mysqli_query($conn, $sql);
?>
<div class="content-text text-center">
    <div><strong>แบบรายงานการเลือกซื้อหนังสือเรียนของสถานศึกษา</strong></div>
    <div><strong>ตามโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษาตั้งแต่ระดับอนุบาลจนจบการศึกษาขั้นพื้นฐาน</strong></div>
    <div><strong>ภาคเรียนที่ <?php echo $termArr[0]; ?> ปีการศึกษา <?php echo $termArr[1]; ?></strong></div>
    <table class="table content-text text-center">
        <tr>
            <th rowspan="2">วิชาที่</th>
            <th rowspan="2">รหัสวิชา</th>
            <th rowspan="2">ชื่อวิชา</th>
            <th rowspan="2" width="20%">ชื่อผู้แต่ง</th>
            <th rowspan="2">สำนักพิมพ์</th>
            <th rowspan="2">ราคา</th>
            <th rowspan="2">จำนวน</th>
            <th rowspan="2">ชื่อครูผู้สอน</th>
            <th colspan="2">ผลการพิจารณาของ
                คณะกรรมการ/
                ภาคี 4 ฝ่าย</th>
        </tr>
        <tr>
            <td>เห็นชอบ</td>
            <td>ไม่เห็นชอบ</td>
        </tr>
        <?php $i = 1;
        $dataCheck = array();
        while ($row = mysqli_fetch_array($res)) {
            $dataCheck["people_id"]
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row["subject_id_book"]; ?></td>
                <td class="text-left"><?php echo $row["name_book"]; ?></td>
                <td class="text-left"><?php echo $row["author_name"]; ?></td>
                <td class="text-left"><?php echo $row["pub_name"]; ?></td>
                <td><?php echo $row["price"]; ?></td>
                <td><?php echo $row["sumTotal"]; ?></td>
                <td class="text-left"><?php echo $row["people_name"] . " " . $row["people_surname"]; ?></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            if (($i - 1) % 9 == 0) {
            ?>

        <?php
            }
        } ?>
    </table>
    <?php
    $html1 = ob_get_contents();
    ob_clean();
    ?>
    <br>
    <table class="content-text-bottom text-center" width="100%">
        <tr class="no-bor">
            <td class="no-bor " colspan="2">ผู้จัดทำข้อมูล ลงชื่อ.......................................................หัวหน้าแผนกวิชา
            </td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor" colspan="2">(<?php echo $_SESSION["leader"]; ?>)
            </td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor text-left" colspan="2"> ความเห็นคณะกรรมการฯ เพิ่มเติม................................................................................................................................................
            </td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor text-left" colspan="2">
                ลงชื่อ.......................................................ประธานกรรมการกลั่นกรองการจัดซื้อหนังสือเรียน
            </td>
            <td class="no-bor"></td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor text-left" width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นางสองเมือง กุดั่น) กรรมการภาคี 4 ฝ่าย</td>
            <td class="no-bor text-left">ลงชื่อ................................................ผู้แทนชุมชน</td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor"></td>
            <td class="no-bor text-left">ลงชื่อ................................................ผู้แทนครู
            </td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor"></td>
            <td class="no-bor text-left">ลงชื่อ................................................ผู้แทนผู้ปกครอง
            </td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor"></td>
            <td class="no-bor text-left">ลงชื่อ................................................ผู้แทนนักเรียน
            </td>
        </tr>
    </table>
</div>
<?php
$mpdf->SetHTMLHeader("<div class='content-text text-right'>แบบฟอร์ม สมอ.2</div>");
$html2 = ob_get_contents();
// $mpdf->AddPage('L');
$html = $html1.$html2;
$mpdf->WriteHTML($html);
$taget = "pdf/report3.pdf";
$mpdf->Output($taget);
ob_end_flush();
echo "<script>window.location.href='$taget';</script>";
exit;
?>