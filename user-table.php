<?php
include('include/session.php');
if (isset($_SESSION['inactive'])) {
	header("Location: login.php");
} else {
	if ($_SESSION['user_type'] != 'admin') {
		if ($_SESSION['user_type'] == 'accountant') {
			header("Location: accountant-home.php");
		} else if ($_SESSION['user_type'] == 'manager') {
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
    <title>Finance Titan - User Table</title>

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
	

	<div class="row">
		<!-- MAIN CONTENT -->
		<div class="col-sm-12">			
			<div class="table-responsive">
				<div class="row">
					<div class="col-sm-2 my-auto"><h2>View/Edit Users</h2></div>
					<div class="col-sm-1">
						<button name="add" id="add" type="button" class="btn btn-lg btn-primary btn-width" data-toggle="tooltip" data-placement="right" title="Click to add a new user">
							Add
						</button>
					</div>
				</div>
				<div id="alert_message"><br><br></div>
				<table id="user-table" class="table table-striped" style="width:100%;">
					<br />
					<thead>
						<tr>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by username">Username</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by last name">Last Name</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by first name">First Name</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by date of birth">Date of Birth</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by email address">Email</th>
							<th data-toggle="tooltip" data-placement="bottom" title="Sort by user type">User Type</th>
							<th>Edit</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>
	
	<!-- Active Modal -->
<div class="modal fade" id="active-modal" tabindex="-1" role="dialog" aria-labelledby="active-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="active-modal-label">Set User as Inactive</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="alert_active_modal"><br><br></div>
				<div hidden id="active-acct-id"></div>
				<div class="form-row">
					<div class="col-sm-auto">
						<input type="checkbox" class="form-check-inline" id="date-check">
						<label for="date-check" class="form-check-label">Set inactive indefinitely</label>
					</div>
				</div>
				<div class="row">
					<div class="col-auto form-inline">
						<label for="start-date" class="col-form-label">Start: </label>
						<input type="date" id="start-date" class="form-control">
					</div>
					<div class="col-auto form-inline">
						<label for="start-date" class="col-form-label">End: </label>
						<input type="date" id="end-date" class="form-control">
					</div>						
				</div>				
			</div>
			<div class="modal-footer">
				<div class="btn-group">
					<button type="button" class="btn btn-success btn-width" id="active-save">Save</button>
					<button type="button" class="btn btn-danger btn-width" id="active-cancel" data-dismiss="modal">Cancel</button>
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
	<script type="text/javascript" language="javascript" >
		$(document).ready(function(){

			fetch_data();
			$('[data-toggle="tooltip"]').tooltip();

			function fetch_data() {
				var dataTable = $('#user-table').DataTable({
					"processing" : true,
					"serverSide" : true,
					"dom": '<"top"f>t<"bottom"ip>',
                	"order": [[0, "asc"]],
					"ajax" : {
						url:"users/fetch.php",
						type:"POST"
					}
				});
			}

			function update_data(id, values) {
				var lastname = values[1];
				var firstname = values[2];
				var dob = values[3]
				var email = values[4];
				$.ajax({
					url:"users/update.php",
					method:"POST",
					dataType: "JSON",
					data:{
						id:id,
						lastname: lastname,
						firstname: firstname,
						dob: dob,
						email: email,
					},
					success:function(data) {
						getAlert(data);
					}
				});
				setInterval(function(){
					$('#alert_message').html('<br><br>');
				}, 5000);
			}
			
			$('#user-table').on('click', '#edit', function() {
				var currentTD = $(this).parents('tr').find('td');
				var isActive = $(this).parents('tr').find('#active').text();
				if (isActive == 'Active') {
					if ($(this).html() == 'Edit') {                  
						$.each(currentTD, function () {
							$(this).find('.edt').prop('contenteditable', true);
						});
						currentTD.find('#user-type').prop("disabled", false);

					} else {
						var id = $(this).parents('tr').find('td').find('div').data("id");
						var values = [];
						$.each(currentTD, function () {
							$(this).find('.edt').prop('contenteditable', false);
							values.push($(this).text());						
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
			
			function update_selected(selected, id) {
				$.ajax({
					url: 'users/update-selected.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						selected: selected,
						id: id
					}
				});
			}
			
			$('#user-table').on('change', '#user-type', function() {
				var selected = $('option:selected', this).text();
				var id = $(this).parents('tr').find('td').find('div').data("id");
				update_selected(selected, id);
			})
			
			function update_active(id, activeStatus, dates) {
				var userID = id;
				var isActive = activeStatus;
				var startDate = 0;
				var endDate = 0;
				if (dates != false) {
					startDate = dates[0];
					endDate = dates[1];
				}
				$.ajax({
					url: "users/update-active.php",
					method: "POST",
					dataType: "JSON",
					data: {
						userID: userID,
						isActive: isActive,
						startDate: startDate,
						endDate: endDate
					},
					success:function(data) {
						getAlert(data);
					}
				});
				setInterval(function(){
					$('#alert_message').html('<br><br>');
				}, 5000);
			};
			
			var active_id = "";
			$('#user-table').on('click', '#active', function() {
				var active_id = $(this).parents('tr').find('td').find('div').data("id");
				if ($(this).html() == 'Inactive') {
					var dates = Array();
					dates[0] = 0;
					dates[1] = 0;
					update_active(active_id, 1, dates);
					$(this).html('Active');
				} else {
					$('#active-acct-id').text(active_id);
				}
			});
			
			var isChecked = false;
			$('#date-check').change(function() {
				if(this.checked) {
					$(this).closest('.modal-body').find('#start-date').prop('disabled', 'disabled');
					$(this).closest('.modal-body').find('#end-date').prop('disabled', 'disabled');
					isChecked = true;
				} else {
					$(this).closest('.modal-body').find('#start-date').removeAttr('disabled');
					$(this).closest('.modal-body').find('#end-date').removeAttr('disabled');
					isChecked = false;
				}
			})
			
			$('#active-modal').on('click', '#active-save', function() {
				var dates = Array();
				active_id = $('#active-acct-id').text();
				if (isChecked) {
					dates[0] = 0;
					dates[1] = 0;
					update_active(active_id, 0, dates);
					$('#user-table').find('button[data-id="'+active_id+'"]').html('Inactive');					
					$('#active-modal').modal('hide');
				} else {
					var startDate = $(this).parent().parent().parent().find('#start-date').val();
					var endDate = $(this).parent().parent().parent().find('#end-date').val();

					if (startDate != '' && endDate != '') {
						if (startDate < endDate) {
							var d = new Date();
							var month = d.getMonth()+1;
							var day = d.getDate();
							var today = d.getFullYear() + '-' +
								((''+month).length<2 ? '0' : '') + month + '-' +
								((''+day).length<2 ? '0' : '') + day;
							if (endDate > today) {
								dates[0] = startDate;
								dates[1] = endDate;
								update_active(active_id, 0, dates);
								$('#user-table').find('button[data-id="'+active_id+'"]').html('Inactive');					
								$('#active-modal').modal('hide');
							} else {
								$('#alert_active_modal').html('<div class="alert alert-warning">End date must be after current date. S: '+startDate+', E: '+endDate+'</div>');
							}
						} else {
							$('#alert_active_modal').html('<div class="alert alert-warning">Start date must come before end date. S: '+startDate+', E: '+endDate+'</div>');
						}
					} else {
						$('#alert_active_modal').html('<div class="alert alert-warning">You must selected either <strong>indefinitely inactive</strong> or choose a start and end date.</div>');
					}
				}				
					
			})
			
			$('#add').click(function(){
				var html = '<tr>';
				html += '<td contenteditable="true" id="UserName"></td>';
				html += '<td contenteditable="true" id="LastName"></td>';
				html += '<td contenteditable="true" id="FirstName"></td>';
				html += '<td contenteditable="true" id="BirthDate"></td>';
				html += '<td contenteditable="true" id="EmailAddress"></td>';
				html += '<td id="UserType"><select id="user-type"><option>accountant</option><option>manager</option><option>admin</option></select></td>';
				html += '<td><button type="button" name="insert" id="insert" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Add new user account">Insert</button></td>';
				html += '</tr>';
				$('#user-table tbody').prepend(html);
			});

			$(document).on('click', '#insert', function(){
				var username = $('#UserName').text();	
				var lastname = $('#LastName').text();
				var firstname = $('#FirstName').text();
				var dob = $('#BirthDate').text();
				var email = $('#EmailAddress').text();				
				var usertype = $('#user-type option:selected').text();
				if(username != '' && firstname != '' && lastname != '' && email != '') {
					$.ajax({
						url:"users/insert.php",
						method:"POST",
						dataType: "JSON",
						data: {
							username: username,
							lastname: lastname,
							firstname: firstname,
							dob: dob,
							email: email,
							usertype: usertype
						},
						success:function(data) {
							getAlert(data);
						}
					});
					setInterval(function(){
						$('#alert_message').html('<br><br>');
					}, 5000);
				} else {
					alert("All fields are required");
				}
			});
			
			function getAlert(data) {
				if (data == "0") {
					$('#alert_message').html('<div class="alert alert-success">Account Saved.</div>');
					$('#user-table').DataTable().destroy();
					fetch_data();
				} else if (data == "1") {
					$('#alert_message').html('<div class="alert alert-success">Account Created. Please have user set up a password by going to the reset password form.</div>');
					$('#user-table').DataTable().destroy();
					fetch_data();
				} else {
					$('#alert_message').html('<div class="alert alert-danger">Something went wrong. Try again.</div>');
				}
			};
		});
		</script>
 
  </body>
</html>
