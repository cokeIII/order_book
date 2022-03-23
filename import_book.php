<?php
require_once "connect.php";
require_once "PHPExcel.php"; //เรียกใช้ library สำหรับอ่านไฟล์ excel
$tmpfname = "bookData.xlsx"; //กำหนดให้อ่านข้อมูลจากไฟล์จากไฟล์ชื่อ
//สร้าง object สำหรับอ่านข้อมูล ชื่อ $excelReader);

$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
$excelObj = $excelReader->load($tmpfname); //อ่านข้อมูลจากไฟล์ชื่อ test_excel.xlsx
$worksheet = $excelObj->getSheet(0); //อ่านข้อมูลจาก sheet แรก
$lastRow = $worksheet->getHighestRow();
//นับว่า sheet แรกมีทั้งหมดกี่แถวแล้วเก็บจำนวนแถวไว้ในตัวแปรชื่อ $lastRow
$minorCode = "";
$count1 = 0;
$someList = array();
$dataAut = array();
$dataPub = array();
$aut_id = 0;
$pub_id = 0;
$sqlMinor = "insert into minor_book (minor_id,minor_name) values";

mysqli_query($conn, "delete from author");
mysqli_query($conn, "delete from publisher");
mysqli_query($conn, "delete from minor_book");
mysqli_query($conn, "delete from book");

for ($row = 1; $row <= $lastRow; $row++) //วน loop อ่านข้อมูลเอามาแสดงทีละแถว
{
  $cA = $worksheet->getCell('A' . $row)->getValue();
  $cB = $worksheet->getCell('B' . $row)->getValue(); //แสดงข้อมูลใน colum B
  $cD = $worksheet->getCell('D' . $row)->getValue();
  $cE = $worksheet->getCell('E' . $row)->getValue();
  $cF = $worksheet->getCell('F' . $row)->getValue();
  $cG = $worksheet->getCell('G' . $row)->getValue();
  $cH = $worksheet->getCell('H' . $row)->getValue();
  $cI = $worksheet->getCell('I' . $row)->getValue();
  $cJ = $worksheet->getCell('J' . $row)->getValue();
  $cK = $worksheet->getCell('K' . $row)->getValue();
  $cL = $worksheet->getCell('L' . $row)->getValue();
  $cM = $worksheet->getCell('M' . $row)->getValue();
  $cN = $worksheet->getCell('N' . $row)->getValue();
  $cO = $worksheet->getCell('O' . $row)->getValue();
  $cP = $worksheet->getCell('P' . $row)->getValue();
  $cQ = $worksheet->getCell('Q' . $row)->getValue();
  $cR = $worksheet->getCell('R' . $row)->getValue();

  $cD = str_replace("  ", "", $cD);

  if (strripos($cA, '(') && is_numeric(substr($cA, strripos($cA, '(') + 1, 1))) {
    $minorCode = str_replace("(", "", substr($cA, strripos($cA, '('),));
    $minorCode = str_replace(")", "", $minorCode);
    $minorText = substr($cA, 0, strripos($cA, '(') - 1);

    if (empty($someList[$minorCode])) {
      ++$count1;
      $someList[$minorCode] = true;

      $sqlMinor .= "('$minorCode','$minorText'),";
    }
  }

  if (is_numeric(substr($cD, 2, 1))) {
    $paper_pattern = get_paper_pattern($cI, $cJ, $cK);
    $print_pattern = get_print_pattern($cL, $cM, $cN);
    $size_book = get_size_book($cO, $cP, $cQ);

    if (empty($dataAut[$cF])) {
      $dataAut[$cF] = ++$aut_id;
      $autId = $dataAut[$cF];
      $sqlAut = "insert into author (author_id ,author_name) value('$autId','$cF')";
      mysqli_query($conn, $sqlAut);
    }
    if (empty($dataPub[$cR])) {
      $dataPub[$cR] = ++$pub_id;
      $pubId = $dataPub[$cR];
      $sqlPub = "insert into publisher (pub_id,pub_name) value('$pubId','$cR')";
      mysqli_query($conn, $sqlPub);
    }
    $sqlBook = "insert into book 
    (
      no,
      subject_id,
      name_book,
      author_id,
      price,
      qty_page,
      paper_pattern,
      print_pattern,
      size_book,
      pub_id,
      year_edu,
      minor_id
    ) values";
    $autId = $dataAut[$cF];
    $pubId = $dataPub[$cR];
    $sqlBook .= "('$cB','$cD','$cE','$autId','$cG','$cH','$paper_pattern','$print_pattern','$size_book','$pubId','$cA','$minorCode');";
    //insert book
    mysqli_query($conn, $sqlBook);
  }
}
//insert minor_book
$sqlMinor = str_lreplace(",", ";", $sqlMinor);
mysqli_query($conn, $sqlMinor);




function get_size_book($cO, $cP, $cQ)
{
  $res = "";
  if (!empty($cO)) {
    $res = "8 หน้ายก";
  } else if (!empty($cP)) {
    $res = "A4";
  } else if (!empty($cQ)) {
    $res = "อื่นๆ";
  }
  return $res;
}

function get_print_pattern($cL, $cM, $cN)
{
  $res = "";
  if (!empty($cL)) {
    $res = "1 สี";
  } else if (!empty($cM)) {
    $res = "2 สี";
  } else if (!empty($cN)) {
    $res = "4 สี";
  }
  return $res;
}
function get_paper_pattern($cI, $cJ, $cK)
{
  $res = "";
  if (!empty($cI)) {
    $res = "ปอนด์";
  } else if (!empty($cJ)) {
    $res = "ถนอมสายตา";
  } else if (!empty($cK)) {
    $res = "อาร์ท";
  }
  return $res;
}

function str_lreplace($search, $replace, $subject)
{
  $pos = strrpos($subject, $search);

  if ($pos !== false) {
    $subject = substr_replace($subject, $replace, $pos, strlen($search));
  }

  return $subject;
}
