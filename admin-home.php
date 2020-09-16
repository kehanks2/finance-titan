<?php
include('session.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Titan - Admin Home</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
	  
  <!-- NAVIGATION -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<img src="images/logo-no-bg.png" id="navbar-logo">
	<a class="navbar-brand" href="admin-home.html">Finance Titan</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="admin-home.html">Admin Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Messages</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				System Management</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Manage Users</a>
					<a class="dropdown-item" href="#">Manage Accounts</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav d-flex justify-content-end">			
			<li class="nav-item nav-user-profile">Logged in as:</li>
			<li class="nav-item">
				<div class="nav-link nav-username" href="#">
					<?php echo $login_session; ?>
				</div>
			</li>
			<li class="nav-item user-icon">
				<i class="fa fa-user-o"></i>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="logout" href="logout.php">Log Out</a>
			</li>
		</ul>
	</div>
</nav>

<section id="admin-home" class="container-fluid home-screen">
	<div class="row">
		
		<!-- SIDE BAR -->
		<div class="col-sm-auto">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Administrator Account</h3>
			<hr>
			<h2>Management Options</h2>
			<div id="admin-accordion" role="tablist">
				<div class="card">
			    	<div class="card-header" role="tab" id="user-heading">
			      		<h5 class="mb-0"> <a data-toggle="collapse" href="#user-collapse" role="button" aria-expanded="true" aria-controls="user-collapse">Users</a> </h5>
		        	</div>
			    	<div id="user-collapse" class="collapse show" role="tabpanel" aria-labelledby="user-heading" data-parent="#admin-accordion">
			      		<div class="card-body">
							<p><a href="#">User Report</a></p>
							<p><a href="#">Other stuff</a></p>
						</div>
		        	</div>
				</div>
			  	<div class="card">
			    	<div class="card-header" role="tab" id="account-heading">
			      		<h5 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#account-collapse" role="button" aria-expanded="false" aria-controls="account-collapse">Accounts</a> </h5>
		        	</div>
			    	<div id="account-collapse" class="collapse" role="tabpanel" aria-labelledby="account-heading" data-parent="#admin-accordion">
			      		<div class="card-body">					
							<p><a href="#">View All Accounts</a></p>
							<p><a href="#">Other stuff</a></p>
						</div>
		        	</div>
		      	</div>			  
		  	</div>
		</div>
		
		<!-- MAIN CONTENT -->
		<div class="col-sm-8">
			<h3>stuff goes here</h3>
		</div>
	</div>
	<div class="row">
		
  	</div>
</section>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
  </body>
</html>