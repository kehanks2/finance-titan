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
	$accountName = $_SESSION['accountName'];
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
		<div id="current-account" hidden><?php echo $accountName; ?></div>
	</div>
	<hr style="margin: 10px 0;">
	<div class="row form-inline choose-account">		
		<div class="form-group">
			<select class="form-control" id="choose-account">
				<option selected disabled>Select an account</option>
				<?php
					for($i = 0; $i < count($arr); $i++) {
						echo $arr[$i];
					}
				?>
			</select>
		</div>
		<div class="form-group">
			<button type="button" id="go-to-acct" class="btn btn-success btn-width" data-toggle="tooltip" title="Go to the ledger for the selected account">
				Go
			</button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-4">
			<h2 id="account-name"><?php echo $session ?></h2>
		</div>
	</div>
	<div class="row form-inline account-details">
		<div class="form-group">
			<h3 class="my-auto">Account Details</h3>
		</div>
		<?php if($_SESSION['user_type'] == 'admin') {
				echo '<div class="form-group">
					<button type="button" id="edit-acct" class="btn btn-primary btn-width" data-toggle="modal" data-target="#edit-modal">
						<span data-toggle="tooltip" title="Edit this account">Edit</span>
					</button>
				</div>';
			} ?>
		<hr>
	</div>	
	<?php if (isset($_SESSION['accountName'])) { ?>
		<div class="row acct-info">
			<div class="col-sm-auto">
				<ul><strong>
					<li>ID:</li>
					<li>Name:</li>
					<li>Category:</li>
					<li>Subcategory:</li>
					<li>Description:</li>
				</strong></ul>
			</div>
			<div class="col-sm-auto">
				<ul id="info">
					<li id="id"></li>
					<li id="acct-name"></li>
					<li id="cat"></li>
					<li id="subcat"></li>
					<li id="desc"></li>
				</ul>
			</div>
			<div class="col-sm-auto">
				<ul><strong>
					<li>Initial Bal:</li>
					<li>Debit:</li>
					<li>Credit:</li>
					<li>Current Bal:</li>
					<li>Normal Side:</li>
				</strong></ul>
			</div>
			<div class="col-sm-auto">
				<ul id="balance">
					<li id="init"></li>
					<li id="debit"></li>
					<li id="credit"></li>
					<li id="curr"></li>
					<li id="nside"></li>
				</ul>
			</div>
			<div class="col-sm-auto">
				<ul><strong>
					<li><a class="creation-event" data-target="#view-creation-modal" data-toggle="modal" type="button">Date Added:</a></li>
					<li>Creator:</li>
					<li>Account Stmt:</li>
					<li>Order:</li>
					<li>Active?:</li>
				</strong></ul>
			</div>
			<div class="col-sm-auto">
				<ul id="other">
					<a class="creation-event" data-target="#view-creation-modal" data-toggle="modal" type="button">
						<li id="date-added"></li>
					</a>
					<li id="creator"></li>
					<li id="acct-stmt"></li>
					<li id="order"></li>
					<li id="isactive"></li>
				</ul>
			</div>
		</div>
	<?php } ?>
	<div class="row">		
		<div class="col-sm-12">			
			<div class="table-responsive">				
				<!-- for jquery to place alert messages -->
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
				
				<table id="ledger-table" class="table table-striped" style="width:100%;">
					<thead>
						<tr>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by date">Date</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by creator">Creator</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by type">Type</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by debit amount">Debit</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by credit amount">Credit</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by status">Status</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Click to see the relevant journal entry">Entry</th>
						</tr>
					</thead>
				</table>
				<!-- JOURNAL TABLE END -->
			</div>
		</div>
	</div>
</section>

