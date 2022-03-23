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
    if (empty($_SESSION["people_id"])) {
        header("location: index.php");
    }
    ?>
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card shadow mt-5">
                    <div class="card-body" width="100%">
                        <h3>ค้นหาหนังสือ</h3>
                        <hr>
                        <table class="table listBook display nowrap text-center" id="listBook">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ครั้งที่อนุมัติ</th>
                                    <th width="10%">รหัสวิชา</th>
                                    <th width="30%">ชื่อวิชา</th>
                                    <th>ผู้แต่ง</th>
                                    <th>สำนักพิมพ์</th>
                                    <th>ราคา(บาท)</th>
                                    <th>จำนวนหน้า</th>
                                    <th>รูปแบบกระดาษ</th>
                                    <th>รูปแบบการพิมพ์</th>
                                    <th>ขนาดรูปเล่ม</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>ครั้งที่อนุมัติ</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ผู้แต่ง</th>
                                    <th>สำนักพิมพ์</th>
                                    <th>ราคา(บาท)</th>
                                    <th>จำนวนหน้า</th>
                                    <th>รูปแบบกระดาษ</th>
                                    <th>รูปแบบการพิมพ์</th>
                                    <th>ขนาดรูปเล่ม</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
<div class="modal fade" role="dialog" id="modal_group_id">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">จัดซื้อหนังสือ</h5>
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertOrder" method="post">
                    <div class="row">
                        <div class="col-md-2 mt-1">
                            <label>ภาคเรียน</label>
                            <input type="text" name="term" id="term" value="<?php echo $_SESSION["term"]; ?>" readonly class="form-control">
                        </div>
                        <div class="col-md-4 mt-1">
                            <div>
                                <label>วิชา</label>
                            </div>
                            <select class="form-control" name="subject" id="subject" required>
                                <option value="">-- เลือกวิชา --</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">
                            <div>
                                <label>กลุ่มเรียน</label>
                            </div>
                            <select class="form-control" name="student_group_id" id="student_group_id" required>
                                <option value="">-- เลือกลุ่มเรียน --</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">

                            <label>หมายเหตุ</label>
                            <select class="form-control" name="note" id="note" required>
                                <option value="">-- เลือกหมายเหตุ --</option>
                                <option value="หนังสือได้มาตรฐาน">หนังสือได้มาตรฐาน</option>
                                <option value="เนื้อหาตรงตามหลักสูตร">เนื้อหาตรงตามหลักสูตร</option>
                                <option value="อื่นๆ">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2" id="otherInput">
                            <label>กรุณาใส่หมายเหตุ</label>
                            <input type="text" name="other" id="other" class="form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="w-100">
                        <button type="submit" class="btn btn-primary mt-2 btnStdGroup float-right-c">ส่งข้อมูลการจัดซื้อ</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div class="w-100 text-primary">
                    <p class="float-left">* ถ้าค้นหาจากชื่อกลุ่มเรียนไม่เจอ ให้ค้นหาจารหัสกลุ่มเรียนแทน</p>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php require_once "setFoot.php"; ?>
<script>
    $(document).ready(function() {
        loadTable()
        // $('#student_group_id').select2({
        //     theme: "bootstrap"
        // });
        let subject_id_book = "";
        let author_id = "";
        let pub_id = "";
        // $("#term").change(function() {
        //     $.ajax({
        //         type: "POST",
        //         url: "get_std_group.php",
        //         data: {
        //             term: $("#term").val(),
        //             subject_id_book: subject_id_book,
        //             author_id: author_id,
        //             people_id: <?php //echo "'" . $_SESSION["people_id"] . "'"; 
                                    ?>
        //         },
        //         success: function(result) {
        //             $("#student_group_id").html(result)
        //         }
        //     });
        // })
        $(document).on("click", ".btnOrder", function() {
            subject_id_book = $(this).attr("subject_id")
            author_id = $(this).attr("author_id")
            pub_id = $(this).attr("pub_id")
            $.ajax({
                type: "POST",
                url: "get_subject.php",
                data: {},
                success: function(result) {
                    $("#subject").html(result)
                    $("#subject").select2({
                        dropdownParent: $('#modal_group_id'),
                        width: '100%',
                        theme: "bootstrap",
                    })
                }
            });
            $.ajax({
                type: "POST",
                url: "get_std_group.php",
                data: {
                    term: $("#term").val(),
                    subject_id_book: subject_id_book,
                    author_id: author_id,
                    people_id: <?php echo "'" . $_SESSION["people_id"] . "'"; ?>,
                    student_group_id: $("#student_group_id").val()
                },
                success: function(result) {
                    $("#student_group_id").html(result)
                    $("#student_group_id").select2({
                        dropdownParent: $('#modal_group_id'),
                        theme: "bootstrap",
                        width: '100%'
                    })
                    $('#modal_group_id').modal('show')
                }
            });
        })
        $("#otherInput").hide()
        $("#note").change(function() {
            if ($(this).val() == "อื่นๆ") {
                $("#otherInput").fadeIn()
            } else {
                $("#otherInput").hide()
            }
        })
        $(document).on("submit", "#insertOrder", function(e) {
            e.preventDefault();
            $.redirect('insert_order.php', {
                'subject_id_book': subject_id_book,
                'author_id': author_id,
                'pub_id': pub_id,
                student_group_id: $("#student_group_id").val(),
                'people_id': <?php echo "'" . $_SESSION["people_id"] . "'";
                                ?>,
                'subject': $("#subject").val(),
                'note': $("#note").val(),
                'other': $("#other").val(),
                'term': $("#term").val()
            }, "POST");
        })

        function loadTable() {
            $('#listBook').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "order": [
                    [1, "desc"]
                ],
                "info": true,
                "bDestroy": true,
                "responsive": true,
                "autoWidth": false,
                "pageLength": 30,
                "scrollX": true,
                "ajax": {
                    "url": "get_book.php",
                    "type": "POST",
                    "data": function(d) {
                        d.act = "book"
                    }
                },
                'processing': true,
                "columns": [{
                        "data": "order_book"
                    }, {
                        "data": "year_edu"
                    },
                    {
                        "data": "subject_id"
                    },
                    {
                        "data": "name_book"
                    },
                    {
                        "data": "author_name"
                    },
                    {
                        "data": "pub_name"
                    },
                    {
                        "data": "price"
                    },
                    {
                        "data": "qty_page"
                    },
                    {
                        "data": "paper_pattern"
                    },
                    {
                        "data": "print_pattern"
                    },
                    {
                        "data": "size_book"
                    }
                ],
                "language": {
                    'processing': '<img src="img/tenor.gif" width="80">',
                    "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                    "zeroRecords": "ไม่มีข้อมูล",
                    "info": "กำลังแสดงข้อมูล _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "search": "ค้นหา:",
                    "infoEmpty": "ไม่มีข้อมูลแสดง",
                    "infoFiltered": "(ค้นหาจาก _MAX_ total records)",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "หน้าต่อไป",
                        "previous": "หน้าก่อน"
                    }
                }
            });
        }
    })
</script>