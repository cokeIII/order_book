<!DOCTYPE html>
<html lang="en">
<style>
    .float-right-c {
        float: right;
    }
</style>

<head>
    <?php
    require_once "setHead.php";
    ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once "menu.php";
    require_once "connect.php";
    if (empty($_SESSION["status"])) {
        header("location: index.php");
    }
    ?>
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card shadow mt-5">
                    <div class="card-body" width="100%">
                        <h3>จัดการจำนวนนักเรียน/นักศึกษา</h3>
                        <hr>
                        <button class="btn btn-primary float-end mb-3" data-toggle="modal" data-target="#stdQtyAdd">เพิ่มรายการข้อมูล</button>
                        <table class="table" id="std" width="100%">
                            <thead>
                                <tr>
                                    <td>รหัสกลุ่ม</td>
                                    <td>ชื่อสาขา</td>
                                    <td>ระดับชั้น</td>
                                    <td>ชื่อกลุ่ม</td>
                                    <td>จำนวนนักเรียน</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "select * from group_std_real";
                                $res = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($res)) { ?>
                                    <tr>
                                        <td><?php echo $row["group_id"]; ?></td>
                                        <td><?php echo $row["major_name"]; ?></td>
                                        <td><?php echo $row["level"]; ?></td>
                                        <td><?php echo $row["group_name"]; ?></td>
                                        <td><?php echo $row["qty_std"]; ?></td>
                                        <td><button class="btn btn-warning btn-edit" data-toggle="modal" data-target="#stdQtyEdit" group_id="<?php echo $row["group_id"] ?>">แก้ไข</button></td>
                                        <td><button class="btn btn-danger btn-del" group_id="<?php echo $row["group_id"] ?>">ลบ</button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
<div class="modal fade" id="stdQtyEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stdQtyEditTitle">แก้ไขข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="admin_query.php" method="post">
                    <input type="hidden" name="act" value="editGroupStd">
                    <label>รหัสกลุ่ม</label>
                    <input class="form-control" type="text" name="group_id" id="group_id" readonly>
                    <label>ชื่อสาขา</label>
                    <input class="form-control" type="text" name="major_name" id="major_name">
                    <label>ระดับชั้น</label>
                    <input class="form-control" type="text" name="level" id="level">
                    <label>ชื่อกลุ่ม</label>
                    <input class="form-control" type="text" name="group_name" id="group_name">
                    <label>จำนวนนักเรียน</label>
                    <input class="form-control" type="number" name="qty_std" id="qty_std">
                    <button type="submit" class="btn btn-warning mt-2 float-end">แก้ไข</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="stdQtyAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stdQtyAddTitle">เพิ่มข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="admin_query.php" method="post">
                    <input type="hidden" name="act" value="insertGroupStd">
                    <label>รหัสกลุ่ม</label>
                    <input class="form-control" type="text" name="group_id" id="group_id">
                    <label>ชื่อสาขา</label>
                    <input class="form-control" type="text" name="major_name" id="major_name">
                    <label>ระดับชั้น</label>
                    <input class="form-control" type="text" name="level" id="level">
                    <label>ชื่อกลุ่ม</label>
                    <input class="form-control" type="text" name="group_name" id="group_name">
                    <label>จำนวนนักเรียน</label>
                    <input class="form-control" type="number" name="qty_std" id="qty_std">
                    <button type="submit" class="btn btn-primary mt-2 float-end">เพิ่มรายการ</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php require_once "setFoot.php"; ?>
<script>
    $(document).ready(function() {
        $("#std").DataTable({
            "scrollX": true,
            lengthMenu: [
                ['All'],
            ],
        })
        $(document).on('click', '.btn-del', function() {
            let group_id = $(this).attr('group_id')
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
                    $.redirect('admin_query.php', {
                        'group_id': group_id,
                        'act': 'delGroupStd'
                    }, "POST");
                }
            })
        })
        $(document).on('click', '.btn-edit', function() {
            $.ajax({
                type: "POST",
                url: "admin_query.php",
                dataType: 'json',
                data: {
                    act: 'getGroupStd',
                    group_id: $(this).attr('group_id')
                },
                success: function(result) {
                    console.log(result);
                    $("#group_id").val(result.group_id)
                    $("#major_name").val(result.major_name)
                    $("#level").val(result.level)
                    $("#group_name").val(result.group_name)
                    $("#qty_std").val(result.qty_std)
                }
            });
        })
    })
</script>