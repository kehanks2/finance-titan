<?php
// includes session file to check usertype.
// redirects to home or login if not admin
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
	<!-- HEADER -->
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
	<!-- Welcome message with username & user type-->
	<div class="row">
		<div class="col-sm-4">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Administrator Account</h3>
		</div>
		<div class="col-sm-8" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
		<!-- for jquery access to username -->
		<div id="currentuser" hidden><?php echo $login_session; ?></div>
	</div>
	
	
	<!-- MAIN CONTENT -->
		<div class="row">		
		<div class="col-sm-12">			
			<div class="table-responsive">
				<div class="row">
					<!-- table title and add button -->
					<div class="col-sm-2 my-auto"><h2>Chart of Accounts</h2></div>
					<div class="col-sm-1">
						<button name="add" id="add" type="button" class="btn btn-lg btn-primary btn-width" data-toggle="tooltip" data-placement="right" title="Click to add a new account">
							Add
			
						</button>
					</div>
				</div>
				<!-- for qjuery to place alert messages -->
				<div id="alert_message"><br><br></div>
				<!-- ACCOUNT TABLE START -->
				<table id="account-table" class="table table-striped" style="width:100%;">
					<thead>
						<tr>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by account #">#</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by account name">Name</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by description">Description</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by category">Category</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by subcategory">SubCat.</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by initial balance">Initial</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by debit amount">Debit</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by credit amount">Credit</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by current balance">Current</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by normal side">Normal Side</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by date added">Date Added</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by creator">Creator</th>
							<th>Edit</th>
						</tr>
					</thead>
				</table>
				<!-- ACCOUNT TABLE END -->
			</div>
		</div>
	</div>
