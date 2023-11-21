<?php 

    include_once('editip_functions.php');

    $lsdata = new DB_con();

    if (isset($_POST['update'])) {

        $lsid = $_GET['id'];
        $script = $_POST['script'];
        $version = $_POST['version'];
        $image = $_POST['image'];

        $sqlscript = $lsdata->updascript($script, $lsid);
        $sqlversion = $lsdata->updatels($version, $lsid);
        $sqlimage = $lsdata->updatimage($image, $lsid);

        if ($sqlscript AND $sqlversion AND $sqlimage) {
            echo "<script>alert('Updated Successfully!');</script>";
            echo "<script>window.location.href='lscp_index.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again!');</script>";
            echo "<script>window.location.href='lscp_index.php'</script>";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Version</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <h1 class="mt-5">Update Version</h1>
        <hr>
        <?php 

            $lsid = $_GET['id'];
            $updatels = new DB_con();
            $sql = $updatels->fetchonerecordls($lsid);
            while($row = mysqli_fetch_array($sql)) {
        ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="script" class="form-label">สคริป</label>
                <input type="text" class="form-control" name="script"
                    value="<?php echo $row['script']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="version" class="form-label">เวอร์ชั่น</label>
                <input type="text" class="form-control" name="version"
                    value="<?php echo $row['version']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">ลิ้งรูปภาพ log</label>
                <input type="text" class="form-control" name="image"
                    value="<?php echo $row['image']; ?>" required>
            </div>
            <?php } ?>
            <button type="submit" name="update" class="btn btn-success">Update</button>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    
</body>
</html>