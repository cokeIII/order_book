<?php
header("Content-type:application/pdf");
require_once __DIR__ . '/vendor/autoload.php';
require_once "connect.php";
//custom font
// session_start();
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$usernames = $_POST["username"];
$people_ids = $_POST["people_id"];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabun.ttf',
            //'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabun Bold.ttf',
        ]
    ],
    'default_font' => 'thsarabun',
    'format' => 'A4-L'
]);
?>

<style>
    .content-text {
        font-size: 20px;
    }

    div {
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
</style>
<?php
$terms = $_POST["term"];
$termArr = explode("/", $terms);
$html = "";
$subject_id = $_POST["subject_id"];
$subject_name = $_POST["subject_name"];
$sqlData = "select 
*,sum(o.total) as sumStd
from order_books o
inner join book b on b.author_id = o.author_id and b.pub_id = o.pub_id and b.subject_id = o.subject_id_book
inner join people p on p.people_id = o.people_id
inner join author a on a.author_id = o.author_id
inner join publisher pu on pu.pub_id  = o.pub_id
inner join student_group sg on sg.student_group_id = o.student_group_id
where o.people_id = '$people_ids' and o.status = '1' and o.term = '$terms' and o.subject_id = '$subject_id' and o.subject_name = '$subject_name' group by o.subject_id_book,b.name_book limit 3";
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
    $html = ob_get_contents();
    ob_clean();
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
            <td class="no-bor" colspan="3">(.....................................................)</td>
        </tr>
    </table>
</div>
<?php
$html2 = ob_get_contents();
$mpdf->AddPage("L");
$mpdf->WriteHTML($html . $html2);
ob_clean();
?>
<?php
$mpdf->Output();

function count_group_std($group_id)
{
    global $conn;
    $sql = "select count(student_id) as countStd from student where status = '0' and  group_id = '$group_id'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["countStd"];
}

?>