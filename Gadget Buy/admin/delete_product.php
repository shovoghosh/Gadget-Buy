<?php
	require_once("inc/init.php");
	not_login($_SESSION['admin_id'], "login.php");
	if (isset($_GET['id'])) {
		$id = escape($_GET['id']);
		$del = $db->Delete("product","id='$id'");
		$affected_row = mysqli_affected_rows($mysqli);
		if ($affected_row == 1) {
			redirect("product.php");
		}else{
			echo "<h2 class='text-red text-center'>Error in Deleting product</h2>";
			exit();
		}
	}else{
		die("Invalid Url");
	}
?>