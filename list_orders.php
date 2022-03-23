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
    *
    from order_books o
    inner join student_group sg on sg.student_group_id = o.student_group_id
    where o.people_id = '$people_id' and o.status = '1' group by o.subject_id,subject_name";
    $res = mysqli_query($conn, $sql);
    ?>
    <div class="container h-100 mt-5 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>รายการจัดซื้อ</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="report3.php" target="_blank" class="btn btn-primary float-right-c">สมอ.2</a>
                    </div>
                </div>
                <hr>
                <table class="table display nowrap text-center" id="listOrders" width="100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ภาคเรียน</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        while ($row = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <th><?php echo ++$i; ?></th>
                                <th><?php echo $row["term"]; ?></th>
                                <th><?php echo $row["subject_id"]; ?></th>
                                <th><?php echo $row["subject_name"]; ?></th>
                                <th>
                                    <button subject_id="<?php echo $row["subject_id"]; ?>" subject_name="<?php echo $row["subject_name"]; ?>" term="<?php echo $row["term"]; ?>" class="btn btn-primary btnReport1">
                                        สมอ.1
                                    </button>
                                </th>
                                <th>
                                    <button subject_id="<?php echo $row["subject_id"]; ?>" term="<?php echo $row["term"]; ?>" people_id="<?php echo $_SESSION["people_id"]; ?>" class="btn btn-danger btnDel">
                                        <img src="img/delete.png" alt="" width="30" height="30">
                                    </button>
                                </th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="w-100">
                    <a href="form_order.php" class="btn btn-success float-left-c mt-3">
                        <img src="img/shopping-bag.png" width="30" height="30">
                        กลับไปเลือกหนังสือ
                    </a>
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
        $("#listOrders").DataTable({
            "scrollX": true,
        })
        $(".btnReport1").click(function() {
            $.redirect('report2.php', {
                'subject_id': $(this).attr("subject_id"),
                'subject_name': $(this).attr("subject_name"),
                'term': $(this).attr("term"),
                'username': '<?php echo $_SESSION["username"]; ?>',
                'people_id': '<?php echo $_SESSION["people_id"] ?>',
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
                    $.redirect('del_subject.php', {
                        'subject_id': $(this).attr('subject_id'),
                        'term': $(this).attr('term'),
                        'people_id': $(this).attr('people_id'),
                    }, "POST");
                }
            })

        })
    })
</script>