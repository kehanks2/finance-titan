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
<section id="sign-in-form" class="d-flex justify-content-center">
	<form class="col-md-4 sign-in-form" method="POST" action="">
		<div class="text-center">
			<h2>Sign In</h2>
		</div>
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
			<p><a href="create-account.php">New? Create an account!</a></p>
		</div>
	</form>
</section>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-3.4.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.4.1.js"></script>
</body>
</html>
