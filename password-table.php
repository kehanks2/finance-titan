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
    <title>Finance Titan - Password Report</title>

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
			<h2>Password Report</h2>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col" data-toggle="tooltip" data-placement="bottom" title="Sort by first name">First Name</th>
							<th scope="col" data-toggle="tooltip" data-placement="bottom" title="Sort by last name">Last Name</th>
							<th scope="col" data-toggle="tooltip" data-placement="bottom" title="Sort by username">Username</th>
							<th scope="col" data-toggle="tooltip" data-placement="bottom" title="Sort by expiry date">Password Expiry Date</th>
							<th scope="col" data-toggle="tooltip" data-placement="bottom" title="Sort by expired status">Expired?</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = "SELECT Users.*, Passwords.ExpiryDate FROM Users, Passwords WHERE Users.PasswordID = Passwords.PasswordID";
							$result = mysqli_query($db, $query);
							$currentDate = date("Y-m-d");

							if ($result) {
								while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
									echo "<tr><td>" . $row["FirstName"] . "</td>";
									echo "<td>" . $row["LastName"] . "</td>";
									echo "<td>" . $row["UserName"] . "</td>";
									echo "<td>" . $row["ExpiryDate"] . "</td>";
									
									$expiryDate = strtotime($row['ExpiryDate']);
									if ($expiryDate > $currentDate) {
										echo "<td>Yes</td>";
									} else {
										echo "<td>No</td>";
									}
									echo "</tr>";
								}
							}			
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
	<!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script><script type="text/javascript">
		$(function () {
  			$('[data-toggle="tooltip"]').tooltip();
		})
	</script>
  </body>
</html>
