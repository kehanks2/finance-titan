<?php
if (!isset($_SESSION['login_user']) || $_SESSION['user_type'] == "inactive") {
	echo 
		'<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
						<a class="nav-link disabled" href="#">Messages</a>
					</li>			
				</ul>
				<ul class="navbar-nav d-flex justify-content-end">	
					<li>
						<a class="nav-link" id="logout" href="login.php">Log In</a>
					</li>
				</ul>
			</div>
		</nav>';
} else if ($_SESSION['user_type'] == "admin"){
	echo 
		'<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
							<a class="dropdown-item" href="user-table.php">Manage Users</a>
							<a class="dropdown-item" href="password-table.php">Password Report</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="account-table.php">Manage Accounts</a>
							<a class="dropdown-item" href="event-log.php">Event Log</a>
						</div>
					</li>
				</ul>
				<ul class="navbar-nav d-flex justify-content-end">			
					<li class="nav-item nav-user-profile">Logged in as:</li>
					<li class="nav-item">
						<div class="nav-link nav-username" href="#">';
	echo $_SESSION['login_user'];
	echo 				'</div>
					</li>
					<li class="nav-item user-icon">
						<i class="fa fa-user-o"></i>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="logout" href="include/logout.php">Log Out</a>
					</li>
				</ul>
			</div>
		</nav>';
} else if ($_SESSION['user_type'] == "accountant"){
	echo
		'<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
							<a class="dropdown-item" href="account-view.php">Manage Accounts</a>
							<a class="dropdown-item" href="event-log.php">Event Log</a>
						</div>
					</li>
				</ul>
				<ul class="navbar-nav d-flex justify-content-end">			
					<li class="nav-item nav-user-profile">Logged in as:</li>
					<li class="nav-item">
						<div class="nav-link nav-username" href="#">';
	echo $_SESSION['login_user'];
	echo 				'</div>
					</li>
					<li class="nav-item user-icon">
						<i class="fa fa-user-o"></i>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="logout" href="include/logout.php">Log Out</a>
					</li>
				</ul>
			</div>
		</nav>';
} else if ($_SESSION['user_type'] == "manager"){
	echo
		'<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
							<a class="dropdown-item" href="account-view.php">Manage Accounts</a>
							<a class="dropdown-item" href="event-log.php">Event Log</a>
						</div>
					</li>
				</ul>
				<ul class="navbar-nav d-flex justify-content-end">			
					<li class="nav-item nav-user-profile">Logged in as:</li>
					<li class="nav-item">
						<div class="nav-link nav-username" href="#">';
	echo $_SESSION['login_user'];
	echo 				'</div>
					</li>
					<li class="nav-item user-icon">
						<i class="fa fa-user-o"></i>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="logout" href="include/logout.php">Log Out</a>
					</li>
				</ul>
			</div>
		</nav>';
}