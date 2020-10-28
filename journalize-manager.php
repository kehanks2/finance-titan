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
				<!-- SET FILTERS -->
				<div id="filters" role="tablist">
					<div class="card">
						<div class="card-header" role="tab" id="filters-head">
							<h5 style="margin-bottom:0;"><a href="#filters-collapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="filters-collapse">
								Filters
							</a></h5>
						</div>
						<div id="filters-collapse" class="collapse" role="tabpanel" aria-labelledby="filters-head" data-parent="#filters">
			      			<div class="card-body">
								<div class="row">
									<!-- date range filter -->
									<div class="col-auto form-inline">
										<label for="date-range" class="col-form-label"><strong>Date Range:</strong></label>
										<div class="date-range">
											<input type="date" class="form-control" id="startDate">
											<input type="date" class="form-control" id="endDate">
										</div>
									</div>
									<!-- amount range filter -->
									<div class="col-auto form-inline">
										<label for="amount-range" class="col-form-label"><strong>Amount Range:</strong></label>
										<div class="amount-range">
											<input type="number" class="form-control col-auto" id="minAmount" min="1" max="1000000">
											<input type="number" class="form-control" id="maxAmount" min="1" max="1000000">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-2">
									<!-- type filter -->
										<div class="form-group" id="choose-type">
											<label for="choose-type"><strong>Type</strong></label>
											<div class="form-inline">
												<input type="checkbox" value="regular" id="regular" name="choose-type" class="form-check"><label for="regular">Regular</label>
											</div>
											<div class="form-inline">
												<input type="checkbox" value="adjusting" id="adjusting" name="choose-type" class="form-check"><label for="adjusting">Adjusting</label>
											</div>
											<div class="form-inline">
												<input type="checkbox" value="reversing" id="reversing" name="choose-type" class="form-check"><label for="reversing">Reversing</label>
											</div>
											<div class="form-inline">
												<input type="checkbox" value="closing" id="closing" name="choose-type" class="form-check"><label for="closing">Closing</label>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
									<!-- status filter -->
										<div class="form-group" id="choose-status">
											<label for="choose-status"><strong>Status</strong></label>
											<div class="form-inline">
												<input type="checkbox" value="pending" id="pending" name="choose-status" class="form-check"><label for="pending">Pending</label>
											</div>
											<div class="form-inline">
												<input type="checkbox" value="approved" id="approved" name="choose-status" class="form-check"><label for="approved">Approved</label>
											</div>
											<div class="form-inline">
												<input type="checkbox" value="rejected" id="rejected" name="choose-status" class="form-check"><label for="rejected">Rejected</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<button type="button" class="btn btn-primary btn-width" id="apply-filters">
										Apply
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				
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
				<div id="alert-modal"><br><br></div>
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
									<option selected disabled value="x">Select account</option>
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
									<option selected disabled value="x">Select account</option>
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
								<button type="button" class="btn btn-danger btn-sm btn-width remove-btn">
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
					<button type="button" class="btn btn-success" id="submit-entry">
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
	
