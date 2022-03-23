<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
if (intval(date("m")) >= 3 && intval(date("m")) < 8) {
  $_SESSION["term"]  = trim("1/" . (date("Y") + 543));
} else {
  $_SESSION["term"] = trim("2/" . (date("Y") + 543));
}
?>
<!-- <style>
  .dropdown-menu {
    width: 300px !important;
    height: auto !important;
  }
</style> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a href="#" class="navbar-brand"><img src="" alt=""></a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
      <div class="navbar-nav">
        <a href="form_order.php" class="nav-item nav-link active">
          <h5><img src="img/logo-login.png" width="30" height="30"> ระบบจัดซื้อหนังสือ วิทยาลัยเทคนิคชลบุรี</h5>
        </a>
        <?php if (!empty($_SESSION["status"]) && $_SESSION["status"] == "staff") { ?>
          <!-- <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">จัดการหนังสือ</a>
            <div class="dropdown-menu">
              <a href="#" class="dropdown-item"></a>
            </div>
          </div> -->
          <a href="#" class="nav-item nav-link">
            จัดการหนังสือ
          </a>
        <?php } else if (!empty($_SESSION["status"]) && $_SESSION["status"] == "user") { ?>
          <a href="book_pick.php" class="nav-item nav-link">
            <img src="img/books.png" width="30" height="30">
            รายการหนังสือที่เลือก
          </a>
          <a href="list_orders.php" class="nav-item nav-link">
            <img src="img/box.png" width="30" height="30">
            รายการจัดซื้อ
          </a>
        <?php } ?>
      </div>
      <div class="navbar-nav">
        <a href="#" class="nav-item nav-link">
          <?php echo (empty($_SESSION["username"]) ? "" : $_SESSION["username"]." ".$_SESSION["dep_name"]); ?>
        </a>
        <?php if (!empty($_SESSION["people_id"])) { ?>
          <a href="logout.php" class="nav-item nav-link">Logout</a>
        <?php } ?>
        <!-- <a href="#" class="nav-item nav-link">Login</a> -->
      </div>
    </div>
  </div>
</nav>