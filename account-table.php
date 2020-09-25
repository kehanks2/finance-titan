<?php
include('include/session.php');
if ($_SESSION['user_type'] != 'admin') {
	if ($_SESSION['user_type'] == 'accountant') {
		header("Location: accountant-home.php");
	} elseif ($_SESSION['user_type'] == 'manager') {
		header("Location: manager-home.php");
	} else {
		header("Location: login.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Titan - Password Report</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
<body>
	  
  <!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

<section id="admin-home" class="container-fluid home-screen">
	
	<!-- WELCOME -->	
	<div class="row">
		<div class="col-sm-3">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Administrator Account</h3>
		</div>
	</div>
	
	<!-- SIDE BAR ACCORDION -->
	<div class="row">
		<div class="col-sm-3">
			<h2>Management Options</h2>
			<div id="admin-accordion" role="tablist">
				<!-- USER CARD -->
				<div class="card">
			    	<div class="card-header" role="tab" id="user-heading">
			      		<h5 class="mb-0"> <a data-toggle="collapse" href="#user-collapse" role="button" aria-expanded="true" aria-controls="user-collapse">User Information</a> </h5>
		        	</div>
			    	<div id="user-collapse" class="collapse show" role="tabpanel" aria-labelledby="user-heading" data-parent="#admin-accordion">
			      		<div class="card-body">
							<p><a href="user-table.php">View/Edit Users</a></p>
							<p><a href="password-table.php">Password Report</a></p>
						</div>
		        	</div>
				</div>
				<!-- ACCOUNT CARD -->
			  	<div class="card">
			    	<div class="card-header" role="tab" id="account-heading">
			      		<h5 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#account-collapse" role="button" aria-expanded="false" aria-controls="account-collapse">Accounts</a> </h5>
		        	</div>
			    	<div id="account-collapse" class="collapse" role="tabpanel" aria-labelledby="account-heading" data-parent="#admin-accordion">
			      		<div class="card-body">					
							<p><a href="account-table.php">View/Edit Accounts</a></p>
							<p><a href="#">Other stuff</a></p>
						</div>
		        	</div>
		      	</div>			  
		  	</div>
		</div>
		<div class="col-sm-9">
			<h2>View/Edit Accounts</h2>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
  </body>
</html>
