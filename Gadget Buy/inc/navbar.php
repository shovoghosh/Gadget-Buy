
<!DOCTYPE html>

<html >

<head>

  <script>
	function getData1(str)
	{
		if(str.length==0)
		{
			document.getElementById("sug").innerHTML=" ";
		}
		else
		{
			var xHttp=new XMLHttpRequest();
			xHttp.onreadystatechange=function()
			{
				if(this.readyState==4 && this.status==200)
				{
				document.getElementById("sug").innerHTML=this.responseText;
				}
			};
			
			xHttp.open("GET","data.php?q="+str,true);
			xHttp.send();
		}
	}
	</script>

</head>

<body>

  <nav class="navbar navbar-default navbar-fixed-top navbar navbar-light" style="background-color: #e8e8e8;">
          <div class="container">
           
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
               
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a href="index.php" class="navbar-brand"><img src="https://image.ibb.co/fExGOK/store.png" height="35px" width="80px" alt="gBuy.com"></a>
              
              
            </div>
            <div id="navbar" class="navbar-collapse collapse">

              <div class="col-sm-5 col-md-5 pull-left">
                  <form class="navbar-form" role="search" action="search.php" method="get">
                  <div class="input-group width-100">
                      <input required type="text" onkeyup="getData1(this.value)" class="form-control" placeholder="Search.." name="search"  id="search" value="<?php if(isset($_GET['search'])) echo escape($_GET['search']) ?>">
                      
                      
                      
                      
                      <div class="input-group-btn">
                          <button class="btn btn-primary" type="submit"><i class="fa fa-search text-16"></i></button>
                      </div>
                      
                  </div>
                  <p id="sug"> </p>
                  </form>
              </div>

              <ul class="nav navbar-nav pull-left" style=" margin-left: 80px;">
              <?php
                /*change navbar option according to user login status*/
                session_start();
                /* USER IS LOGGED IN*/
                if (isset($_SESSION['id'])) {
                  /*fetch user information*/
                  $user_id = escape($_SESSION['id']);
                  $user = $db->Fetch("*","user","id='$user_id'");
                  /*get the count of cart item*/
                  $cart_count = $db->GetNum("cart","user_id='$user_id' AND active='y'");
                  ?>
                 
                  <li title="Cart"><a href='cart.php'><i class="fa fa-shopping-cart icon-small"> <span class="badge" id="cart-count"><?php echo $cart_count; ?></span></i>Cart</a></li>
                  <li title="Products"><a href='products.php'><i class="fa fa-tags icon-small"></i>Products</a></li>
                  <li><a href="user.php"><i class="fa fa-user icon-small"></i> <span class="text-18"><?php echo $user['fullname']; ?></span></a></li>
                  <li title="logout"><a href="logout.php"><i class="fa fa-sign-out icon-small"></i>logout</a></li>
                  <?php
                    
                    
                }else{/*not logged in*/
                  ?>
                  <li title="Home"><a href='index.php'><i class="fa fa-home icon-small"></i>Home</a></li>
                  
                  <li title="Cart"><a href='cart.php'><i class="fa fa-shopping-cart icon-small"> <span class="badge" id="cart-count"><?php //echo $cart_count; ?></span></i>Cart</a></li>
                  
                  <li title="Products"><a href='products.php'><i class="fa fa-tags icon-small"></i>Products</a></li>
                  <li title="Login / Register"><a href='login.php'><i class="fa fa-lock icon-small"></i> Login</a></li>
                  <?php
                }
              ?>
              </ul>

            </div>
          </div>
        </nav>
<div style="height:60px;"></div>
</body>

</html>