<?php
	require_once("inc/header.php");
	require_once("inc/navbar.php");

	/*$_GET['search'] is available*/
	if (!isset($_SESSION['id'])) {
		echo "<h1 class='text-center text-upper text-bs-primary'>Please Login <a href='login.php' class='text-black'>Login</a></h1>";
		exit();
	}
	$user_id = $_SESSION['id'];
?>

<div  class="btn pull-right"> 
		<a href="changepass.php" class="btn btn-primary">Change Password</a>
</div>
<br>
<br>
<div class="container padding-10">
	<div id="search-container">
		<?php
			// get the count of user orders
			$order_num = $db->GetNum("buy","user_id='$user_id'");

			// if user has no orders
			if ($order_num == 0) {	
				echo "<h1 class='text-center text-upper text-bs-primary'>oops! it seems that your did not have any order yet <a href='products.php' class='text-black'>Start Shoping</a></h1>";
				exit();
			}

		//fetch the orders
			$buys = $db->FetchAll("*","buy","user_id='$user_id'","`id` DESC");

			foreach ($buys as $key => $buy) {
				// explode the product_stack
				$product_id_stack = explode(",", $buy['product_stack']);
				$unset = count($product_id_stack) - 1;
				// unset the last empty item from the product_id_stack
				unset($product_id_stack[$unset]);
				$status_progressbar = "";

				// format status code
				switch ($buy['status_code']) {
					case "1":
						$status_per = "0%";
						$status_text = "Deliverd";
						break;
					case "2":
						$status_per = "33.33%";
						$status_text = "Deliverd";
						break;
					case "3":
						$status_per = "66%";
						$status_text = "Deliverd";
						break;
					case "4":
						$status_per = "100%";
						$status_text = "Deliverd";
						break;
					case "5":
						$status_per = "100%";
						$status_text = "Canceled";
						$status_progressbar = "progress-bar-danger";
						break;
					case "6":
						$status_per = "100%";
						$status_text = "Returned";
						$status_progressbar = "progress-bar-danger";
						break;
				}
				?>
				<div class="border-ccc padding-10 order-container">
					<strong>Order Id:</strong> <?php echo $buy['id'] ?><br>
					<strong>Placed:</strong> <?php echo time_ago($buy['booked_time']); ?>
					<a href="cancel_order.php?id=<?php echo $buy['id']; ?>" class="float-right">Cancel order</a>
					<hr/>
					<table style="width:100%;">
					<th>Image</th>
					<th>Name</th>
					<th>Shipping Charge</th>
					<th>Price</th>
					</tr>
				<?php
				$total = 0;
				foreach ($product_id_stack as $key => $product_id) {
					// fetch the products details
					$product = $db->Fetch("id,name,image,sp,shipping","product","id='$product_id'");
						/*shipping charge formating*/
						if ($product['shipping'] == 0) {
							$shipping_text = "<span class='text-bold text-green'>FREE</span>";
							$shipping_price = 0;
						}else{
							$shipping_text = "Tk ".$product['shipping'];
							$shipping_price = $product['shipping'];
						}
						$total = $total + $shipping_price;
						$total = $total + $product['sp'];
					?>
					<td width="200px;"><img class="height-100px" style="max-width:200px;" src="<?php echo $product['image']; ?>"></td>
					<td class="padding-10 box-sizing"><a href="product.php?id=<?php $product['id'] ?>"><?php echo $product['name']; ?></a></td>
					<td><?php echo $shipping_text; ?></td>
					<td><?php echo "Tk ".$product['sp']; ?></td>
					<tr>
					<?php
				}
				?>
				</table>
				<p class="text-20"><strong>Total: </strong> Tk <?php echo $total; ?></p>
				<div class="progress" style="height:5px;">
					<div class="progress-bar <?php echo $status_progressbar; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $status_per; ?>;"></div>
				</div>
				<div class="row">
					<div class="col-sm-4 text-left">Processing</div>
				<div class="col-sm-4 text-center">Shipped</div>
				<div class="col-sm-4 text-right"><?php echo $status_text; ?></div>
				</div>
			</div>
				<?php
			}
		?>
	</div>
<?php require_once("inc/footer-nav.php"); ?>
</div>
<?php require_once("inc/footer.php"); ?>