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
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="?home">License Server</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['username'])) { ?>
            <li <?php if (isset($_GET['home'])) { ?> class="active" <?php } ?>><a href="?home">หน้าแรก</a></li>
            <li <?php if (isset($_GET['key'])) { ?> class="active" <?php } ?>><a href="?key">สร้างคีย์</a></li>
            <li <?php if (isset($_GET['user'])) { ?> class="active" <?php } ?>><a href="?user">ผู้ใช้งาน</a></li>
            <li <?php if (isset($_GET['edit_ip'])) { ?> class="active" <?php } ?>><a href="editip_index.php">แก้ไขไอพี</a></li>
            <li <?php if (isset($_GET['list_script'])) { ?> class="active" <?php } ?>><a href="lscp_index.php">รายการสคริป</a></li>
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
    <?php if (isset($_GET['home'])) { ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 w1ms" id="test-login">
            <table id="w1ms_logs" class="table table-hover" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $n = 1;
                $sql = "SELECT * FROM logs ORDER BY id DESC";
                $query = mysqli_query(connDB(), $sql);
                while ($row = mysqli_fetch_array($query)) { ?>
                  <tr <?php if ($row['status'] == 1) {
                      } elseif ($row['status'] == 2) {
                        echo 'class="danger"';
                      } elseif ($row['status'] == 3) {
                        echo 'class="danger"';
                      } elseif ($row['status'] == 4) {
                        echo 'class="danger"';
                      } elseif ($row['status'] == 5) {
                        echo 'class="danger"';
                      } else {
                        echo 'class="danger"';
                      }?>>
                    <td><?php echo $n; ?></td>
                    <td><?php echo $row['descript']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo status_color($row['status']); ?></td>
                  </tr>
                <?php $n++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $('#w1ms_logs').DataTable();
        });
      </script>
    <?php } ?>
    <?php if (isset($_GET['key'])) { ?>
      <?php if (isset($_POST['ip']) or isset($_POST['license'])) {
        $msg = "";
        if (!empty($_POST['license']) and !empty($_POST['name']) and !empty($_POST['script']) and !empty($_POST['ip']) and !empty($_POST['discord'])) {
          if (!empty($_POST['expired'])) {
            $expired = $_POST['expired'];
          } else {
            $expired = 'ไม่จำกัด';
          }
          $license = $_POST['license'];
          $name = $_POST['name'];
          $script = $_POST['script'];
          $ip = $_POST['ip'];
          $date = date("Y-m-d");
          $discord = $_POST['discord'];
          $result = mysqli_query(connDB(), "INSERT INTO license (license, script, ip, name, date, discord, expired) VALUES ('$license','$script','$ip','$name','$date','<@$discord>','$expired')");
          if ($result) {
            $msg = "Add User Success";
          } else {
            $msg = "Mysql Error";
          }
        }
      } ?>
      <div class="container">
        <div class="row">
          <div class="col-lg-12 w1ms" id="test-login">
            <h3><b>สร้างคีย์</b></h3><br>
            <form action="" method="post">
              <div class="form-group">
                <label for="license ">Key</label>
                <input type="text" class="form-control" name="license" id="license" required="" placeholder="license" value="<?php echo gen_key_check(); ?>">
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" required="" placeholder="ชื่อผู้ใช้งานสคริป ( ชื่อเซิฟ หรือ ชื่อดิสคอร์ด )">
              </div>
              <div class="form-group">
                <label for="name">Discord</label>
                <input type="text" class="form-control" name="discord" id="discord" required="" placeholder="ID Discord">
              </div>
              <div class="form-group">
                <label for="script">Script</label>
                <input type="text" class="form-control" name="script" id="script" required="" placeholder="ชื่อสคริป ( ให้ถูกต้อง )">
              </div>
              <div class="form-group">
                <label for="ip">IP</label>
                <input type="text" class="form-control" name="ip" id="ip" required="" placeholder="IP ของผู้ใช้งาน">
              </div>
              <div class="form-group">
                <label for="expired">จำกัดเวลา เช่น 2021-12-31</label>
                <input type="text" class="form-control" name="expired" id="expired" placeholder="ปี-เดือน-วัน ถ้าไม่ใช่ไม่ต้องใส่อะไร">
              </div>
              <?php if (isset($msg)) { ?>
                <p><?php echo $msg; ?></p><br>
              <?php } ?>

              <button type="submit" class="btn btn-success btn-block"> เพิ่ม </button>

            </form>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if (isset($_GET['user'])) { ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 w1ms" id="test-login">
            <table id="w1ms_logs" class="table table-hover" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>สคริป</th>
                  <th>ผู้ใช้งาน</th>
                  <th>Key</th>
                  <th>ID Discord ผู้ใช้งาน</th>
                  <th>Ip</th> 
                  <th>เวลา</th>
                  <th>หมดอายุ</th>
                </tr>
              </thead>
              <tbody>
                <?php $n = 1;
                $sql = "SELECT * FROM license ORDER BY id DESC";
                $query = mysqli_query(connDB(), $sql);
                while ($row = mysqli_fetch_array($query)) { ?>
                  <tr>
                    <td><?php echo $n; ?></td>
                    <td><?php echo $row['script']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['license']; ?></td>
                    <td><?php echo $row['discord']; ?></td>
                    <td><?php echo $row['ip']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['expired']; ?></td>
                    <td>
                      <form action="<?php echo $domain; ?>/delete.php" method="post">
                        <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                      </form>
                    </td>
                  </tr>
                <?php $n++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $('#w1ms_logs').DataTable();
        });
      </script>
    <?php } ?>
    <?php } else { 
        header("location: $domain/login.php");
    } ?>
</body>

</html>

<?php
if (isset($_GET['logout'])) {
  session_destroy();
  header("location: $domain");
}

?>