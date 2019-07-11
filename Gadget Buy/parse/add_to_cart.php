<?php
	header("Content-Type: application/json");
	require_once("../classes/Db.php");
	require_once("../inc/function.php");
	session_start();
	$db = new Db();
	$mysqli = Db::$_mysqli;
$_SESSION['pid']=$_POST['product_id'];

	if (isset($_POST['product_id'])) {
		$product_id = escape($_POST['product_id']);
		$result = array();
        
        
		/*check login status*/
		if (isset($_SESSION['id'])) { /*logged in user*/
			$user_id = $_SESSION['id'];
			$insert = $db->Insert("cart","'','$product_id','$user_id','y',''");

			if ($insert) {
				$result['type'] = "success";
				$result['message'] = "Product has been added to the cart <a href='cart.php' class='text-bd-blue'>View Cart</a>";
			}else{
				$result['type'] = "error";
				$result['message'] = "Error try again.";
			}

		}else{ /* not logged in*/
			$result['type'] = "error";
            
			//$result['message'] = "Please Login <a href='login.php' class='text-bd-blue'>Login</a>";
            $result['message'] = "Product has been added to the cart 2 <a href='cart2.php' class='text-bd-blue'>View Cart</a>";
              
            
$item_array = array(
   'product_id'   => $_POST["product_id"],
   
  );
  $cart_data[] = $item_array; 
           
    $item_data = json_encode($cart_data);
 setcookie('shopping_cart', $item_data, time() + (86400 * 30));
            
            
            
           // setcookie('pid',$_SESSION['pid'],time()+86400,'/');
            //setcookie('uid',$_SESSION['id'],time()+86400,'/');
            
                //$result['type'] = "success";
				
    
            
		}

		echo json_encode($result);
	}
?>