<?php
include('include/session.php');
if (isset($_SESSION['inactive'])) {
	header("Location: login.php");
} else {
	if ($_SESSION['user_type'] != 'admin') {
		if ($_SESSION['user_type'] == 'accountant') {
			header("Location: accountant-home.php");
		} elseif ($_SESSION['user_type'] == 'manager') {
			header("Location: manager-home.php");
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
		<div class="col-sm-4">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Administrator Account</h3>
			<hr>
			<h4>Select an option from the navigation menu.</h4>
		</div>
		<div class="col-sm-8" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
	</div>
	
	<!-- RATIO CARDS -->
	<div class="row">
		<div class="col-sm-11">			
			<div class="card-deck">
				<div id="current-ratio" class="card text-white mb-3"></div>
				<div id="return-assets" class="card text-white mb-3"></div>
				<div id="return-equity" class="card text-white mb-3"></div>
				<div id="debt-ratio" class="card text-white mb-3"></div>
				<div id="debt-equity" class="card text-white mb-3"></div>
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
		$(document).ready(function() {	
			
			// RATIO FUNCTIONS
			getRatios();
			function getRatios() {
				$.ajax ({
					url: "include/fetch-ratios.php",
					type: "POST",
					dataType: "JSON",
					success: function(data) {
						showRatios(...data);
					}
				})
			}
			
			function showRatios(...data) {
				// current ratio
				if (data[0] >= 1.5) {
					$('#current-ratio').addClass('bg-success');
				} else if (data[0] >= 1.0) {
					$('#current-ratio').addClass('bg-warning');
				} else {
					$('#current-ratio').addClass('bg-danger');
				}
				$('#current-ratio').html('<div class="card-header">Current Ratio</div><div class="card-body"><h5 class="card-title">'+data[0]+'</h5></div>');
				
				// return on assets
				if (data[1] >= .15) {
					$('#return-assets').addClass('bg-success');
				} else if (data[1] >= .05) {
					$('#return-assets').addClass('bg-warning');
				} else {
					$('#return-assets').addClass('bg-danger');
				}
				$('#return-assets').html('<div class="card-header">Return on Assets</div><div class="card-body"><h5 class="card-title">'+data[1]+'</h5></div>');
				
				// return on equity
				if (data[2] >= .20) {
					$('#return-equity').addClass('bg-success');
				} else if (data[2] >= .15) {
					$('#return-equity').addClass('bg-warning');
				} else {
					$('#return-equity').addClass('bg-danger');
				}
				$('#return-equity').html('<div class="card-header">Return on Equity</div><div class="card-body"><h5 class="card-title">'+data[2]+'</h5></div>');
				
				// debt ratio
				if (data[3] < .40) {
					$('#debt-ratio').addClass('bg-success');
				} else if (data[3] < .60) {
					$('#debt-ratio').addClass('bg-warning');
				} else {
					$('#debt-ratio').addClass('bg-danger');
				}
				$('#debt-ratio').html('<div class="card-header">Debt Ratio</div><div class="card-body"><h5 class="card-title">'+data[3]+'</h5></div>');
				
				// debt to equity ratio
				if (data[4] <= .30) {
					$('#debt-equity').addClass('bg-success');
				} else if (data[4] <= 1.0) {
					$('#debt-equity').addClass('bg-warning');
				} else {
					$('#debt-equity').addClass('bg-danger');
				}
				$('#debt-equity').html('<div class="card-header">Debt to Equity Ratio</div><div class="card-body"><h5 class="card-title">'+data[4]+'</h5></div>');
			}
		})
	</script>
  </body>
</html>
