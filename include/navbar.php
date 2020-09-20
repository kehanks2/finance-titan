<?php
if (!isset($_SESSION['login_user'])) {
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
} else {
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
							<a class="dropdown-item" href="#">Manage Users</a>
							<a class="dropdown-item" href="#">Manage Accounts</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Something else here</a>
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