<!DOCTYPE html>
<html lang="en">
<!-- META DATA -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Finance Titan - Welcome</title>

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
				<a class="nav-link" id="logout" href="login.php">Log In</a>
			</li>
		</ul>
	</div>
</nav>
		
<!-- BANNER -->
<section id="banner" class="text-center logo-background"> <img src="images/logo.jpeg" alt="Finance Titan Logo" max-width="225px" height="200px" class="logo"/>
	<p class="lead">Seize Control of Your Finances</p>
</section>
		
<!-- PAGE CONTENT -->
<section id="welcome-buttons" class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-md-6 text-center">
			<a href="login.php" role="button" class="btn btn-lg">Sign In</a>
		</div>
	</div>
	<div class="row d-flex justify-content-center">
		<div class="col-md-6 text-center">
			<a href="create-account.php" role="button" class="btn btn-lg">Create Account</a>
		</div>
	</div>
</section>
		
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-3.4.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.4.1.js"></script>
<script>$('[data-toggle="tooltip"]').tooltip();</script>
</body>
	
<!-- FOOTER -->
<footer>

</footer>
</html>
