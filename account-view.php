<?php
include('include/session.php');
if ($_SESSION['user_type'] == 'admin') {
	header("Location: admin-home.php");
} else if ($_SESSION['user_type'] == 'inactive') {
	header("Location: login.php");
} else if ($_SESSION['user_type'] == '') {
	header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Titan - Chart of Accounts</title>

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
	
	<!-- WELCOME -->	
	<div class="row">
		<div class="col-sm-4">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Administrator Account</h3>
		</div>
		<div class="col-sm-8" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
	</div>
	
	<!-- MAIN CONTENT -->
	<div class="row">		
		<div class="col-sm-12">			
			<div class="table-responsive">
				<div class="row">
					<div class="col-sm-2"><h2>Chart of Accounts</h2></div>
				</div>
				<table id="account-table" class="table table-striped" style="width:100%;">
					<br />
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Description</th>
							<th>Category</th>
							<th>Subcategory</th>
							<th>Initial Bal</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Current Bal</th>
							<th>Normal Side</th>
							<th>Date Added</th>
							<th>Creator</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>
	<!-- Include all compiled plugins (below), or include individual files as needed --> 
  	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			fetch_data();
			
			function fetch_data() {
				var dataTable = $('#account-table').DataTable({
					"processing": true,
					"serverSide": true,
					"dom": '<"top"f>t<"bottom"ip>',
					"order": [],
					"ajax": {
						url: "accounts/fetch.php",
						type: "POST"
					}
				});
			};
		})
	</script>
</body>
</html>
