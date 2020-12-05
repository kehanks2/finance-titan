<?php
include('include/session.php');
if (isset($_SESSION['inactive'])) {
	header("Location: login.php");
} else {
	if ($_SESSION['user_type'] != 'manager') {
		if ($_SESSION['user_type'] == 'admin') {
			header("Location: admin-home.php");
		} elseif ($_SESSION['user_type'] == 'accountant') {
			header("Location: accountant-home.php");
		} else {
			header("Location: login.php");
		}
	}
}
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
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
	      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
  </head>
<body>
	  
  <!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

<section id="admin-home" class="container-fluid home-screen">
	<div class="row">
		
		<!-- SIDE BAR -->
		<div class="col-sm-auto">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Manager Account</h3>
			<hr>
			<h4>Select an option from the navigation menu.</h4>
		</div>
		<div class="col-sm-8" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
	</div>
	<!-- MANAGER - NEW ENTRIES ALERT -->
	<div class="row">
		<div class="col-sm-12">
			<div id="alert-message"></div>
		</div>
	</div>
	<!-- RATIO CARDS -->
	<div class="row">
		<div class="col-sm-12">
			<div class="card-deck">
				<div id="current-ratio" class="card"></div>
				<div id="debt-ratio" class="card"></div>
				<div id="3-ratio" class="card"></div>
				<div id="4-ratio" class="card"></div>
			</div>
		</div>
	</div>
	
</section>
	
    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(function () {
  			$('[data-toggle="tooltip"]').tooltip();
		})
	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			
			// MANAGER ONLY FUNCTIONS
			// checks database for number of pending entries...
			getAlert();
			function getAlert() {
				$.ajax ({
					url: "include/fetch-alerts.php",
					type: "POST",
					dataType: "JSON",
					success: function(data) {
						showAlert(data);
					}
				})
			}
			
			// ...and displays a specific alert depending on if there are 0 or more than 0 pending.
			function showAlert(data) {
				if (data != 0) {
					var html = '<div class="alert alert-warning"><a href="journalize.php" class="text-decoration-none" style="color:#856404;">There are '+data+' pending journal entries. Click to go to journalize.</a></div>';
				} else {
					var html = '<div class="alert alert-success">There are '+data+' pending journal entries.</div>';
				}
				$('#alert-message').html(html);
			}
			
			// RATIO FUNCTIONS
			
		})
	
	</script>
  </body>
</html>	
	