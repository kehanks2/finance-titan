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
	
<script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var tries_remaining = 3;
		
		$('#continue').click(function() {
			// after user clicks continue, send data to db and display results			
			$('#alert-message').html('');
			$('#continue').prop('disabled', true);
			// if username or email is missing, throw error message
			if ($('#username').val() == '' || $('#email').val() == '') {
				$('#alert-message').html('<div class="alert alert-warning">You must enter your username & email to continue.</div>');
				$('#continue').prop('disabled', false);
			} else {
				// otherwise, send data to server
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
			}				
		})
		
		function displaySecurity(...data) {
			// function called after user clicks continue.
			// errors:
			if (data == 1) {
				$('#alert-message').html('<div class="alert alert-warning">Username & Email combination not found. Try again.</div>');
				$('#continue').prop('disabled', false);
			} else if (data == -1) {
				$('#alert-message').html('<div class="alert alert-danger">There was an error submitting your request.</div>');
				$('#continue').prop('disabled', false);
			// success:
			} else {			
				// disable previous fields and hidden continue button
				$('#username').prop('disabled', true);
				$('#email').prop('disabled', true);
				$('#continue').prop('hidden', true);

				// display security question, answer box, and submit button
				var question = '<h5 id="question">'+data[0]+'</h5>';
				var answer = '<input type="password" class="form-control" id="security-response" placeholder="Enter your answer">';
				var sbtn = '<button type="button" id="security" class="btn btn-lg btn-primary">Submit</button>';
				$('#security-question').html(question);
				$('#security-answer').html(answer);
				$('#submit-btn').html(sbtn);
			}
		}
		
		$('#submit-btn').on('click', '#security', function(e) {
			// after user clicks submit, send data to server and receive response
			$('#alert-message').html('');
			$('#security').prop('disabled', true);
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
		
		// enable tooltips and popovers
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();
		
		function displayReset(data) {	
			// function called after user clicks submit
			// errors:
			if (data == 2) {
				if (tries_remaining == 0) {
					$('#alert-message').html('<div class="alert alert-danger"><strong>Your account has been locked.</strong> Contact a system administrator to unlock it.</div>');
				} else {
					tries_remaining--;
					$('#alert-message').html('<div class="alert alert-warning">Security answer incorrect. Remaining tries: '+tries_remaining+'</div>');
					$('#security').prop('disabled', false);	
				}								
			} else if (data == -1) {
				$('#alert-message').html('<div class="alert alert-danger">There was an error submitting your request.</div>');
			} else {				
				$('#question').prop('hidden', true);
				$('#security-response').prop('hidden', true);
				$('#security').prop('hidden', true);
				
				var username = data[0];
				var email = data[1];
				
				$('#input1').html('<label class="form-label" for="newpassword"><strong>Enter your new password:</strong></label></div><div class="row form-inline" style="margin-top:0px;"><div class="form-group"><input type="password" id="newpassword" class="my-auto form-control" placeholder="New Password"></div><div class="form-group"><i class="fa fa-question-circle-o" data-toggle="popover" title="Password Requirements" data-html="true" data-content="<ul><li>use 8+ characters</li><li>starts with a letter</li><li>include at least one letter, one number, and one special character (such as ! . ? * or &)</li></ul>"></i></div></div>');
				$('#input2').html('<label class="form label" for="newpasswordcheck"><strong>Retype your password:</strong></label></div><div class="row" style="margin-top:0px;"><div class="form-group"><input type="password" id="newpasswordcheck" class="form-control col-sm-4" placeholder="Retype Password"></div></div>');
				$('#btn1').html('<button type="button" id="changepw" class="btn btn-lg btn-primary">Submit</button>');
				
				var html = '<div id="username" hidden>'+username+'</div>';
				html += '<div id="email" hidden>'+email+'</div>';
				$('#forgot-password-form').append(html);
			}	
		}
		
		$('#btn1').on('click', '#changepw', function(e) {			
			$('#alert-message').html('');
			$('#changepw').prop('disabled', true);
			var username = $('#username').text();
			var email = $('#email').text();			
			var pw1 = $('#newpassword').val();
			var pw2 = $('#newpasswordcheck').val();
			
			if (checkPassword(pw1, pw2)) {
				var password = pw1;
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
			}				
		})
		
		function isSuccess(data) {
			if (data == 0) {
				$('#alert-message').html('<div class="alert alert-success">Successfully changed pw</div>');
			} else if (data == 1) {
				$('#alert-message').html('<div class="alert alert-danger">Something went wrong.</div>');
				$('#changepw').prop('disabled', false);
			} else if (data == 2) {
				$('#alert-message').html('<div class="alert alert-warning">Password must not have been used previously.</div>');
				$('#changepw').prop('disabled', false);
			} else {
				$('#alert-message').html('<div class="alert alert-warning">Passwords must match. Check the requirements and try again.</div>');
				$('#changepw').prop('disabled', false);
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
				$('#alert-message').html('<div class="alert alert-warning">Passwords must match. Check the requirements and try again.</div>'); 
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
				$('#alert-message').html('<div class="alert alert-warning">Password is not strong enough.\nPlease check the tooltip for all requirements!</div>');
				return false; 
			}
			return true;
		} 
		
	})
	
</script>
</body>
</html>
