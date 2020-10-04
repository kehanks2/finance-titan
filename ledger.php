<?php
include('include/session.php');
if (isset($_SESSION['inactive'])) {
	header("Location: login.php");
} else {
	if ($_SESSION['user_type'] != 'admin') {
		if ($_SESSION['user_type'] != 'accountant') {
			if ($_SESSION['user_type'] != 'manager') {
				header("Location: login.php");
			}
		}
	}
}

if (!isset($_SESSION['accountName'])) {
	$session = "Select an account to view the ledger";
} else {
	$session = $_SESSION['accountName'] . ' Ledger';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Titan - Ledger</title>

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

<section id="ledger" class="container-fluid home-screen">	
	<div class="row">
		<div class="col-sm-4">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<?php
				if ($_SESSION['user_type'] == 'admin') {
					echo "<h3>Administrator Account</h3>";
				} else if ($_SESSION['user_type'] == 'manager') {
					echo "<h3>Manager Account</h3>";
				} else if ($_SESSION['user_type'] == 'accountant') {
					echo "<h3>Accountant Account</h3>";
				}
			?>
		</div>
		<div class="col-sm-8" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
		<div id="currentuser" hidden><?php echo $login_session; ?></div>
	</div>
	
	<div class="row">		
		<div class="col-sm-12">			
			<div class="table-responsive">
				<div class="row">
					<div class="col-sm-auto"><h2><?php echo $session ?></h2></div>
				</div>
				<div id="alert_message"><br><br></div>
				<table id="event-table" class="table table-striped" style="width:100%;">
					<br />
					<thead>
						<tr>
							<th></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>
    
    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  </body>
</html>
