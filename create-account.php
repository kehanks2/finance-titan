 <?php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);

	session_start();
	include("include/config.php");

   if(isset($_POST["submit"])) {
      // values sent from form 
      
      $fname = mysqli_real_escape_string($db,$_POST['fname']);
      $lname = mysqli_real_escape_string($db,$_POST['lname']);
      $email = mysqli_real_escape_string($db,$_POST['email']);
      $dob = mysqli_real_escape_string($db,$_POST['dob']);
      $password = mysqli_real_escape_string($db,$_POST['password']); 
      $squestion = mysqli_real_escape_string($db,$_POST['security-question']);	   
      $sanswer = mysqli_real_escape_string($db,$_POST['security-answer']); 
      $creationyear = date("Y");
      //Hashing the password
      //$password = password_hash($password,PASSWORD_DEFAULT);
      //Creating a username 
      $username = $fname[0] . $lname . date("m") . $creationyear[2] . $creationyear[3];
	  
	   //Email activation code 
	  $emailcode = md5(uniqid(mt_rand(), true )); 
	   
      $sqlPasswordInsert = "INSERT INTO Passwords (CurrentPassword, SecurityQuestion, SecurityAnswer) VALUES ('$password', '$squestion', '$sanswer')";
	   
      $sqlUserInsert = "INSERT INTO Users (UserName,  FirstName, LastName, EmailAddress, BirthDate, PasswordID, EmailCode) VALUES ('$username', '$fname', '$lname', '$email', '$dob', '$emailcode',
      (SELECT PasswordID FROM Passwords WHERE '$password' = CurrentPassword and '$sanswer' = SecurityAnswer))";
	   
	   if(mysqli_query($db, $sqlPasswordInsert)) {
		  if(mysqli_query($db, $sqlUserInsert)) {
		   	header("Location: login.php");
		  }
	   } else {
		   	echo alert("There was an error connecting to the server.");
		   	header("Location: login.php");
	   }
   } 
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
	    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
</head>
	
<body>
<!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

<!-- BANNER -->
<?php include('include/banner.php'); ?>

<!-- PAGE CONTENT -->
<section class="container-fluid">
	<div class="row">
		<div class="col-sm-12" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
	</div>
	<div class="d-flex justify-content-center">
		<form id="create-account-form" class="col-md-6 sign-in-form" method="post" onSubmit="accountCreated(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div>
				<h2>Create your account</h2>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter first Name" required="required">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter last Name" required="required">
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" required="required">
			</div>
			<div class="form-group">
				<label for="dob" class="form-text">Enter Date of Birth:</label>
				<input type="date" class="form-control" name="dob" id="dob" placeholder="mm/dd/yyyy" required="required">
			</div>
			<div class="row">
				<div class="form-group col-6">
					<input type="password" style="width:105%;" class="form-control" id="password" name="password" placeholder="Enter password" required="required">
				</div>
				<div class="col-1 help-icon">
					<i class="fa fa-question-circle-o" data-toggle="popover" title="Password Requirements" data-html="true"
					   data-content="<ul>
									 <li>use 8+ characters</li>
									 <li>starts with a letter</li>
									 <li>include at least one letter, one number, and one special character (such as ! . ? * or
										&)</li></ul>">
					</i>
				</div>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="pasword-check" name="passwordcheck" placeholder="Retype password" required="required">
			</div>
			<div class="form-group">
				<select name="security-question" id="security-question" class="form-control" required="required">
					<option hidden disabled selected value>Select a security question</option>
					<option value="mother-maiden">What is your mother's maiden name?</option>
					<option value="father-middle">What is your father's middle name?</option>
					<option value="first-pet">What is the name of your first pet?</option>
					<option value="first-car">What was your first car?</option>
					<option value="birth-city">What is the city you were born in?</option>
				</select>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="security-answer" id="security-answer" placeholder="Enter security answer" required="required">
			</div>
			<div class="text-center">
				<input type="submit" id="submit" class="btn btn-lg btn-primary" name="submit" data-toggle="tooltip" data-placement="bottom" title="Click to create your account" value="Create Account">
			</div>
		</form>
	</div>
</section>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
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
			alert("\nSuccess!\nYour acount has been created.\nYou will receive an email when the administrator approves your account!");
		}
		
	}
</script>
</body>
	
	<footer>
	
	</footer>
</html>
