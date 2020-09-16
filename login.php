<?php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);

   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT UserName FROM Users WHERE UserName = '$myusername' and Password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         
         header("Location: admin-home.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
	<!-- HEADER -->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Finance Titan - Sign In</title>

		<!-- Stylesheets -->
		<link href="css/bootstrap-4.4.1.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	
<body>
<!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

<!-- BANNER -->
<?php include('include/banner.php'); ?>

<!-- PAGE CONTENT -->
<section id="sign-in-form" class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div id="home-accordion" role="tablist">
				<div class="card">			
					<div class="card-header" role="tab" id="login-heading">
						<h2 class="mb-0 text-center"> <a id="login-accordian" data-toggle="collapse" href="#login-collapse" role="button" aria-expanded="false" aria-controls="login-collapse">Sign In</a></h2>
					</div>
					<div id="login-collapse" class="collapse" role="tabpanel" aria-labelledby="login-heading" data-parent="#home-accordion">
			      		<div class="card-body">
							<form class="sign-in-form" method="POST" action="">
								<div class="form-group">
									<input type="text" class="form-control" name="username" id="username" required="required" placeholder="Username">
								</div>
								<div class="form-group">
									<input type="password" class="form-control" name="password" id="password" required="required" placeholder="Password">
								</div>
								<div class="text-center">
									<input type="submit" id="submit" name="submit" class="btn btn-lg" value="SIGN IN">
								</div>
								<div class="bottom-links">
									<p><a href="#">Forgot your password?</a></p>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" role="tab" id="create-account-heading">
						<h2 class="mb-0 text-center"> <a id="login-accordian" href="#create-account-collapse" role="button" data-toggle="collapse" expanded="false" aria-controls="create-account-collapse">New? Sign up for an account</a></h2>
					</div>
					<div id="create-account-collapse" class="collapse" role="tabpanel" aria-labelledby="create-account-heading" data-parent="#home-accordion">
			      		<div class="card-body text-center">
							<p><a href="create-account.php" role="button" class="btn btn-lg">Create Account Form</a></p>
						</div>
					</div>
				</div>			  
		  	</div>
		</div>
	</div>	
</section>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-3.4.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.4.1.js"></script>
</body>
</html>