<!-- EDIT MODAL -->
<?php if ($_SESSION['user_type'] == 'admin') { ?>
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="edit-modal-label">Edit Account</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="edit-desc">Description:</label>
					<input type="text" class="form-control" id="edit-desc" placeholder="">
				</div>
				<div class="form-group">
					<label for="edit-cat">Category:</label>
					<input type="text" class="form-control" id="edit-cat" placeholder="">
				</div>
				<div class="form-group">
					<label for="edit-subcat">Subcategory:</label>
					<input type="text" class="form-control" id="edit-subcat" placeholder="">
				</div>
				<div class="form-group">
					<label for="edit-stmt">Account Statement:</label>
					<input type="text" class="form-control" id="edit-stmt" placeholder="">
				</div>
				<div class="form-group">
					<label for="edit-order">Order:</label>
					<input type="text" class="form-control" id="edit-order" placeholder="">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-width" id="submit-edit" data-dismiss="modal">Save Changes</button>
				<button type="button" class="btn btn-danger btn-width" id="cancel-edit" data-dismiss="modal">Cancel Edit</button>
			</div>
		</div>
	</div>
</div>
<?php } ?>
    
<!-- VIEW ENTRY MODAL -->
<div class="modal fade" id="view-entry-modal" tabindex="-1" role="dialog" aria-labelledby="view-entry-label" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="view-entry-label">Journal Entry</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<div class="form-group row">
					<div class="col-sm-auto">
						<label for="view-date"><strong>Date:</strong></label>
					</div>
					<div class="col-sm-auto" id="view-date"></div>
					<div class="col-sm-auto">
						<label for="view-creator"><strong>Creator:</strong></label>
					</div>
					<div class="col-sm-auto" id="view-creator"></div>
					<div class="col-sm-auto">
						<label for="view-status"><strong>Status</strong></label>
					</div>
					<div class="col-sm-auto" id="view-status"></div>
				</div>
				
				<div class="form-group row">
					<div class="col-sm-auto">
						<label for="view-type"><strong>Type:</strong></label>
					</div>
					<div class="col-sm-auto" id="view-type"></div>
					<div class="col-sm-auto">
						<label for="view-desc"><strong>Description:</strong></label>
					</div>
					<div class="col-sm-auto" id="view-desc"></div>
				</div>
					
				<div class="form-group row">
					<div class="col-sm-5">
						<label for="view-accounts"><strong>Accounts</strong></label>
					</div>
					<div class="col-sm-3">
						<label for="view-debits"><strong>Debits</strong></label>
					</div>
					<div class="col-sm-3">
						<label for="view-credits"><strong>Credits</strong></label>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-5" style="margin-left:15px;"id="view-accounts"></div>
					<div class="col-sm-3" id="view-debits"></div>					
					<div class="col-sm-3" id="view-credits"></div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<!-- VIEW CREATION EVENT MODAL -->
