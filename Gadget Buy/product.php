<?php
	require_once("inc/header.php");
	require_once("inc/navbar.php");

	/*check product id*/
	if (isset($_GET['id'])) {
		$product_id = escape($_GET['id']);

		/*fetch product details*/
		$product = $db->Fetch("*","product","id='$product_id'");
		/*
			check $product_id is geniun
			if $product_id is not geniun send the user
			to 404.php
		*/
		if (!$product) {
			redirect("404.php");
		}
	}else{
		redirect("404.php");
	}
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 padding-10 box-sizing">
			<div class="product-img-area">
				<img src="<?php echo $product['image']; ?>">
			</div>
		</div>
		<div class="col-sm-8 padding-10 box-sizing">
			<div class="product-desc-container">
				<h1 class="text-upper text-25 text-bs-primary"><?php echo $product['name']; ?></h1>
				<p><?php echo $product['description']; ?></p>
				<p class="text-20">Market Price <span class="text-line-through text-red">Tk <?php echo $product['mp'] ?></span> <span class="text-green">[<?php echo $product['off'];?> OFF]</span></p>
				<?php
					/*calculate the money saved (mp - sp)*/
					$saved = $product['mp'] - $product['sp'];
				?>
				<p class="text-orange">Save Tk <?php echo $saved; ?></p>
				<p class="text-20">Price <span class="text-bs-primary text-bold">Tk <?php echo $product['sp']; ?></span></p>
				<input type="hidden" value="<?php echo $product_id; ?>" id="p-id">
				<button class="btn btn-primary text-20 margin-5" id="add-to-cart">Add To Cart</button>
				<span id="add-to-cart-message" class="text-bold text-20"></span>
			</div>
		</div>
	</div>
	<?php require_once("inc/footer-nav.php"); ?>
</div>
<?php
	require_once("inc/footer.php");
?>