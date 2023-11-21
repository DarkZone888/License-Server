<?php 
include("config.php");
if (isset($_SESSION['username'])) { 
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		mysqli_query(connDB(),"DELETE FROM license WHERE id='$id'");
		header("location: $domain/?user");
	}

}
?>