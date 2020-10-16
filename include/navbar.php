<?php
if (!isset($_SESSION['login_user']) || isset($_SESSION['inactive'])) {
?> 

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<img src="images/logo-no-bg.png" id="navbar-logo">
	<a class="navbar-brand" href="index.php">Finance Titan</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<form method="post">
					<input type="hidden" id="dp" class="datepicker">
					<span class="btn" id="dp-btn"><i class="fa fa-calendar" style="color: white;"></i></span>			
				</form>				
			</li>
		</ul>
		<ul class="navbar-nav d-flex justify-content-end">	
			<li>
				<a class="nav-link" id="logout" href="login.php">Log In</a>
			</li>
		</ul>
	</div>
</nav> 

<?php
} else if ($_SESSION['user_type'] == "admin"){
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<img src="images/logo-no-bg.png" id="navbar-logo">
	<a class="navbar-brand" href="admin-home.php">Finance Titan</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="admin-home.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Messages</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				System Management</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="account-table.php">Chart of Accounts</a>
					<a class="dropdown-item" href="ledger.php">Ledger</a>
					<a class="dropdown-item" href="event-log.php">Event Log</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="user-table.php">Manage Users</a>
					<a class="dropdown-item" href="password-table.php">Password Report</a>
					
				</div>
			</li>
			<li class="nav-item">
				<form>
					<input type="hidden" id="dp" class="datepicker">
					<span class="btn" id="dp-btn"><i class="fa fa-calendar" style="color: white;"></i></span>			
				</form>				
			</li>
		</ul>
		<ul class="navbar-nav d-flex justify-content-end">			
			<li class="nav-item nav-user-profile">Logged in as:</li>
			<li class="nav-item">
				<div class="nav-link nav-username" href="#">
					<?php echo $_SESSION['login_user']; ?>
				</div>
			</li>
			<li class="nav-item user-icon">
				<i class="fa fa-user-o"></i>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="logout" href="include/logout.php">Log Out</a>
			</li>
		</ul>
	</div>
</nav>

<?php
} else if ($_SESSION['user_type'] == "accountant"){
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<img src="images/logo-no-bg.png" id="navbar-logo">
	<a class="navbar-brand" href="accountant-home.php">Finance Titan</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="accountant-home.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Messages</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				System Management</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
					<a class="dropdown-item" href="account-view.php">Chart of Accounts</a>
					<a class="dropdown-item" href="ledger.php">Ledger</a>
					<a class="dropdown-item" href="journalize-accountant.php">Journalize</a>
					<a class="dropdown-item" href="event-log.php">Event Log</a>
				</div>
			</li>			
			<li class="nav-item">
				<form method="post" onsubmit="return false;">
					<input type="hidden" id="dp" class="datepicker">
					<span class="btn" id="dp-btn"><i class="fa fa-calendar" style="color: white;"></i></span>			
				</form>				
			</li>
		</ul>
		<ul class="navbar-nav d-flex justify-content-end">			
			<li class="nav-item nav-user-profile">Logged in as:</li>
			<li class="nav-item">
				<div class="nav-link nav-username" href="#">
					<?php echo $_SESSION['login_user']; ?>
				</div>
			</li>
			<li class="nav-item user-icon">
				<i class="fa fa-user-o"></i>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="logout" href="include/logout.php">Log Out</a>
			</li>
		</ul>
	</div>
</nav>

<?php 
} else if ($_SESSION['user_type'] == "manager"){
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<img src="images/logo-no-bg.png" id="navbar-logo">
	<a class="navbar-brand" href="manager-home.php">Finance Titan</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="manager-home.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Messages</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				System Management</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown3">
					<a class="dropdown-item" href="account-view.php">Chart of Accounts</a>
					<a class="dropdown-item" href="ledger.php">Ledger</a>
					<a class="dropdown-item" href="journalize-manager.php">Journalize</a>
					<a class="dropdown-item" href="event-log.php">Event Log</a>
				</div>
			</li>			
			<li class="nav-item">
				<form method="post" onsubmit="return false;">
					<input type="hidden" id="dp" class="datepicker">
					<span class="btn" id="dp-btn"><i class="fa fa-calendar" style="color: white;"></i></span>			
				</form>				
			</li>
		</ul>
		<ul class="navbar-nav d-flex justify-content-end">			
			<li class="nav-item nav-user-profile">Logged in as:</li>
			<li class="nav-item">
				<div class="nav-link nav-username" href="#">
					<?php echo $_SESSION['login_user']; ?>
				</div>
			</li>
			<li class="nav-item user-icon">
				<i class="fa fa-user-o"></i>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="logout" href="include/logout.php">Log Out</a>
			</li>
		</ul>
	</div>
</nav>

<?php
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script type="text/javascript" language="javascript" >
	$(document).ready(function(){

		var isHidden = true;
		$("#dp").datepicker();
		$(document).on("click", "#dp-btn", function(e) {
			if (isHidden) {				
				$("#dp").datepicker('show');
			} else {
				$("#dp").datepicker('hide');
			}
			
			isHidden = !isHidden;			
		});
	});
</script>