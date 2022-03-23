<?php
require_once 'vendor/autoload.php';
require_once 'vendor/mpdf/mpdf/mpdf.php';
require_once "connect.php";
// header("Content-type:application/pdf");
//custom font
error_reporting(error_reporting() & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
session_start();
$mpdf = new mPDF();
// $mpdf = new \Mpdf\Mpdf();
?>

<style>
    .content-text {
        font-size: 20px;
        font-family: "thsarabun";
    }

    div, table {
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
$dep_id = $_SESSION["dep_id"];
$dep_name = $_SESSION["dep_name"];
$sql = "select 
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
inner join people_pro pr on pr.people_id = pe.people_id
inner join people_dep pd on pd.people_dep_id = pr.people_dep_id
where pr.people_dep_id = '$dep_id' and o.term = '$term' group by o.subject_id_book,b.name_book
";
$res = mysqli_query($conn, $sql);
?>
<div class="content-text text-center">
    <div>แบบรายงานการเลือกซื้อหนังสือเรียนของสถานศึกษา</div>
    <div>ตามโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษาตั้งแต่ระดับอนุบาลจนจบการศึกษาขั้นพื้นฐาน</div>
    <div>ภาคเรียนที่ <?php echo $termArr[0]; ?> ปีการศึกษา <?php echo $termArr[1]; ?></div>
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
        while ($row = mysqli_fetch_array($res)) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row["subject_id_book"]; ?></td>
                <td><?php echo $row["name_book"]; ?></td>
                <td><?php echo $row["author_name"]; ?></td>
                <td><?php echo $row["pub_name"]; ?></td>
                <td><?php echo $row["price"]; ?></td>
                <td><?php echo $row["sumTotal"]; ?></td>
                <td><?php echo $row["people_name"] . " " . $row["people_surname"]; ?></td>
                <td></td>
                <td></td>
            </tr>
        <?php
            $html .= ob_get_contents();
            ob_clean();
        } ?>

    </table>
    <br>
    <table class="content-text-bottom text-center" width="100%">
        <tr class="no-bor">
            <td class="no-bor " colspan="2">ผู้จัดทำข้อมูล ลงชื่อ.......................................................หัวหน้าแผนกวิชา
            </td>
        </tr>
        <tr class="no-bor">
            <td class="no-bor" colspan="2">(.....................................................)
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
            <td class="no-bor text-left" width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(นายอภิชาติ อนุกูลเวช) กรรมการภาคี 4 ฝ่าย</td>
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
$html2 = ob_get_contents();
ob_clean();
$mpdf->WriteHTML($html . $html2);
$mpdf->Output();

?>