<!-- REJECTION COMMENT MODAL -->
<div class="modal fade" id="reject-modal" tabindex="-1" role="dialog" aria-labelledby="reject-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="reject-label">Rejection Comment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div hidden id="ledger-entry-id"></div>
				<div id="alert-reject"><br><br></div>
				<div class="form-group">
					<label for="reject-comment">Enter the reason for rejecting this entry:</label>
					<input type="text" class="form-control" id="reject-comment" placeholder="">
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-group" role="group" aria-label="submit-or-cancel">
					<button type="button" class="btn btn-success" id="submit-reject">
						Submit
					</button>
					<button type="button" class="btn btn-danger" id="cancel-reject" data-dismiss="modal">
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
			
			fetch_data();
			// enable tooltips, enable modals
			$('[data-toggle="tooltip"]').tooltip();
			
			//*** table functions ***//
			// get data and generate table
			function fetch_data() {
				var manager = true;
				var dataTable = $('#journalize-table').DataTable({
					"processing": true,
					"serverSide": true,
					"dom": '<"top"f>t<"bottom"ip>',
					"order": [],
					"ajax": {
						url: "journalize/fetch.php",
						type: "POST",
						data: {manager: manager}
					}
				});
			};
						
			$('#apply-filters').click(function () {
				var d = new Date();
				var month = d.getMonth()+1;
				var day = d.getDate();
				var today = d.getFullYear() + '-' +
					((''+month).length<2 ? '0' : '') + month + '-' +
					((''+day).length<2 ? '0' : '') + day;
				
				var filters = Array();
				//date range
				if ($('#startDate').val()) {
					filters.push($('#startDate').val());
					if ($('#endDate').val()) {
						filters.push($('#endDate').val());
					} else {
						filters.push(today);
					}
				} else {
					filters.push('1969-12-31');
					if ($('#endDate').val()) {
						filters.push($('#endDate').val());
					} else {
						filters.push(today);
					}
				}
				//amount range
				if ($('#minAmount').val()) {
					filters.push($('#minAmount').val());
					if ($('#maxAmount').val()) {
						filters.push($('#maxAmount').val());
					} else {
						filters.push(1000000);
					}
				} else {
					filters.push(1);
					if ($('#maxAmount').val()) {
						filters.push($('#maxAmount').val());
					} else {
						filters.push(1000000);
					}
				}
				
				//type filters
				$.each($('input[name="choose-type"'), function() {
					if ($(this).is(':checked')) {
						filters.push(1);
					} else {
						filters.push(0);
					}
				});
				
				//status filters
				$.each($('input[name="choose-status"'), function() {
					if ($(this).is(':checked')) {
						filters.push(1);
					} else {
						filters.push(0);
					}
				});
				
				setFilters(filters)
			})
						
			function setFilters(filters) {
				$.ajax ({
					method: 'POST',
					url: 'journalize/set-filters.php',
					dataType: 'text',
					data: {
						startDate: filters[0],
						endDate: filters[1],
						minAmount: filters[2],
						maxAmount: filters[3],
						type1: filters[4],
						type2: filters[5],
						type3: filters[6],
						type4: filters[7],
						status1: filters[8],
						status2: filters[9],
						status3: filters[10],
					}, 
					success: function(data) {	
						$('#journalize-table').DataTable().destroy();					
						fetch_data();
					}
				});
			}
			
			function approveEntry(id) {
				$.ajax ({
					url: 'journalize/approve.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						id: id
					},
					success: function(data) {
						getAlert(data);
					}
				})
			}
			
			// approve btn function
			$('#journalize-table').on('click', '.approve-btn', function() {
				var id = $(this).parents('tr').find('td').find('div').data("id");
				
				approveEntry(id);
				
			})
			
			function rejectEntry(id, comment) {
				$.ajax ({
					url: 'journalize/reject.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						id: id,
						comment: comment
					},
					success: function(data) {
						getAlert(data);
					}
				})
			}
			
			// approve btn function
			$('#journalize-table').on('click', '.reject-btn', function() {
				var id = $(this).parents('tr').find('td').find('div').data("id");
				$('#ledger-entry-id').text(id);				
			});
			
			var comment = '';
			$('#reject-comment').on('blur', function() {
				comment = $(this).val();
			})
			
			$('#submit-reject').click(function() {
				$('#submit-reject').attr('disabled', 'disabled');
				
				var id = $('#ledger-entry-id').text();
				if (comment.length != 0) {
					rejectEntry(id, comment);
					$('#reject-modal').modal('hide');					
				} else {
					getAlert('no comment');
					$('#submit-reject').removeAttr('disabled');
				}
			});
			
			//*** modal functions ***//
			// global vars for submit
			var num_debit_accts = 1;
			var num_credit_accts = 1;	
			
			function submitEntry(date, creator, type, desc, ed, ec) {
				$.ajax ({
						url: 'journalize/insert.php',
						method: 'POST',
						dataType: 'JSON',
						data: {
							date: date,
							creator: creator,
							status: 'Approved',
							type: type,
							desc: desc,
							debit: ed,
							credit: ec,
							manager: true
						},
						success: function(data) {
							getAlert(data);
							$('#submit-entry').removeAttr('disabled');
						}
					})
			}
			
			// submit entry functions
			$('#submit-entry').click(function() {
				$('#submit-entry').attr('disabled', 'disabled');
				
				var error = false;
				var error_message = '';
				// get all entry info				
				var date = $('#entry-date').val();
				var creator = $('#creator-username').val();
				var type = $('#entry-type').val();
				var desc = $('#entry-desc').val();
				
				// put all debit data in an array
				var debit = [];
				var total_debit = parseFloat(0);
				for (var i = 0; i < num_debit_accts; i++) {
					let id = '#choose-debit'+i;
					if ($(id).length) {
						let acct = $(id).find(":selected").val();
						if (acct == 'x') {
							error_message = 'no account';
							error = true;
						}
						id = '#debit-amt'+i;
						let amt = $(id).val();
						amt = Math.floor(amt * 100) / 100;
						total_debit += amt;
						debit[i] = [acct, amt];
					}
				}
				
				// put all credit data in an array
				var credit = [];
				var total_credit = parseFloat(0);
				for (var i = 0; i < num_credit_accts; i++) {
					let id = '#choose-credit'+i;
					if ($(id).length) {
						let acct = $(id).find(":selected").val();
						if (acct == 'x') {
							error_message = 'no account';
							error = true;
						}
						id = '#credit-amt'+i;
						let amt = $(id).val();
						amt = Math.floor(amt * 100) / 100;;
						total_credit += amt;
						credit[i] = [acct, amt];
					}	
				}
				
				var ed = JSON.stringify(debit);
				var ec = JSON.stringify(credit);
				
				// check for accounting errors:
				if (total_debit != total_credit) {
					error_message = 'not equal';
					error = true;
				} 
				
				if (!error) {
					submitEntry(date, creator, type, desc, ed, ec);
					$('#new-entry-modal').modal('hide');
				} else {
					error = false;
					getAlert(error_message)
					$('#submit-entry').removeAttr('disabled');
					error_message = '';
				}		
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
				div_next.find('input').text('');
				
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
				div_next.find('input').text('');
				
				// insert new line after previous
				$(div_next).insertAfter(div_prev);
				
				num_credit_accts++;
			})
			
			function getAlert(data) {
				// ajax response alerts
				if (data == 0) {
					$('#alert-message').html('<div class="alert alert-success">Your entry has been successfully posted.</div>');
					$('#journalize-table').DataTable().destroy();
					fetch_data();
				} else if (data == 1) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (1).</strong> Please try again.</div>');
				} else if (data == 2) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (2).</strong> Please try again.</div>');
				} else if (data == 3) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (3).</strong> Please try again.</div>');
				}
				
				// accounting error alerts
				if (data == 'not equal') {
					$('#alert-modal').html('<div class="alert alert-warning"><strong>Debits and Credits must be equal.</strong> Please try again.</div>');
				}
				if (data == 'no account') {
					$('#alert-modal').html('<div class="alert alert-warning"><strong>You must select an account.</strong> Please try again.</div>');
				}
				
				// approve/reject alerts
				if (data == 10) {
					$('#alert-message').html('<div class="alert alert-success">The entry has been approve and the account has been updated.</div>');
					$('#journalize-table').DataTable().destroy();
					fetch_data();
				} else if (data == 11) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (1).</strong> Please try again.</div>');
				} else if (data == 12) {
					$('#alert-message').html('<div class="alert alert-success">The entry has been rejected.</div>');
					$('#journalize-table').DataTable().destroy();
					fetch_data();
				} else if (data == 13) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>An error occurred (1).</strong> Please try again.</div>');
				} else if (data == 'no comment') {
					$('#alert-reject').html('<div class="alert alert-warning">You must enter a comment to reject the entry.</div>');
				}
				
				
				
				setTimeout( function() {
					$('#alert-message').html('<br><br>');
					$('#alert-modal').html('<br><br>');
					$('#alert-reject').html('<br><br>');
				}, 5000);
			}
			
		});
	</script>
	</body>
</html>