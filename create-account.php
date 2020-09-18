 <?php
	/* will finish after work
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // values sent from form 
      
      $myfirstname = mysqli_real_escape_string($db,$_POST['fname']);
      $mylastname = mysqli_real_escape_string($db,$_POST['lname']);
      $myemail = mysqli_real_escape_string($db,$_POST['email']);
      $mydateofbirth = mysqli_real_escape_string($db,$_POST['dob']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      $mysqquestion = mysqli_real_escape_string($db,$_POST['security-question']);	   
      $mysqanswer = mysqli_real_escape_string($db,$_POST['security-answer']); 
      $creationyear = date("Y");
     //Creating a username
      $username = $myfirstname[0] . $mylastname . date("m") . $creationyear[2] . $creationyear[3];    
      $sqlPasswordInsert = "INSERT INTO Passwords (CurrentPassword, SecurityQuestion, SecurityAnswer) VALUES ('$mypassword', '$mysqqueston', '$mysqanswer')";
      $sqlUserInsert = "INSERT INTO Users (UserName,  FirstName, LastName, EmailAddress, BirthDate) VALUES ('$username', '$myfirstname', '$mylastname', '$myemail', '$mydateofbirth')";
      $resultPassword = mysqli_query($db,$sqlPasswordInsert);
      $resultUser = mysqli_query($db,$sqlUserInsert)
  }
	*/   
?>



<!DOCTYPE html>
<html lang="en">
<!-- HEADER -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Finance Titan - Create Account</title>

	<!-- Stylesheets -->
	<link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
	
<body>
<!-- NAVIGATION -->
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
				<a class="nav-link disabled" href="#">Messages</a>
			</li>			
		</ul>
		<ul class="navbar-nav d-flex justify-content-end">	
			<li>
				<a class="nav-link" id="logout" href="login.php">Log In</a>
			</li>
		</ul>
	</div>
</nav>

<!-- BANNER -->
<section id="banner" class="text-center logo-background"> <img src="images/logo.jpeg" alt="Finance Titan Logo" max-width="225px" height="200px" class="logo"/>
	<p class="lead">Seize Control of Your Finances</p>
</section>

<!-- PAGE CONTENT -->
<section id="create-account-form" class="d-flex justify-content-center">
	<form class="col-md-6 sign-in-form" method="post" onSubmit="accountCreated(this)" action="index.php">
		<div>
			<h2>Create your account</h2>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="fname" placeholder="First Name" required="required">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="lname" placeholder="Last Name" required="required">
		</div>
		<div class="form-group">
			<input type="email" class="form-control" id="email" placeholder="Enter Email" required="required">
		</div>
		<div class="form-group">
			<label for="dob" class="form-text">Enter Date of Birth:</label>
			<input type="date" class="form-control" id="dob" placeholder="mm/dd/yyyy" required="required">
		</div>
		<div class="row">
			<div class="form-group col-6">
				<input type="password" style="width:105%;"class="form-control" id="password" name="password" placeholder="Password" required="required">
			</div>
			<div class="col-1 help-icon">
				<i class="fa fa-question-circle-o" data-toggle="popover" title="Password Requirements" data-html="true"
				   data-content="<ul>
								 <li>use 8+ characters</li>
								 <li>starts with a letter</li>
								 <li>include at least one letter, one number, and one special character(such as ! . ? * or
								 	&)</li></ul>">
				</i>
			</div>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" id="pasword-check" name="passwordcheck" placeholder="Retype Password" required="required">
		</div>
		<div class="form-group">
			<select name="security-question" class="form-control" required="required">
				<option hidden disabled selected value>Select a security question</option>
				<option value="mother-maiden">What is your mother's maiden name?</option>
				<option value="father-middle">What is your father's middle name?</option>
				<option value="first-pet">What is the name of your first pet?</option>
				<option value="first-car">What was your first car?</option>
				<option value="birth-city">What is the city you were born in?</option>
			</select>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" id="security-answer" placeholder="Security Answer" required="required">
		</div>
		<div class="text-center">
			<button type="submit" class="btn btn-lg">Create Account</button>
		</div>
	</form>
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
		password1 = form.password.value; 
		password2 = form.passwordcheck.value; 

		// If password doesn't match retype password 
		if (password1 != password2) { 
			alert ("\nPasswords did not match. Please try again.") 
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
			alert("\nSuccess!\nYour acount has been created.\nYou will receive an email when the administrator approves your account!");
		}
	}
</script>
</body>
	
	<footer>
	
	</footer>
</html>
