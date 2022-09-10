<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "setHead.php"; ?>
</head>
<style>
    .ml-100 {
        margin-left: 80%;
    }

    .float-right-c {
        float: right;
    }

    .float-left-c {
        float: left;
    }
</style>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once "menu.php";
    require_once "connect.php";
    $people_id = $_SESSION["people_id"];
    $term = $_SESSION["term"];
    $sql = "select 
    o.order_id,
    o.subject_id_book,
    o.subject_id,
    b.name_book,
    b.author_id,
    a.author_name,
    o.pub_id,
    pu.pub_name,
    b.price,
    o.total,
    o.student_group_id,
    sg.group_name,
    sg.level,
    sg.major_name
    from order_books o
    inner join book b on b.author_id = o.author_id and b.pub_id = o.pub_id and b.subject_id = o.subject_id_book
    inner join people p on p.people_id = o.people_id
    inner join author a on a.author_id = o.author_id
    inner join publisher pu on pu.pub_id  = o.pub_id
    inner join group_std_real sg on sg.group_id = o.student_group_id
    where o.people_id = '$people_id' and o.status = '0' and term = '$term' ";
    $res = mysqli_query($conn, $sql);
    ?>
    <div class="container h-100 mt-5 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>รายการหนังสือที่เลือก</h5>
                <hr>
                <table class="table display nowrap text-center" id="listOrder" width="100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสวิชา</th>
                            <th>รหัสวิชาหนังสือ</th>
                            <th>ชื่อหนังสือ</th>
                            <th>ชื่อผู้แต่ง</th>
                            <th>สำนักพิมพ์</th>
                            <th>ราคา</th>
                            <th>กลุ่มเรียน</th>
                            <th>จำนวนที่สั่งซื้อ</th>
                            <th>รหัสการเลือก</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        while ($row = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <th><?php echo ++$i; ?></th>
                                <th><?php echo $row["subject_id"]; ?></th>
                                <th><?php echo $row["subject_id_book"]; ?></th>
                                <th><?php echo $row["name_book"]; ?></th>
                                <th><?php echo $row["author_name"]; ?></th>
                                <th><?php echo $row["pub_name"]; ?></th>
                                <th><?php echo $row["price"]; ?></th>
                                <th><?php echo $row["level"].'/'.$row["group_name"].' '.$row["major_name"];?></th>
                                <th><?php echo $row["total"]; ?></th>
                                <th><?php echo $row["order_id"]; ?></th>
                                <th>
                                    <button subject_id_book="<?php echo $row["subject_id_book"]; ?>" author_id="<?php echo $row["author_id"]; ?>" pub_id="<?php echo $row["pub_id"]; ?>" people_id="<?php echo $people_id; ?>" student_group_id="<?php echo $row["student_group_id"]; ?>" class="btn btn-danger btnDel">
                                        <img src="img/delete.png" alt="" width="30" height="30">
                                    </button>
                                </th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="w-100">
                    <button class="btn btn-primary float-right-c mt-3" id="btnConfirm" target="_blank">
                        <img src="img/box.png" width="30" height="30">
                        ยืนยันรายการ
                    </button>
                    <a href="form_order.php" class="btn btn-success float-left-c mt-3">
                        <img src="img/shopping-bag.png" width="30" height="30">
                        กลับไปเลือกหนังสือ
                    </a>
                </div>
                <div class="row w-100 text-primary">
                    <p class="float-left  mt-5">* หลังจากกด "ยืนยันรายการ" ระบบจะทำการแสดงรายการ สมอ.1 สำหรับพิมพ์(pdf) ทุกรายวิชาที่เลือกไว้ </p>
                    <p class="float-left  mt-1">* สามารถพิมพ์ สมอ.1 ที่เคยยืนยันรายการไปแล้ว และ สมอ.2 ได้จากเมนู "รายการจัดซื้อ"</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<?php
require_once "setFoot.php";
function count_group_std($group_id)
{
    global $conn;
    $sql = "select count(student_id) as countStd from student where status = '0' and  group_id = '$group_id'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["countStd"];
}
?>

<script>
    $(document).ready(function() {
        $("#listOrder").DataTable({
            "scrollX": true,
        })
        $("#btnConfirm").click(function() {
            $.redirect('report1.php', {
                student_group_id: $("#student_group_id").val(),
                'people_id': <?php echo "'" . $_SESSION["people_id"] . "'";
                                ?>,
                'term': <?php echo "'" . $_SESSION["term"] . "'";
                        ?>,
                'username': <?php echo "'" . $_SESSION["username"] . "'";
                            ?>,
            }, "POST", "_blank");
        })
        $(".btnDel").click(function() {
            Swal.fire({
                title: 'ต้องการลบรายการ ?',
                text: "รายการที่คุณลบจะหายไป",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.redirect('del_book_pick.php', {
                        'subject_id_book': $(this).attr("subject_id_book"),
                        'author_id': $(this).attr("author_id"),
                        'pub_id': $(this).attr("pub_id"),
                        'student_group_id': $(this).attr("student_group_id"),
                        'people_id': <?php echo "'" . $_SESSION["people_id"] . "'";
                                        ?>
                    }, "POST");
                }
            })

        })
    })
</script>