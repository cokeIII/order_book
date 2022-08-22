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
    if (empty($_SESSION["status"])) {
        header("location: index.php");
    }
    ?>
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card shadow mt-5">
                    <div class="card-body" width="100%">
                        <h3>รายการหนังสือ</h3>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
<?php require_once "setFoot.php"; ?>
<script>
    $(document).ready(function() {})
</script>