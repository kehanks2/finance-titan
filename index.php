<?php	
	include('include/session.php');
?>
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
<?php include('include/navbar.php');?>
		
<!-- BANNER -->
<?php include('include/banner.php');?>
		
<!-- PAGE CONTENT -->
<section id="sign-in-form" class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-6">			
			<div class="text-center">
				<a href="login.php" role="button" id="signin" name="signin" class="btn btn-lg btn-primary">Sign In</a><br><br>
			</div>
			<div class="text-center">
				<a href="create-account.php" role="button" id="createaccount" name="createaccount" class="btn btn-lg btn-primary">Create Account Form</a>
			</div>
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
