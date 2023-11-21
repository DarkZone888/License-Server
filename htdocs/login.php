<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>License Server</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Sriracha&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">

</head>

<body>
  <?php
    $msg_login = "";
    if (isset($_POST['username'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      if (!empty($username)) {
        if (!empty($password)) {
          if ($username == $config_username) {
            if ($password == $config_password) {
              $_SESSION['username'] = $username;
              header("location: $domain/?home");
            } else {
              $msg_login = "รหัสผ่านไม่ถูกต้อง";
            }
          } else {
            $msg_login = "ไม่พบผู้ใช้งานนี้";
          }
        } else {
          $msg_login = "กรุณากรอกรหัสผ่าน";
        }
      } else {
        $msg_login = "กรุณากรอกชื่อผู้ใช้งาน";
      }
    }
  ?>
<nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php?home">License Server</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li><a href="?logout"><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ</a></li>
                    <?php } else { ?>
                        <li <?php if (isset($_GET['logout'])) { ?> class="active" <?php } ?>><a href="?login"><span class="glyphicon glyphicon-log-in"></span> เข้าสู่ระบบ</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
    <div class="wrapper">
      <div class="frm--create-account">
        <h1 class="frm__title">เข้าสู่ระบบ</h1>
        <!-- create account form starts here -->
        <form action="" method="post" class="frm__create__account">
          <div class="frm-group">
            <label for="username">
              <span class="glyphicon glyphicon-user" aria-hidden="true">Username</span>
            </label>
            <!-- <label for="username">Username</label> -->
            <input type="text" class="form-control " name="username"  id="username"placeholder="username">
          </div>
          <div class="frm-group">
            <label for="password">
            <span class="glyphicon glyphicon-lock" aria-hidden="true">Password</span>
            </label>
            <!-- <label for="password">Password</label> -->
            <input type="password" class="form-control" name="password"  id="password"placeholder="Password">
          </div>

          <?php if (isset($msg_login)) { ?>
              <p><?php echo $msg_login; ?></p>
            <?php } ?>
          <button class="frm__btn-primary " type="submit"> เข้าสู่ระบบ </button>
          <marquee bgcolor="#ffe6ff">ยินดีต้อนรับสู่ License Server<marquee </form>
        </form>
       
      </div>
    </div>
  </div>

<div class="ajay">
  <a href="https://codepen.io/AjayRawatCodepen/" target="_blank">See more pens</a>
</div>
</body>

</html>

<?php
if (isset($_GET['logout'])) {
  session_destroy();
  header("location: $domain/index.php?home");
}

?>