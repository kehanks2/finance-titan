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
					<li>Description:</li>
					<li>Category:</li>
					<li>Subcategory:</li>
				</strong></ul>
			</div>
			<div class="col-sm-auto">
				<ul id="info">
					<li id="id"></li>
					<li id="acct-name"></li>
					<li id="desc"></li>
					<li id="cat"></li>
					<li id="subcat"></li>
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
					<li>Date Added:</li>
					<li>Creator:</li>
					<li>Account Stmt:</li>
					<li>Order:</li>
					<li>Active?:</li>
				</strong></ul>
			</div>
			<div class="col-sm-auto">
				<ul id="other">
					<li id="date-added"></li>
					<li id="creator"></li>
					<li id="acct-stmt"></li>
					<li id="order"></li>
					<li id="isactive"></li>
				</ul>
			</div>
		</div>
	<?php } ?>
	<div class="row">
		<div class="col-sm-auto">
			<h4>Ledger will go here</h4>		
		</div>
	</div>
</section>
	
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
    
    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			fetch_data();
			$('[data-toggle="tooltip"]').tooltip();
			
			function fetch_data() {
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
				$('#desc').html(data[2]);
				$('#cat').html(data[3]);
				$('#subcat').html(data[4]);

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
