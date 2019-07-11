<?php
	require_once("inc/header.php");
	require_once("inc/navbar.php");
	//if admin not login send him back to login.php
	not_login($_SESSION['admin_id'],"login.php");
	$admin_id = $_SESSION['admin_id'];
?>
<div class="container padding-10">
	<div id="search-container">
		<div class="width-400px center">
			<h1 class="text-bs-primary">Change Credentials</h1>
			<?php
				// when update button is pressesd
				if (isset($_POST['update'])) {
                  
        $fetch = $db->Fetch("*","admin","id='$admin_id'");
            if ($fetch) {
      			
      			$passdb = $fetch['password'];
            
      		}else{
      			echo "<div class='alert alert-danger' role='alert'>Invalid </div>";
      		}
                 
					$username = escape($_POST['username']);
                    $opassword = escape($_POST['opassword']);
                    $md5opassword = md5($opassword);
                    
					$password = escape($_POST['password']);
                    
        if(empty($_REQUEST['opassword']))
        {
            echo "Old Password field is empty";
          echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
        }
    
        elseif(empty($_REQUEST['password']))
        
        {
            echo "New Password field is empty";
            echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
        }
                    
            else
            {
        if (strlen($_REQUEST["opassword"])< 8 && strlen($_REQUEST["password"] ) < 8) 
         {
        echo "Your Password Must Contain At Least 8 Characters!";
            echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
        }
                
                elseif( $_POST["opassword"]=== $_POST["password"] )
			{
				echo "New Password should not be same as the Current Password";
                echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
			}
                
                else
			{
				
		         if ($md5opassword === $passdb) 
		            {
                     
                     $md5password = md5($password);
					$update = $db->Update("admin","username='$username',password='$md5password'","id='$admin_id'");
					if ($update) {
						echo "<div class='alert alert-success'>Your account information has been updated</div>";
					}else{
						echo "<div class='alert alert-danger'>Error in updating information try again.</div>";
					}
                     
                     
                     
		                echo " Your Password is Successfully changed";
                     echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
		            }
                
		        else
		        {
		            echo "Your old Password is wrong";
                    echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
		        }
	   
			
			}
                  
                
            }

   
					
				}
			?>
			
			<form method="post">
			        <div class="form-group">
					<label for="username">Old Password</label>
					<input type="password" name="opassword" id="opassword" class="form-control">
				    </div>
			
			
				<div class="form-group">
					<label for="username">New Username</label>
					<input type="text" name="username" id="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">New Password</label>
					<input type="password" name="password" id="password" class="form-control">
				</div>
				<input type="submit" name="update" value="update" class="btn btn-primary">
			</form>
		</div>
	</div>
	
</div>
