<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "setHead.php"; ?>
</head>
<style>
    .wh-card {
        width: 350px !important;
    }
</style>

<body class="bg-grays d-flex flex-column min-vh-100" >
    <?php
    require_once "menu.php";
    $text_show = "";
    if (!empty($_GET["text-error"])) {
        $text_show = $_GET["text-error"];
    }
    ?>
    <div class="container mt-top-menu">
        <div class="row">
            <div class="col-md-12 mx-auto mb-3">
                <div class="card mt-5">
                    <div class="card-body">
                        <h4 class="text-center"><?php echo $text_show; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php require_once "setFoot.php"; ?>
<script>
    $(document).ready(function() {

    });
</script>