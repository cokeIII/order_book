<?php
header('Content-Type: text/html; charset=UTF-8');
require_once "connect.php";
$sql = "select * from book b
inner join author a on a.author_id = b.author_id
inner join publisher p on p.pub_id = b.pub_id  
";
$res = mysqli_query($conn, $sql);
$i = 0;
$datalist = array();
$datalist["data"][$i]["order_book"] = "ไม่มีข้อมูล";
$datalist["data"][$i]["year_edu"] = "";
$datalist["data"][$i]["subject_id"] = "";
$datalist["data"][$i]["name_book"] = "";
$datalist["data"][$i]["author_name"] = "";
$datalist["data"][$i]["pub_name"] = "";
$datalist["data"][$i]["price"] = "";
$datalist["data"][$i]["qty_page"] = "";
$datalist["data"][$i]["paper_pattern"] = "";
$datalist["data"][$i]["print_pattern"] = "";
$datalist["data"][$i]["size_book"] = "";

while ($row = mysqli_fetch_assoc($res)) {
    $datalist["data"][$i]["order_book"] = '<button 
    subject_id="' . $row["subject_id"] . '"   
    author_id="' . $row["author_id"] . '" 
    pub_id="' . $row["pub_id"] . '" 
    class="btn btnOrder btn-success">
    <img title="จัดซื้อรายการนี้" src="img/shopping-bag.png" height="30" width="30">
    จัดซื้อ
    </button>';
    $datalist["data"][$i]["year_edu"] = $row["year_edu"];
    $datalist["data"][$i]["subject_id"] = $row["subject_id"];
    $datalist["data"][$i]["name_book"] = $row["name_book"];
    $datalist["data"][$i]["author_name"] = $row["author_name"];
    $datalist["data"][$i]["pub_name"] = $row["pub_name"];
    $datalist["data"][$i]["price"] = $row["price"];
    $datalist["data"][$i]["qty_page"] = $row["qty_page"];
    $datalist["data"][$i]["paper_pattern"] = $row["paper_pattern"];
    $datalist["data"][$i]["print_pattern"] = $row["print_pattern"];
    $datalist["data"][$i]["size_book"] = $row["size_book"];
    $i++;
}
echo json_encode($datalist, JSON_UNESCAPED_UNICODE);
