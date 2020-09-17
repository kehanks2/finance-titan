<?php
include('session.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Titan - Home</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
<body>
	  
  <!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

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
							<p><a href="#">Password Report</a></p>
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
