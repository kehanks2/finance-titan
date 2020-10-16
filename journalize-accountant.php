<?php
include('include/session.php');
if (isset($_SESSION['inactive'])) {
	header("Location: login.php");
} else {
	if ($_SESSION['user_type'] != 'accountant') {
		if ($_SESSION['user_type'] != 'manager') {
			if ($_SESSION['user_type'] == 'admin') {
				header("Location: admin-home.php");
			} else {
				header("Location: login.php");				
			}
		} else {
			header("Location: journalize-manager.php");
		}
	}
}

$query = "SELECT AccountName FROM Accounts";
$result = mysqli_query($db, $query);

$arr = array();
while ($row = mysqli_fetch_array($result)) {
	$arr[] = '<option value="' .$row["AccountName"]. '">' .$row["AccountName"]. '</option>';
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
						<button id="new-entry-btn" type="button" class="btn btn-lg btn-primary btn-width" data-toggle="modal" data-target="#new-entry-modal">
							<span data-toggle="tooltip" data-placement="right" title="Click to add a new journal entry">
								+ New Entry
							</span>
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
	
<!-- NEW ENTRY MODAL -->
<div class="modal fade" id="new-entry-modal" tabindex="-1" role="dialog" aria-labelledby="new-entry-label" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="new-entry-label">New Journal Entry</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row" id="readonly-entry">		
					<div class="col-sm-auto">
						<label for="entry-date" class="col-form-label my-auto">Date: </label>
					</div>
					<div class="col-sm-auto">
						<input type="text" class="form-control-plaintext my-auto" id="entry-date" placeholder="<?php echo date("Y-m-d")?>" readonly>
					</div>
					<div class="col-sm-auto">
						<label for="creator-username" class="col-form-label my-auto">Creator: </label>
					</div>
					<div class="col-sm-auto">
						<input type="text" class="form-control-plaintext my-auto" id="creator-username" placeholder="<?php echo $login_session; ?>" readonly>
					</div>						
				</div>
				<div class="form-group">
					<label for="edit-cat">Type</label>
					<input type="text" class="form-control" id="edit-cat" placeholder="">
				</div>
				<div class="form-group">
					<label for="edit-subcat">Description</label>
					<input type="text" class="form-control" id="edit-subcat" placeholder="">
				</div>
				<!-- debit and credit accounts row -->
				<div class="row">
					<!-- debits column -->
					<div class="col-sm-6" id="debit-accts">
						<label class="form-label" for="debit-accts">Debits</label>
						<!-- first/starting debit acct row -->
						<div class="row acct-row">								
							<div class="col-auto form-inline">
								<!-- account dropdown -->
								<select class="form-control my-auto" id="choose-debit">
									<option selected disabled>Select account</option>
										<?php
											for($i = 0; $i < count($arr); $i++) {
												echo $arr[$i];
											}
										?>
								</select>				
								<!-- acct amount column -->
								<label for="debit-amt" class="col-form-label my-auto">$</label>
								<input type="text" class="form-control my-auto" id="debit-amt">
								<!-- save/remove line button column -->
								<div class="btn-group btn-group-sm" role="group">
									<button type="button" class="btn btn-success btn-sm">
										<i class="fa fa-check sm-icon"></i>
									</button>
									<button type="button" class="btn btn-danger btn-sm">
										<i class="fa fa-close sm-icon"></i>
									</button>
								</div>
							</div>
						</div>
						<!-- additional accounts empty div / row -->
						<div id="add-debit-acct"></div>
						<!-- add another debit acct button row -->
						<div class="row add-btn-row">
							<button class="btn btn-primary btn-sm btn-width" type="button" id="add-debit">
								Additional Debit
							</button>
						</div>						
					</div>
					<!-- credits column -->
					<div class="col-sm-6" id="credit-accts">
						<label class="form-label" for="credit-accts">Credits</label>
						<!-- first/starting credit acct row -->
						<div class="row acct-row">
							<div class="col form-inline">
								<!-- account dropdown column -->
								<select class="form-control" id="choose-credit">
									<option selected disabled>Select account</option>
										<?php
											for($i = 0; $i < count($arr); $i++) {
												echo $arr[$i];
											}
										?>
								</select>
								<!-- acct amount column -->
								<label for="credit-amt" class="col-form-label">$</label>
								<input type="text" class="form-control" id="credit-amt">
								<!-- save/remove line button column -->
								<div class="btn-group btn-group-sm" role="group">
									<button type="button" class="btn btn-success btn-sm">
										<i class="fa fa-check sm-icon"></i>
									</button>
									<button type="button" class="btn btn-danger btn-sm">
										<i class="fa fa-close sm-icon"></i>
									</button>
								</div>
							</div>
						</div>
						<!-- additional accounts empty div / row -->
						<div id="add-credit-acct"></div>
						<!-- add another debit acct button row -->
						<div class="row add-btn-row">
							<button class="btn btn-primary btn-sm btn-width" type="button" id="add-credit">
								Additional Credit
							</button>
						</div>						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-group" role="group" aria-label="submit-or-cancel">
					<button type="button" class="btn btn-success" id="submit-entry" data-dismiss="modal">
						Submit
					</button>
					<button type="button" class="btn btn-danger" id="cancel-entry" data-dismiss="modal">
						Cancel
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
	
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
