<?php
header("Content-type:application/pdf");
require_once __DIR__ . '/vendor/autoload.php';
require_once "connect.php";
//custom font
session_start();
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
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
    'default_font' => 'thsarabun'
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
$term = $_SESSION["term"];
$termArr = explode("/", $term);
$html = "";
$dep_id = $_SESSION["dep_id"];
$dep_name = $_SESSION["dep_name"];
?>
<div class="content-text text-center">
    <div>แบบรายงานการเลือกซื้อหนังสือเรียนของสถานศึกษา</div>
    <div>ตามโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษาตั้งแต่ระดับอนุบาลจนจบการศึกษาขั้นพื้นฐาน</div>
    <div>ภาคเรียนที่ <?php echo $termArr[0];?> ปีการศึกษา <?php echo $termArr[1];?></div>

</div>
<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
ob_clean();
?>
<?php
$mpdf->Output();
?>