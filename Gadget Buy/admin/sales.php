<?php
	require_once("inc/header.php");
	require_once("inc/navbar.php");
	// if admin is not login send him to login.php
	not_login($_SESSION['admin_id'], "login.php");
?>
<div class="container padding-10">
	<div id="search-container">
		<h1 class="text-center text-bs-primary text-upper">All Sales</h1>
		<table class="table table-bordered table-striped">
			<th>Id</th>
			<th>user name</th>
			<th>Phone number</th>
			<th>status</th>
			<th>date</th>
			<tr>
		
		<?php
			$users = $db->FetchAll("user_id,name,mobile,status","buy",null,"`id` DESC");
			foreach ($users as $key => $user) {
				// count orders book by the user
				$user_id = $user['user_id'];
                
				$booked_orders = $db->GetNum("buy","user_id='$user_id'");
				echo "<td>{$user['user_id']}</td><td>{$user['name']}</td><td>{$user['mobile']}</td><td>{$user['status']}</td><td>{$booked_orders}</td><tr>";
			}
		?>
		</table>
	</div>
	
</div>

