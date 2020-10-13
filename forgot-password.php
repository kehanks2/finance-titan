 <?php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);

	session_start();
	include("include/config.php");
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
		    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
	</head>
	
<body>
<!-- NAVIGATION -->
<?php include("include/navbar.php"); ?>

<!-- BANNER -->
<?php include("include/banner.php"); ?>

<!-- PAGE CONTENT -->
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-md-6 sign-in-form">
			<div class="form-group" id="forgot-password-form">
				<div class="text-center">
					<h2>Reset Your Password</h2>
					<p>Enter the information below to reset your password.</p>
				</div>
				<div id="alert-message"></div>
				<div class="form-group" id="input1">
					<input type="text" class="form-control" id="username" placeholder="Username">
				</div>
				<div class="form-group" id="input2">
					<input type="email" class="form-control" id="email" placeholder="Email">
				</div>
				<div class="text-center" id="btn1">
					<button type="button" id="continue" name="continue" class="btn btn-lg btn-primary ">Continue</button>
				</div>
				<div class="form-group" id="security-question"></div>
				<div class="form-group" id="security-answer"></div>
				<div class="text-center" id="submit-btn"></div>
			</div>
		</div>
	</div>
</div>
	
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script>
	<script src="js/bootstrap-4.4.1.js"></script>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
	// enable tooltips and popovers
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
	
</script>
<script type="text/javascript">
	$(document).ready(function() {
		
		$('#continue').click(function() {
			var username = $('#username').val();
			var email = $('#email').val();
			$.ajax({
				method: 'POST',
				url: 'include/get-security.php',
				dataType: 'JSON',
				data: {
					username: username,
					email: email
				},
				success: function(data) {
					displaySecurity(data);
				}
			});
		})
		
		function displaySecurity(...data) {
			if (data == 1) {
				$('#alert-message').html('<div class="alert alert-danger">Error 1</div>');
			} else if (data == -1) {
				$('#alert-message').html('<div class="alert alert-danger">-1</div>');
			} else {			
				$('#username').prop('disabled', true);
				$('#email').prop('disabled', true);
				$('#continue').prop('hidden', true);

				var question = '<h4 id="question">'+data[0]+'</h4>';
				var answer = '<input type="password" class="form-control" id="security-response" placeholder="Security Answer">';
				var sbtn = '<button type="button" id="security" class="btn btn-lg btn-primary">Submit</button>';
				$('#security-question').html(question);
				$('#security-answer').html(answer);
				$('#submit-btn').html(sbtn);
			}
		}
		
		$('#submit-btn').on('click', '#security', function(e) {
			var username = $('#username').val();
			var email = $('#email').val();
			var answer = $('#security-response').val();
			$.ajax({
				method: 'POST',
				url: 'include/get-security.php',
				dataType: 'JSON',
				data: {
					username: username,
					email: email,
					answer: answer
				},
				success: function(data) {
					displayReset(data);
				}
			});
		})
		
		function displayReset(data) {			
			if (data[0] == 2) {
				$('#alert-message').html('<div class="alert alert-danger">Security answer incorrect.</div>');
			} else if (data[0] == -1) {
				$('#alert-message').html('<div class="alert alert-danger">-1</div>');
			} else {	
				$('#alert-message').html('<div class="alert alert-success">Success. Please enter your new password below.</div>');
				
				$('#question').prop('hidden', true);
				$('#security-response').prop('hidden', true);
				$('#security').prop('hidden', true);
				
				var username = data[0];
				var email = data[1];
				
				$('#input1').html('<input type="password" id="newpassword" class="form-control" placeholder="Enter New Password"></div>');
				$('#input2').html('<input type="password" id="newpasswordcheck" class="form-control" placeholder="Retype Password"></div>');
				$('#btn1').html('<button type="button" id="changepw" class="btn btn-lg btn-primary">Submit</button>');
				
				var html = '<div id="username" hidden>'+username+'</div>';
				html += '<div id="email" hidden>'+email+'</div>';
				$('#forgot-password-form').append(html);
			}	
		}
		
		$('#btn1').on('click', '#changepw', function(e) {
			var username = $('#username').text();
			var email = $('#email').text();
			
			var password = $('#newpassword').val();
			var passwordcheck = $('#newpasswordcheck').val();
			$.ajax({
				method: 'POST',
				url: 'include/get-security.php',
				dataType: 'JSON',
				data: {
					username: username,
					email: email,
					password: password
				},
				success: function(data) {
					isSuccess(data);
					
				}
			})
		})
		
		function isSuccess(data) {
			if (data == 0) {
				$('#alert-message').html('<div class="alert alert-success">Successfully changed pw</div>');
			} else if (data == 1) {
				$('#alert-message').html('<div class="alert alert-danger">Something went wrong.</div>');
			} else if (data == 2) {
				$('#alert-message').html('<div class="alert alert-danger">Password must not have been used previously.</div>');
			} else {
				$('#alert-message').html('<div class="alert alert-warning">Passwords must match. Check the requirements and try again.</div>');
			}
		}
		
		// return true if first character is a letter
		function isLetter(str) {
			var first = str.charAt(0);
			return first.match(/[A-Z|a-z]/i);
		}
		// Function to check whether password is valid. 
		function checkPassword(password1, password2) {

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
		
	})
	
</script>
</body>
</html>