<div class="modal fade" id="view-creation-modal" tabindex="-1" role="dialog" aria-labelledby="view-creation-label" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="view-creation-label">Creation Event</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<div class="form-group row">
					<div class="col-sm-auto">
						<label for="c-date"><strong>Date:</strong></label>
					</div>
					<div class="col-sm-auto" id="c-date"></div>
					<div class="col-sm-auto">
						<label for="c-creator"><strong>Creator:</strong></label>
					</div>
					<div class="col-sm-auto" id="c-creator"></div>
					<div class="col-sm-auto">
						<label for="c-id"><strong>Event Log Id:</strong></label>
					</div>
					<div class="col-sm-auto" id="c-id"></div>
				</div>
				
				<div class="form-group row">
					<div class="col-sm-auto">
						<label for="c-initial"><strong>Initial:</strong></label>
					</div>
					<div class="col-sm-auto" id="c-initial"></div>
					<div class="col-sm-auto">
						<label for="c-cat"><strong>Category:</strong></label>
					</div>
					<div class="col-sm-auto" id="c-cat"></div>
					<div class="col-sm-auto">
						<label for="c-subcat"><strong>Subcategory:</strong></label>
					</div>
					<div class="col-sm-auto" id="c-subcat"></div>
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
			
			fetch_info();
			fetch_data();
			$('[data-toggle="tooltip"]').tooltip();
			
			// ledger table functions
			function fetch_data() {
				var accountName = $('#current-account').text();
				var dataTable = $('#ledger-table').DataTable({
					"processing": true,
					"serverSide": true,
					"dom": '<"top"f>t<"bottom"ip>',
					"order": [],
					"ajax": {
						url: "include/fetch-entries.php",
						type: "POST",
						data: {accountName: accountName}
					}
				});
			}			
						
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
						$('#ledger-table').DataTable().destroy();					
						fetch_data();
					}
				});
			}
			
			// get entry details (modal)
			function fetch_entry(entry_id, accountName) {
				$.ajax ({
					url: 'include/view-entry.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						entry_id: entry_id,
						accountName: accountName
					},
					success: function(data) {
						updateView(...data);
					}
				})
			}
			
			$('#ledger-table').on('click', '#view-entry-btn', function() {
				var entry_id = $(this).parents('tr').find('td').find('div').data("id");
				var accountName = $('#current-account').text();
				
				fetch_entry(entry_id, accountName);
			})
			
			function updateView(...data) {
				$('#view-date').html(data[0]);
				$('#view-creator').html(data[1]);
				$('#view-status').html(data[2]);
				$('#view-type').html(data[3]);				
				$('#view-desc').html(data[4]);
				
				$('#view-accounts').html(data[5]);
				$('#view-debits').html(data[6]);
				$('#view-credits').html(data[7]);
			}
			
			// get creation event details (modal)
			$('.creation-event').click(function() {				
				var accountName = $('#current-account').text();
				$.ajax ({
					url: 'include/view-creation.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						accountName: accountName
					},
					success: function(data) {
						updateC(...data);
					}
				})
			})
			
			function updateC(...data) {
				$('#c-date').html(data[0]);
				$('#c-creator').html(data[1]);
				$('#c-id').html(data[2]);
				$('#c-initial').html(data[3]);				
				$('#c-cat').html(data[4]);
				$('#c-subcat').html(data[5]);
			}
			 
			// ledger info functions
			function fetch_info() {
				var accountName = $('#current-account').text();
				if (accountName == "Select an account to view the ledger") {
					return;
				}
				
				$.ajax({
					url: "include/fetch-ledger.php",
					method: "POST",
					dataType: "JSON",
					data: {
						accountName: accountName
					},
					success: function(data) {
						insert_data(...data);
					}
				})
			};
								
			function insert_data(...data) {
				$('#id').html(data[0]);
				$('#acct-name').html(data[1]);
				$('#cat').html(data[2]);
				$('#subcat').html(data[3]);
				$('#desc').html(data[4]);

				$('#init').html(data[5]);
				$('#debit').html(data[6]);
				$('#credit').html(data[7]);
				$('#curr').html(data[8]);
				$('#nside').html(data[9]);

				$('#date-added').html(data[10]);
				$('#creator').html(data[11]);
				$('#acct-stmt').html(data[12]);
				$('#order').html(data[13]);
				$('#isactive').html(data[14]);
			};
			
			$('#go-to-acct').click(function() {
				var accountName = $('#choose-account').val();
				$.ajax({
					url: "include/change-acct.php",
					method: "POST",
					dataType: "JSON",
					data: {
						accountName: accountName
					},
					success: function(data) {
           				location.reload();
					}
				});
			});
			
			$('#submit-edit').click(function() {
				if ($('#edit-desc').val()) {
					var desc = $('#edit-desc').val();
				} else {
					var desc = $('#desc').text();
				}
				
				if ($('#edit-cat').val()) {
					var cat = $('#edit-cat').val();
				} else {
					var cat = $('#cat').text();
				}
				
				if ($('#edit-subcat').val()) {
					var subcat = $('#edit-subcat').val();
				} else {
					var subcat = $('#subcat').text();
				}
				
				if ($('#edit-stmt').val()) {
					var stmt = $('#edit-stmt').val();
				} else {
					var stmt = $('#acct-stmt').text();
				}
				
				if ($('#edit-order').val()) {
					var order = $('#edit-order').val();
				} else {
					var order = $('#order').text();
				}
				
				var id = $('#id').text();
				
				$.ajax({
					url: "include/update-ledger.php",
					method: "POST",
					dataType: "JSON",
					data: {
						desc: desc,
						cat: cat,
						subcat: subcat,
						stmt: stmt,
						order: order,
						id: id
					},
					success: function() {
						location.reload();
					}
				});				
			});
		})
		
	</script>
  </body>
</html>
