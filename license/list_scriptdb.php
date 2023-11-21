<?php


require_once "config.php";

if (isset($_POST['submit'])) {

  $script = $_POST['script'];
  $version = $_POST['version'];

  $user_check = "SELECT * FROM list_script WHERE script = '$script' LIMIT 1";
  $result = mysqli_query(connDB(), $user_check);
  $scriptst = mysqli_fetch_assoc($result);

  if ($scriptst['username'] === $script) {
    echo "<script>alert('Username already exists');</script>";
  } else {

    $query = "INSERT INTO list_script (script, version)
                        VALUE ('$script', '$version')";
    $result = mysqli_query(connDB(), $query);

    if ($result) {
      $_SESSION['success'] = "Insert user successfully";
      header("Location: lscp_index.php");
    } else {
      $_SESSION['error'] = "Something went wrong";
      header("Location: lscp_index.php");
    }
  }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
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
  <title>List Cript</title>



</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">License Server</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['username'])) { ?>
            <li <?php if (isset($_GET['home'])) { ?> class="active" <?php } ?>><a href="index.php?home">หน้าแรก</a></li>
          <?php } ?>
        </ul>
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
<?php if (isset($_SESSION['username'])) { ?>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 w1ms" id="test-login">
        <h3><b>สร้างรายการสคริป</b></h3><br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="form-group">
            <label for="script">Script</label>
            <input type="text" class="form-control" name="script" placeholder="Enter your Script" required>
          </div>
          <div class="form-group">
            <label for="version">Version</label>
            <input type="text" class="form-control" name="version" placeholder="Enter your version" required>
            <br>
            <input type="submit" name="submit" value="เพิ่มสคริป" class="btn btn-success btn-block">
        </form>
      </div>
    </div>
  </div>
<?php } else { 
  header("location: $domain/login.php");
} ?>
</body>

</html>