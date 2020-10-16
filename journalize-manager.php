<?php
include('include/session.php');
if (isset($_SESSION['inactive'])) {
	header("Location: login.php");
} else {
	if ($_SESSION['user_type'] != 'manager') {
		if ($_SESSION['user_type'] != 'accountant') {
			if ($_SESSION['user_type'] == 'admin') {
				header("Location: admin-home.php");
			} else {
				header("Location: login.php");				
			}
		} else {
			header("Location: journalize-accountant.php");
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
    <title>Finance Titan - Journalize</title>

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
	</div>
	<div class="row">		
		<div class="col-sm-12">			
			<div class="table-responsive">
				<div class="row">
					<!-- table title and add button -->
					<div class="col-sm-2 my-auto"><h2>Journalize</h2></div>
					<div class="col-sm-2">
						<button name="add" id="add" type="button" class="btn btn-lg btn-primary btn-width" data-toggle="tooltip" data-placement="right" title="Click to add a new journal entry">
							+ New Entry
						</button>
					</div>
				</div>
				<!-- for qjuery to place alert messages -->
				<div id="alert_message"><br><br></div>
				<!-- JOURNAL TABLE START -->
				<table id="account-table" class="table table-striped" style="width:100%;">
					<thead>
						<tr>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by date">Date</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by type">Type</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by creator">Creator</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by accounts">Accounts</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by debit amount">Debit</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by credit amount">Credit</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by status">Status</th>
						</tr>
					</thead>
				</table>
				<!-- JOURNAL TABLE END -->
			</div>
		</div>
	</div>
</section>
	
	<!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			fetch_data();
			$('[data-toggle="tooltip"]').tooltip();
			
		});
	</script>
	 </body>
</html>
