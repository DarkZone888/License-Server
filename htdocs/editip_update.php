<?php 

    include_once('editip_functions.php');

    $updatedata = new DB_con();

    if (isset($_POST['update'])) {

        $userid = $_GET['id'];
        $ip = $_POST['ip'];
        $script = $_POST['script'];
        $name = $_POST['name'];
        $license = $_POST['license'];
        $discord = $_POST['discord'];
        $expired = $_POST['expired'];

        $sqlip = $updatedata->updateip($ip, $userid);
        $sqlscript = $updatedata->updatescript($script, $userid);
        $sqlname = $updatedata->updatename($name, $userid);
        $sqlkey = $updatedata->updatekey($license, $userid);
        $sqldiscord = $updatedata->updatediscord($discord, $userid);
        $sqlexpired = $updatedata->updateexpired($expired, $userid);

        if ($sqlip AND $sqlname AND $sqldiscord AND $sqlscript AND $sqlkey AND $sqlexpired) {
            echo "<script>alert('Updated Successfully!');</script>";
            echo "<script>window.location.href='editip_index.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again!');</script>";
            echo "<script>window.location.href=''</script>";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <h1 class="mt-5">แก้ไขข้อมูล</h1>
        <hr>
        <?php 

            $userid = $_GET['id'];
            $updateuser = new DB_con();
            $sql = $updateuser->fetchonerecord($userid);
            while($row = mysqli_fetch_array($sql)) {
        ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">ผู้ใช้งาน</label>
                <input type="text" class="form-control" name="name"
                    value="<?php echo $row['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="script" class="form-label">สคริป</label>
                <input type="text" class="form-control" name="script"
                    value="<?php echo $row['script']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="license" class="form-label">Key</label>
                <input type="text" class="form-control" name="license"
                    value="<?php echo $row['license']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="discord" class="form-label">ID Discord</label>
                <input type="text" class="form-control" name="discord"
                    value="<?php echo $row['discord']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="ip" class="form-label">Ip</label>
                <input type="text" class="form-control" name="ip"
                    value="<?php echo $row['ip']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="expired" class="form-label">Expired</label>
                <input type="text" class="form-control" name="expired"
                    value="<?php echo $row['expired']; ?>">
            </div>

            <?php } ?>
            <button type="submit" name="update" class="btn btn-success">Update</button>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    
</body>
</html>