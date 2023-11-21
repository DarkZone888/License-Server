<?php 

    include_once('editip_functions.php');

    if (isset($_GET['del'])) {
        $lsid = $_GET['del'];
        $lsdata = new DB_con();
        $sql = $lsdata->deletels($lsid);

        if ($sql) {
            echo "<script>alert('Record Deleted Successfully!');</script>";
            echo "<script>window.location.href='lscp_index.php'</script>";
        }
    }

?>