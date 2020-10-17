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

$query = "SELECT * FROM Accounts";
$result = mysqli_query($db, $query);

$arr = array();
while ($row = mysqli_fetch_array($result)) {
	$arr[] = '<option value="' .$row["AccountNumber"]. '">' .$row["AccountName"]. '</option>';
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
				<div id="alert-message"><br><br></div>
				<!-- JOURNAL TABLE START -->
				<table id="journalize-table" class="table table-striped" style="width:100%;">
					<thead>
						<tr>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by date">Date</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by creator">Creator</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by type">Type</th>
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
						<input type="text" class="form-control-plaintext my-auto" id="entry-date" placeholder="<?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" readonly>
					</div>
					<div class="col-sm-auto">
						<label for="creator-username" class="col-form-label my-auto">Creator: </label>
					</div>
					<div class="col-sm-auto">
						<input type="text" class="form-control-plaintext my-auto" id="creator-username" placeholder="<?php echo $login_session; ?>" value="<?php echo $login_session; ?>" readonly>
					</div>						
				</div>
				<div class="form-group">
					<label for="entry-type">Type</label>
					<input type="text" class="form-control" id="entry-type" placeholder="">
				</div>
				<div class="form-group">
					<label for="entry-desc">Description</label>
					<input type="text" class="form-control" id="entry-desc" placeholder="">
				</div>
				<!-- debit and credit accounts row -->
				<div class="row">
					<!-- debits column -->
					<div class="col-sm-6" id="debit-accts">
						<label class="form-label" for="debit-accts">Debits</label>
						<!-- first/starting debit acct row -->
						<div class="row acct-row" id="debit-row0">								
							<div class="col-auto form-inline">
								<!-- account dropdown -->
								<select class="form-control choose-debit" id="choose-debit0">
									<option selected disabled>Select account</option>
										<?php
											for($i = 0; $i < count($arr); $i++) {
												echo $arr[$i];
											}
										?>
								</select>				
								<!-- acct amount column -->
								<label for="debit-amt0" class="col-form-label">$</label>
								<input type="text" class="form-control debit-amt" id="debit-amt0" placeholder="0.00">
								<!-- remove line button column -->
								<button type="button" class="btn btn-danger btn-sm btn-width remove-btn">
									<i class="fa fa-close sm-icon"></i>
								</button>
							</div>
						</div>
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
						<div class="row acct-row" id="credit-row0">
							<div class="col form-inline">
								<!-- account dropdown column -->
								<select class="form-control choose-credit" id="choose-credit0">
									<option selected disabled>Select account</option>
										<?php
											for($i = 0; $i < count($arr); $i++) {
												echo $arr[$i];
											}
										?>
								</select>
								<!-- acct amount column -->
								<label for="credit-amt0" class="col-form-label">$</label>
								<input type="text" class="form-control credit-amt" id="credit-amt0" placeholder="0.00">
								<!-- remove line button column -->
								<button type="button" class="btn btn-danger btn-sm btn-width remove-button">
									<i class="fa fa-close sm-icon"></i>
								</button>
							</div>
						</div>
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
  	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			// enable tooltips, enable modals
			$('[data-toggle="tooltip"]').tooltip();
			
			//*** table functions ***//
			// get data and generate table
			function fetch_data() {
				var dataTable = $('#journalize-table').DataTable({
					"processing": true,
					"serverSide": true,
					"dom": '<"top"f>t<"bottom"ip>',
					"order": [],
					"ajax": {
						url: "journalize/fetch.php",
						type: "POST"
					}
				});
			};
			
			
			//*** modal functions ***//
			// global vars for submit
			var num_debit_accts = 1;
			var num_credit_accts = 1;
			
			
			// submit entry functions
			$('#submit-entry').click(function() {
				// get all entry info				
				var date = $('#entry-date').val();
				var creator = $('#creator-username').val();
				var type = $('#entry-type').val();
				var desc = $('#entry-desc').val();
				
				// put all debit data in an array
				var debit = [];
				for (let i = 0; i < num_debit_accts; i++) {
					let id = '#choose-debit'+i;
					if (document.getElementById(id)) {
						let acct = $(id).find(":selected").val();
						id = '#debit-amt'+i;
						let amt = $(id).val();
						amt = parseFloat(amt).toFixed(2);
						debit[i] = [acct, amt];
					}						
				}
				
				// put all credit data in an array
				var credit = [];
				for (let i = 0; i < num_credit_accts; i++) {
					let id = '#choose-credit'+i;
					if (document.getElementById(id)) {
						let acct = $(id).find(":selected").val();
						id = '#credit-amt'+i;
						let amt = $(id).val();
						amt = parseFloat(amt).toFixed(2);
						credit[i] = [acct, amt];
					}						
				}
				
				var ed = JSON.stringify(debit);
				var ec = JSON.stringify(credit);
				
				$.ajax ({
					url: 'journalize/insert.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						date: date,
						creator: creator,
						status: 'Pending',
						type: type,
						desc: desc,
						debit: ed,
						credit: ec						
					},
					success: function(data) {
						getAlert(data);
					}
				})			
			})
			
			// remove credit or debit acct line
			$('#new-entry-modal').on('click', '.remove-btn', function() {
				// get current line
				var div_current = $(this).parent('div').parent('div');
				// check if div is a credit or debit line
				var id = div_current.prop("id");
				var credit = /credit/;
				var debit = /debit/;
				// deduct from the appropriate num accts count
				if (credit.test(id)) {
					num_credit_accts--;
				} else if (debit.test(id)){
					num_debit_accts--;
				}
				// remove div element + it's child elements
				div_current.remove();				
			})
			
			//add new debit line
			$('#add-debit').click(function() {
				// get previous account line & child info and clone, changing id to id + 1
				var div_prev = $('div[id^="debit-row"]:last');
				var num = parseInt(div_prev.prop("id").match(/\d+/g), 10 ) +1;
				var div_next = div_prev.clone().prop('id', 'debit-row'+num);
				
				// change specified child elements' attributes to id + 1
				div_next.find('select').attr('id', 'choose-debit'+num);
				div_next.find('label').attr('for', 'debit-amt'+num);
				div_next.find('input').attr('id', 'debit-amt'+num);
				
				// insert new line after previous
				$(div_next).insertAfter(div_prev);
				
				num_debit_accts++;
			})
			
			//add new credit line
			$('#add-credit').click(function() {
				// get previous account line & child info and clone, changing id to id + 1
				var div_prev = $('div[id^="credit-row"]:last');
				var num = parseInt(div_prev.prop("id").match(/\d+/g), 10 ) +1;
				var div_next = div_prev.clone().prop('id', 'credit-row'+num);
				
				// change specified child elements' attributes to id + 1
				div_next.find('select').attr('id', 'choose-credit'+num);
				div_next.find('label').attr('for', 'credit-amt'+num);
				div_next.find('input').attr('id', 'credit-amt'+num);
				
				// insert new line after previous
				$(div_next).insertAfter(div_prev);
				
				num_credit_accts++;
			})
			
			function getAlert(data) {
				if (data == 0) {
					$('#alert-message').html('<div class="alert alert-success">Your entry has been submitted for approval.</div>');
					$('#journalize-table').DataTable().destroy();
					fetch_data();
				} else if (data == 1) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (1).</strong> Please try again.</div>');
				} else if (data == 2) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (2).</strong> Please try again.</div>');
				} else if (data == 3) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (3).</strong> Please try again.</div>');
				}
			}
			
		});
	</script>
	 </body>
</html>
