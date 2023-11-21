<?php include("config.php"); ?>
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
    <title>Edit Ip</title>



</head>

<body>
    <?php if (isset($_SESSION['username'])) { ?>
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
                <ul class="nav navbar-nav">
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li <?php if (isset($_GET['home'])) { ?> class="active" <?php } ?>><a href="index.php?home">หน้าแรก</a></li>

                        <li <?php if (isset($_GET['key'])) { ?> class="active" <?php } ?>><a href="index.php?key">สร้างคีย์</a></li>
                        <li <?php if (isset($_GET['user'])) { ?> class="active" <?php } ?>><a href="index.php?user">ผู้ใช้งาน</a></li>
                        <li <?php if (isset($_GET['edit_ip'])) { ?> class="active" <?php } ?>><a href="editip_index.php">แก้ไขไอพี</a></li>
                        <li <?php if (isset($_GET['list_script'])) { ?> class="active" <?php } ?>><a href="lscp_index.php">รายการสคริป</a></li>
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li><a href="?logout"><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ</a></li>
                    <?php } else { ?>
                        <li <?php if (isset($_GET['logout'])) { ?> class="active" <?php } ?>><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> เข้าสู่ระบบ</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 w1ms" id="test-login">
                <table id="w1ms_logs" class="table table-hover" style="width:100%">
                    <thead>
                        <th>#</th>
                        <th>สคริป</th>
                        <th>ผู้ใช้งาน</th>
                        <th>Key</th>
                        <th>ID Discord</th>
                        <th>Ip</th>
                        <th>Expired</th>
                        <th>แก้ไขข้อมูล</th>
                        <th>ลบ</th>
                    </thead>
                    <tbody>
                        <?php

                        include_once('editip_functions.php');
                        $fetchdata = new DB_con();
                        $sql = $fetchdata->fetchdata();
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['script']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['license']; ?></td>
                                <td><?php echo $row['discord']; ?></td>
                                <td><?php echo $row['ip']; ?></td>
                                <td><?php echo $row['expired']; ?></td>
                                <td><a href="editip_update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">แก้ไขข้อมูล</a></td>
                                <td><a href="editip_delete.php?del=<?php echo $row['id']; ?>" class="btn btn-danger">ลบ</a></td>
                            </tr>

                        <?php

                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } else { 
        header("location: $domain/login.php");
    } ?>
</body>

</html>