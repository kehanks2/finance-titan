<?php
include('include/session.php');
if ($_SESSION['user_type'] != 'admin') {
	if ($_SESSION['user_type'] == 'accountant') {
		header("Location: accountant-home.php");
	} elseif ($_SESSION['user_type'] == 'manager') {
		header("Location: manager-home.php");
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
  </head>
<body>
	  
  <!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

<section id="admin-home" class="container-fluid home-screen">
	
	<!-- WELCOME -->	
	<div class="row">
		<div class="col-sm-3">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Administrator Account</h3>
		</div>
	</div>
	

	<div class="row">
		<!-- SIDE BAR ACCORDION -->
		<div class="col-sm-3">
			<h2>Management Options</h2>
			<div id="admin-accordion" role="tablist">
				<!-- USER CARD -->
				<div class="card">
			    	<div class="card-header" role="tab" id="user-heading">
			      		<h5 class="mb-0"> <a data-toggle="collapse" href="#user-collapse" role="button" aria-expanded="true" aria-controls="user-collapse">User Information</a> </h5>
		        	</div>
			    	<div id="user-collapse" class="collapse show" role="tabpanel" aria-labelledby="user-heading" data-parent="#admin-accordion">
			      		<div class="card-body">
							<p><a href="user-table.php">View/Edit Users</a></p>
							<p><a href="password-table.php">Password Report</a></p>
						</div>
		        	</div>
				</div>
				<!-- ACCOUNT CARD -->
			  	<div class="card">
			    	<div class="card-header" role="tab" id="account-heading">
			      		<h5 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#account-collapse" role="button" aria-expanded="false" aria-controls="account-collapse">Accounts</a> </h5>
		        	</div>
			    	<div id="account-collapse" class="collapse" role="tabpanel" aria-labelledby="account-heading" data-parent="#admin-accordion">
			      		<div class="card-body">					
							<p><a href="#account-table">View/Edit Accounts</a></p>
							<p><a href="#">Other stuff</a></p>
						</div>
		        	</div>
		      	</div>			  
		  	</div>
		</div>
		
		<!-- MAIN CONTENT -->
		<div class="col-sm-9">
			<div class="row">
				<h2>View/Edit Users</h2>
			</div>
			<div class="table-responsive">
				<br />
				<div align="left">
					<button name="add" id="add" type="button" class="btn btn-link" style="font-weight: 600; width:auto;">Add</button>
				</div>
				<br />
				<div id="alert_message"></div>
				<br />
				<table id="user-table" class="table table-striped" style="width:100%;">
					<br />
					<thead>
						<tr>
							<th>Username</th>
							<th>Last Name</th>
							<th>First Name</th>
							<th>Email</th>
							<th>User Type</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed --> 
  	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
  	<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" language="javascript" >
		$(document).ready(function(){

			fetch_data();

			function fetch_data() {
				var dataTable = $('#user-table').DataTable({
					"processing" : true,
					"serverSide" : true,
					"dom": '<"top"f>t<"bottom"ip>',
					"order" : [],
					"ajax" : {
						url:"include/fetch.php",
						type:"POST"
					}
				});
			}

			function update_data(id, column_name, value) {
				$.ajax({
					url:"include/update.php",
					method:"POST",
					data:{id:id, column_name:column_name, value:value},
					success:function(data) {
						$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
						$('#user-table').DataTable().destroy();
						fetch_data();
					}
				});
				setInterval(function(){
					$('#alert_message').html('');
				}, 5000);
			}

			$(document).on('blur', '.update', function(){
				var id = $(this).data("id");
				var column_name = $(this).data("column");
				var value = $(this).text();
				update_data(id, column_name, value);
			});

			$('#add').click(function(){
				var html = '<tr>';
				html += '<td contenteditable id="UserName"></td>';
				html += '<td contenteditable id="LastName"></td>';
				html += '<td contenteditable id="FirstName"></td>';
				html += '<td contenteditable id="EmailAddress"></td>';
				html += '<td contenteditable id="UserType"></td>';
				html += '<td><button type="button" name="insert" id="insert" class="btn btn-link">Insert</button></td>';
				html += '</tr>';
				$('#user-table tbody').prepend(html);
			});

			$(document).on('click', '#insert', function(){
				var username = $('#UserName').text();	
				var lastname = $('#LastName').text();
				var firstname = $('#FirstName').text();			
				var email = $('#EmailAddress').text();				
				var usertype = $('#UserType').text();
				if(username != '' && firstname != '' && lastname != '' && email != '' && usertype !='') {
					$.ajax({
						url:"include/insert.php",
						method:"POST",
						data: {
							username: username,
							lastname: lastname,
							firstname: firstname,
							email: email,
							usertype: usertype
						},
						success:function(data) {
							$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
							$('#user-table').DataTable().destroy();
							fetch_data();
						}
					});
					setInterval(function(){
						$('#alert_message').html('');
					}, 5000);
				} else {
					alert("All fields are required");
				}
			});
		});
		</script>
 
  </body>
</html>
