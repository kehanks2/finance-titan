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
		<div id="currentuser" hidden><?php echo $login_session; ?></div>
	</div>
	
	<!-- MAIN CONTENT -->
	<div class="row">		
		<div class="col-sm-12">			
			<div class="table-responsive">
				<div class="row">
					<div class="col-sm-2"><h2>Chart of Accounts</h2></div>
					<div class="col-sm-1">
						<button name="add" id="add" type="button" class="btn btn-lg btn-primary" style="font-weight: 600; width:auto;" data-toggle="tooltip" data-placement="right" title="Click to add a new account">
							Add
						</button>
					</div>
				</div>
				<div id="alert_message"><br><br></div>
				<table id="account-table" class="table table-striped" style="width:100%;">
					<thead>
						<tr>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by account #">#</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by account name">Name</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by description">Description</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by category">Category</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by subcategory">Subcategory</th>
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
			$('[data-toggle="tooltip"]').tooltip();
			
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
			
			function update_data(id, values) {
				var desc = values[0];
				var cat = values[1];
				var subcat = values[2];				
				var initbal = values[3];
				var debit = values[4];				
				var credit = values[5];				
				var nside = values[6];
				var accountID = id;
				$.ajax({
					url:"accounts/update.php",
					method:"POST",
					dataType: "JSON",
					data:{
						desc: desc,
						cat: cat,
						subcat: subcat,				
						initbal: initbal,
						debit: debit,
						credit: credit,
						nside: nside,
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
			
			$('#account-table').on('click', '#edit', function() {
				var isActive = $(this).parents('tr').find('#active').text();
				if (isActive == 'Active') {
					var currentTD = $(this).parents('tr').find('td');
					if ($(this).html() == 'Edit') {                  
						$.each(currentTD, function () {
							$(this).find('.edt').prop('contenteditable', true);
						});

					} else {
						var id = $(this).parents('tr').find('td').find('div').data("id");
						var values = [];
						$.each(currentTD, function () {
							$(this).find('.edt').prop('contenteditable', false);
							if($(this).find('div').hasClass('edt')) {
								if ($(this).hasClass('num')) {
									var nextval = $(this).text();
									nextval = parseFloat(nextval.toFixed(2));
									values.push(nextval);
								} else {
									values.push($(this).text());
								}
							}						
						});

						update_data(id, values);
					}

					$(this).html($(this).html() == 'Edit' ? 'Save' : 'Edit')
				} else {
					$('#alert_message').html('<div class="alert alert-warning">Cannot edit inactive accounts.</div>');
										
					setInterval(function(){
						$('#alert_message').html('<br><br>');
					},5000);
				}

			});
			
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
			
			$('#account-table').on('click', '#active', function() {
				var id = $(this).parents('tr').find('td').find('div').data("id");
				var bal = $(this).parents('tr').find('#CurrentBalance').text();
				if ($(this).html() == 'Active') {
					if (bal == 0) {						
						update_active(id, 0);					
						$(this).html() = 'Inactive';
					} else {
						$('#alert_message').html('<div class="alert alert-warning">Accounts with a balance cannot be deactivated.</div>');
						
						setInterval(function(){
							$('#alert_message').html('<br><br>');
						}, 5000);
					}
				} else if ($(this).html() == 'Inactive') {
					update_active(id, 1);
					$(this).html() = 'Active';
				}
			});
			
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
			
			$('#account-table').on('click', '#ledger', function() {
				var accountName = $(this).text();
				var id = $(this).parents('tr').find('td').find('div').data("id");
				to_ledger(id, accountName);
			});
			
			$('#add').click(function(){
				var d = new Date();
				var month = d.getMonth()+1;
				var day = d.getDate();
				var today = d.getFullYear() + '-' +
					((''+month).length<2 ? '0' : '') + month + '-' +
					((''+day).length<2 ? '0' : '') + day;
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
				html += '<td contenteditable="true" id="NormalSide"></td>';
				html += '<td contenteditable="false" id="DateAdded">' + today + '</td>';
				html += '<td contenteditable="false" id="CreatorID">' + $('#currentuser').text() + '</td>';
				html += '<td><button type="button" name="insert" id="insert" data-toggle="tooltip" data-placement="bottom" title="Save new account" class="btn btn-link">Insert</button></td>';
				html += '</tr>';
				$('#account-table tbody').prepend(html);
			});

			$(document).on('click', '#insert', function(){
				var accountID = $('#AccountNumber').text();	
				var accountname = $('#AccountName').text();
				var desc = $('#Description').text();
				var cat = $('#Category').text();
				var subcat = $('#SubCategory').text();				
				var initbal = parseFloat($('#InitialBalance').text().toFixed(2));
				var debit = parseFloat($('#Debit').text().toFixed(2));				
				var credit = parseFloat($('#Credit').text().toFixed(2));				
				var nside = $('#NormalSide').text();
				var dateadded = $('#DateAdded').text();				
				var creator = $('#CreatorID').text();
				
				var currbal = 0;
				if (nside == "right") {
					currbal = initbal + credit - debit;
				} else if (nside == "left") {
					currbal = initbal + debit - credit;
				}
				
				if(isNaN(accountID)) {
					$('#alert_message').html('<div class="alert alert-warning">Account ID must be a number.</div>');
				} else {
				
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
