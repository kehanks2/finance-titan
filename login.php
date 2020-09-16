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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<img src="images/logo-no-bg.png" id="navbar-logo">
	<a class="navbar-brand" href="index.php">Finance Titan</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Messages</a>
			</li>			
		</ul>
		<ul class="navbar-nav d-flex justify-content-end">	
			<li>
				<a class="nav-link" id="logout" href="sign-in.html">Log In</a>
			</li>
		</ul>
	</div>
</nav>

<!-- BANNER -->
<section id="banner" class="text-center logo-background"> <img src="images/logo.jpeg" alt="Finance Titan Logo" max-width="225px" height="200px" class="logo"/>
	<p class="lead">Seize Control of Your Finances</p>
</section>

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