</section>
    <!-- Include all compiled plugins (below), or include individual files as needed --> 
  	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script><script type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			fetch_data();
			// for bootstrap style tooltips
			$('[data-toggle="tooltip"]').tooltip();
			
			// get data and generate table
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
			
			// update table with values specified by user
			function update_data(id, values) {
				var desc = values[0];
				var subcat = values[1];				
				var initbal = values[2];
				var debit = values[3];				
				var credit = values[4];	
				var accountID = id;
				$.ajax({
					url:"accounts/update.php",
					method:"POST",
					dataType: "JSON",
					data:{
						desc: desc,
						subcat: subcat,				
						initbal: initbal,
						debit: debit,
						credit: credit,
						accountID: accountID
					},
					success:function(data) {
						getAlert(data);	
					}
				});
				setInterval(function(){
					$('#alert_message').html('<br><br>');
				}, 5000);
			};
			
			// on click function for edit buttons
			$('#account-table').on('click', '#edit', function() {
				var isActive = $(this).parents('tr').find('#active').text();
				if (isActive == 'Active') {
					// only allow edits if account is active, otherwise display error message
					var currentTD = $(this).parents('tr').find('td');
					if ($(this).html() == 'Edit') {     
						// if button text = Edit, make fields with class edt editable             
						$.each(currentTD, function () {
							$(this).find('.edt').prop('contenteditable', true);
						});
						currentTD.find('#category').prop('disabled', false);
						currentTD.find('#nside').prop('disabled', false);
					
					} else {
						// if button text != Edit, make fields with class edt no longer editable
						var id = $(this).parents('tr').find('td').find('div').data("id");
						var values = [];
						$.each(currentTD, function () {
							$(this).find('.edt').prop('contenteditable', false);
							if($(this).find('div').hasClass('edt')) {
								// if field has class num, sav value in format xx.xx
								if ($(this).hasClass('num')) {
									var nextval = $(this).text();
									nextval.replace(",", "");
									nextval = parseFloat(nextval.toFixed(2));
									values.push(nextval);
								} else {
									values.push($(this).text());
								}
							}						
						});
						
						update_data(id, values);
					}
					// switch button text between Edit and Save
					$(this).html($(this).html() == 'Edit' ? 'Save' : 'Edit')
				} else {
					$('#alert_message').html('<div class="alert alert-warning">Cannot edit inactive accounts.</div>');
										
					setInterval(function(){
						$('#alert_message').html('<br><br>');
					},5000);
				}

			});
			
			//update dropdown options
			function update_selected(name, selected, id) {
				$.ajax({
					url: 'accounts/update-selected.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						name: name,
						selected: selected,
						id: id
					}
				});
			}
			
			$('#account-table').on('change', '#category', function() {
				var name = "Category";
				var selected = $('option:selected', this).text();
				var id = $(this).parents('tr').find('td').find('div').data("id");
				update_selected(name, selected, id);
			})
			
			$('#account-table').on('change', '#nside', function() {
				var name = "NormalSide";
				var selected = $('option:selected', this).text();
				var id = $(this).parents('tr').find('td').find('div').data("id");
				update_selected(name, selected, id);
			})
						
			// update active status of specified account
			function update_active(id, activeStatus) {
				var accountID = id;
				var isActive = activeStatus;
				$.ajax({
					url: "accounts/update-active.php",
					method: "POST",
					dataType: "JSON",
					data: {
						accountID: accountID,
						isActive: isActive
					},
					success:function(data) {
						getAlert(data);
					}
				});
				setInterval(function(){
					$('#alert_message').html('<br><br>');
				}, 5000);
			};
			
			// on click function for active button
			$('#account-table').on('click', '#active', function() {
				var id = $(this).parents('tr').find('td').find('div').data("id");
				var bal = $(this).parents('tr').find('#CurrentBalance').text();
				if ($(this).html() == 'Active') {
					// if button text = Active and balance is 0, change active status to inactive
					if (bal == 0) {						
						update_active(id, 0);					
						$(this).html('Inactive');
					} else {
						// is bal != 0, display error message
						$('#alert_message').html('<div class="alert alert-warning">Accounts with a balance cannot be deactivated.</div>');
						
						setInterval(function(){
							$('#alert_message').html('<br><br>');
						}, 5000);
					}
				} else if ($(this).html() == 'Inactive') {
					// if button text = Inactive, change active status to active
					update_active(id, 1);
					$(this).html('Active');
				}
			});
			
			// redirect user specified account's ledger page
			function to_ledger(id, accountName) {
				$.ajax({
					url: "accounts/to-ledger.php",
					method: "POST",
					data: {
						accountID: id,
						accountName: accountName
					},
					success: function(data) {
						window.location.assign(data);
					}
				})
			}
			
			// on click function for account page to ledger
			$('#account-table').on('click', '#ledger', function() {
				var accountName = $(this).text();
				var id = $(this).parents('tr').find('td').find('div').data("id");
				to_ledger(id, accountName);
			});
			
			$('#account-table').on('click', '#ledger-id', function() {
				var accountName = $(this).parents('tr').find('td').find('div').data("name");
				var id = $(this).text();
				to_ledger(id, accountName);
			});
			
			// on click function for add button
			$('#add').click(function(){
				// auto generate current date
				var d = new Date();
				var month = d.getMonth()+1;
				var day = d.getDate();
				var today = d.getFullYear() + '-' +
					((''+month).length<2 ? '0' : '') + month + '-' +
					((''+day).length<2 ? '0' : '') + day;
				// row html to be prepended to the table
				var html = '<tr>';
				html += '<td contenteditable="true" id="AccountNumber"></td>';
				html += '<td contenteditable="true" id="AccountName"></td>';
				html += '<td contenteditable="true" id="Description"></td>';
				html += '<td contenteditable="true" id="Category"></td>';
				html += '<td contenteditable="true" id="SubCategory"></td>';
				html += '<td contenteditable="true" id="InitialBalance"></td>';
				html += '<td contenteditable="true" id="Debit"></td>';
				html += '<td contenteditable="true" id="Credit"></td>';
				html += '<td contenteditable="false" id="CurrentBalance"></td>';
				html += '<td contenteditable="true" id="NormalSide"><select id="n-side"><option>left</option><option>right</option></select></td>';
				html += '<td contenteditable="false" id="DateAdded">' + today + '</td>';
				html += '<td contenteditable="false" id="CreatorID">' + $('#currentuser').text() + '</td>';
				html += '<td><button type="button" name="insert" id="insert" data-toggle="tooltip" data-placement="bottom" title="Save new account" class="btn btn-success">Insert</button></td>';
				html += '</tr>';
				$('#account-table tbody').prepend(html);
			});

			// on click function for insert button
			$(document).on('click', '#insert', function(){
				var accountID = $('#AccountNumber').text();	
				var accountname = $('#AccountName').text();
				var desc = $('#Description').text();
				var cat = $('#Category').text();
				var subcat = $('#SubCategory').text();				
				var initbal = parseFloat($('#InitialBalance').text()).toFixed(2);
				var debit = parseFloat($('#Debit').text()).toFixed(2);				
				var credit = parseFloat($('#Credit').text()).toFixed(2);				
				var nside = $('#n-side option:selected').text();
				var dateadded = $('#DateAdded').text();				
				var creator = $('#CreatorID').text();
				
				// auto calculate current balance based on init, debit, credit, and nside
				var currbal = 0;
				if (nside == "right") {
					currbal = initbal + credit - debit;
				} else if (nside == "left") {
					currbal = initbal + debit - credit;
				}
				
				if(isNaN(accountID)) {
					// if account id is not a number, display error message
					$('#alert_message').html('<div class="alert alert-warning">Account ID must be a number.</div>');
				} else {
					// otherwise, update database with new account
					if(accountID != '' && accountname != '') {
						$.ajax({
							url:"accounts/insert.php",
							method:"POST",
							dataType: "JSON",
							data: {
								accountID: accountID,
								accountname: accountname,
								desc: desc,
								cat: cat,
								subcat: subcat,
								initbal: initbal,
								debit: debit,
								credit: credit,
								currbal: currbal,
								nside: nside,
								dateadded: dateadded,
								creator: creator
							},
							success:function(data) {
								getAlert(data);
							}
						});
						setInterval(function(){
							$('#alert_message').html('<br><br>');
						}, 5000);
					} else {
						$('#alert_message').html('<div class="alert alert-warning">Account ID and Name are required.</div>');
					}
				}
			});
			
			// alert messages for ajax success
			function getAlert(data) {
				if (data == "0") {
					$('#alert_message').html('<div class="alert alert-success">Account Saved.</div>');
					$('#account-table').DataTable().destroy();
					fetch_data();
				} else if (data == "1") {
					$('#alert_message').html('<div class="alert alert-warning">Account ID must be unique.</div>');
				} else if (data == "2") {
					$('#alert_message').html('<div class="alert alert-warning">Account Name must be unique.</div>');
				} else {
					$('#alert_message').html('<div class="alert alert-danger">Something went wrong. Try again.</div>');
				}
			};
		})
	</script>
</body>
</html>
