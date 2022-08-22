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
                        <button class="btn btn-primary float-end mb-3">เพิ่มรายการข้อมูล</button>
                        <table class="table" id="std">
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
                                        <td><button class="btn btn-warning btn-edit" data-toggle="modal" data-target="#stdQtyEdit" group_id="<?php echo $row["group_id"]?>">แก้ไข</button></td>
                                        <td><button class="btn btn-danger">ลบ</button></td>
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
                <div class="form-group">
                    <label>รหัสกลุ่ม</label>
                    <input type="text" readonly>
                    <label>ชื่อสาขา</label>
                    <input type="text">
                </div>
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
        $("#std").DataTable()
        $(document).on('click','.group_id',function(){
            
        })
    })
</script>