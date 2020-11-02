 <?php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);

	//session_start();
	include("include/session.php");
    ?>



<!DOCTYPE html>
<html lang="en">
<!-- HEADER -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Send Message</title>

	<!-- Stylesheets -->
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

<!-- PAGE CONTENT -->
<section class="container-fluid">
	<div class="row">
		<div class="col-sm-12" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
	</div>
	<div class="d-flex justify-content-center">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<h2>Messaging System</h2>
				</div>
				<div class="col-sm-9">
					<h2>Inbox</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3" style="padding-right:5px; border-right: 1px solid #ccc;">
					<a class="nav-link" href="messaging_page.php"><h5>New Message</h5></a>
					<h5>Inbox</h5>
					<h5>Sent</h5>
				</div>
				<div class="col-sm-9">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th data-toggle="tooltip" data-placement="bottom" title="Sort by sender">Sender</th>
									<th data-toggle="tooltip" data-placement="bottom" title="Sort by subject">Subject</th>
									<th data-toggle="tooltip" data-placement="bottom" title="Sort by time">Time</th>
									<th data-toggle="tooltip" data-placement="bottom" title="Sort by message">Message</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = "SELECT * FROM Messages WHERE Recipient = '".$login_session."'";

								$result = mysqli_query($db, $query);

								while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
									echo "<tr><td>" . $row["Sender"] . "</td>";
									echo "<td>" . $row["Subject"] . "</td>";
									echo "<td>" . $row["Timesent"] . "</td>";
									echo "<td>" . $row["Message"] . "</td>";
									echo "</tr>";
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
	// enable tooltips and popovers
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
	
	// return true if first character is a letter
	function isLetter(str) {
		var first = str.charAt(0);
  		return first.match(/[A-Z|a-z]/i);
	}
	function messageSent(form) {
		alert("\nSuccess!\nYour message has been sent.");
		
	}
</script>
</body>
	
	<footer>
	
	</footer>
</html>
