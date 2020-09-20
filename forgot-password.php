 <?php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);

	session_start();
	include("include/config.php");

	$sq = '';

	if (isset($_POST["continue"])) {
		if (isset($_POST["username"]) && $_POST["username"] != '' && isset($_POST["email"]) && $_POST["email"] != '') {
		// values sent from form 
			$email = mysqli_real_escape_string($db,$_POST['email']);
			$username = mysqli_real_escape_string($db,$_POST['username']);

			$sql_security = "SELECT SecurityQuestion FROM Passwords WHERE (SELECT PasswordID FROM Users WHERE UserName = '$username' and EmailAddress = '$email') = Passwords.PasswordID";
			$sql_securitya = "SELECT SecurityAnswer FROM Passwords WHERE (SELECT PasswordID FROM Users WHERE UserName = '$username' and EmailAddress = '$email') = Passwords.PasswordID";

			$get_security = mysqli_query($db, $sql_security);
			$get_answer = mysqli_query($db, $sql_securitya);
			if ($get_security && $get_answer) {
				while ($row = mysqli_fetch_assoc($get_security)) {
					$jsonArray[] = $row['SecurityQuestion'];
					$sq = json_encode($jsonArray);
				}
				while ($row2 = mysqli_fetch_assoc($get_answer)) {
					$_SESSION['sanswer'] = $row2['SecurityAnswer'];
				}
			} else {
				echo "<div class='alert-message'>That username and email combination was not found.</div>";
			}
		}
	} else {
		echo "<div class='alert-message'>There was an error with continue.</div>";
	}

	if (isset($_POST['security'])) {
		if (isset($_POST["security-answer"]) && $_POST['security-answer'] != '') {
			if ($_POST["security-answer"] == $_SESSION['sanswer']) {
				$_SESSION['resetpw'] = $_SESSION['security-answer'];
			} else {
				echo "<div class='alert-message'>The security answer you entered is incorrect.</div>";
			}
		}
	} else {
		echo "<div class='alert-message'>There was an error with security.</div>";
	}

	if (isset($_POST['submit'])) {
		if (isset($_POST["newpassword"]) && isset($_POST["newpasswordcheck"]))
		{
			$email = mysqli_real_escape_string($db,$_POST['email']);
			$username = mysqli_real_escape_string($db,$_POST['username']);
			$newpassword = mysqli_real_escape_string($db, $_POST["newpassword"]);

			$sql_password = "INSERT INTO Passwords VALUE CurrentPassword WHERE (SELECT PasswordID FROM Users WHERE UserName = '$username' and EmailAddress = '$email') = Passwords.PasswordID";
			$set_password = mysqli_query($db, $sql_password);

			if ($set_password) {
				echo "<div class='alert-message'>Your password has been reset.</div>";
				header("Location: login.php");
			} else {
				echo "<div class='alert-message'>There was an error resetting your password.</div>";
			}
		}
	} else {
		echo "<div class='alert-message'>There was an error with submit.</div>";
	}
?>

<!DOCTYPE html>
<html lang="en">
	<!-- HEADER -->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Finance Titan - Forgot Password</title>

		<!-- Stylesheets -->
		<link href="css/bootstrap-4.4.1.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	
<body>
<!-- NAVIGATION -->
<?php include("include/navbar.php"); ?>

<!-- BANNER -->
<?php include("include/banner.php"); ?>

<!-- PAGE CONTENT -->
<section id="forgot-password-form" class="d-flex justify-content-center">
	<div class="col-md-4 sign-in-form">
		<form class="form-group" id="get-security" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="text-center">
				<h2>Reset Your Password</h2>
				<p>Enter the information below to reset your password.</p>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="username" id="username" placeholder="Username">
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email" id="email" placeholder="Email">
			</div>
			<div class="text-center">
				<button type="submit" id="continue" name="continue" class="btn btn-lg btn-primary">Submit</button>
			</div>
		</form>
		<form class="form-group" id="security-check" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<?php
				if($sq != '') {
					echo '<div class="form-group row">
							<input type="text" class="security-question" name="security-question" id="security-question" value="' . $sq . '" readonly>
						</div>';			
					echo '<div class="form-group row">
							<input type="password" name="security-response" id="security-response" placeholder="Security Answer">
						</div>';
					echo '<div class="text-center">
							<button type="submit" id="security" name="security" class="btn btn-lg btn-primary">Submit</button>
						</div>';
				} else {
					echo '<div></div>';
				}
			?>
		</form>
		<form class="form-group" id="reset-password" method="POST" onSubmit="accountCreated(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<?php 
				if (isset($_SESSION['resetpw']) && $_SESSION['resetpw'] == $_SESSION['security-answer']) {
					echo '<div class="form-group row""> 
					    	<input type="password" name="newpassword" id="newpassword" placeholder="Enter New Password>
						</div>';
					echo '<div class="col-1 help-icon">
							<i class="fa fa-question-circle-o" data-toggle="popover" title="Password Requirements" data-html="true" data-content="
								<ul>
									<li>use 8+ characters</li>
									<li>starts with a letter</li>
								 	<li>include at least one letter, one number, and one special character (such as ! . ? * or
								 	&)</li>
								</ul>">
							</i>
						</div>';
					echo '<div class="form-group row"> 
					    	<input type="password" name="newpasswordcheck" id="newpasswordcheck" placeholder="Retype Password">
						</div>';			
					echo '<div class="text-center"> 
					    	<button type="submit" name="submit" id="submit" class="btn btn-lg btn primary">Submit</button>
						</div>';
				} else {				
					echo '<div></div>';
				}
			?>
		</form>
	</div>
</section>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-3.4.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.4.1.js"></script>
<script>
	// enable tooltips and popovers
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
	
	// return true if first character is a letter
	function isLetter(str) {
		var first = str.charAt(0);
  		return first.match(/[A-Z|a-z]/i);
	}
	// Function to check whether password is valid. 
    function checkPassword(form) { 
		password1 = form.newpassword.value; 
		password2 = form.newpasswordcheck.value; 

		// If password doesn't match retype password 
		if (password1 != password2) { 
			alert ("\nPasswords did not match. Please try again."); 
			return false; 
		}
		
		var str = password1;
		// If password doesn't meet requirements
		if (!str.match(/[a-z]/g) && 
			!str.match(/[A-Z]/g) && 
			!str.match(/[0-9]/g) && 
			!str.match(/[^a-zA-Z\d]/g) &&
			!isLetter(str) &&
			!str.length >= 8) {			
			alert ("\nPassword is not strong enough.\nPlease check the tooltip for all requirements!")
			return false; 
		}
		return true;
	} 
	function accountCreated(form) {
		if (checkPassword(form)) {
			alert("Password has been successfully reset!");
		} else {
			return false;
		}		
	}
</script>
</body>
</html>
