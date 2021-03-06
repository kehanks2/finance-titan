 <?php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);

	//session_start();
	include("include/session.php");
   
if(isset($_POST["submit"])) {
      
      $sid = $login_session;
      $rid = mysqli_real_escape_string($db,$_POST['rid']);
      $subject = mysqli_real_escape_string($db,$_POST['subject']);
      $message = sprintf(mysqli_real_escape_string($db,$_POST['message']));
	   
	  //$time = time();
	   //Insert Data into Messages Table
	  $sqlMessagesInsert = "INSERT INTO Messages 
        (SenderID,
        RecipientID, 
        Sender, 
        Recipient, 
        Subject, 
        Message)
        VALUES (
            (SELECT UserID FROM Users WHERE '$sid' = UserName), 
            (SELECT UserID FROM Users WHERE '$rid' = UserName),
            '$sid',
            '$rid', 
            '$subject', 
            '$message')";

        if(mysqli_query($db, $sqlMessagesInsert)) {
  				$data = 1;
 		} else {
				$data = 2;
		}
	    echo $data;  
   }
?>



<!DOCTYPE html>
<html lang="en">
<!-- HEADER -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Send Message</title>

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

<!-- PAGE CONTENT -->
<section class="container-fluid">
	<div class="row">
		<div class="col-sm-12" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
	</div>
	<div class="d-flex justify-content-center">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<h2>Messaging System</h2>
				</div>
				<div class="col-sm-9">
					<h2>New Message</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3" style="padding-right:5px; border-right: 1px solid #ccc;">
					<h5>New Message</h5>
					<a class="nav-link" href="inbox.php"><h5>Inbox</h5></a>
					<h5>Sent</h5>
				</div>
				<div class="col-sm-9">
					<form id="send-message-form" method="post" onSubmit="messsageSent(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					Date:  <?php echo date("Y/m/d")?>
					<input type="text" class="form-control" name="rid" id="rid" placeholder="Enter Recipient ID" required="required">
					<input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject" required="required">
					<textarea type="text" class="form-control" name="message" id="message" rows="3"></textarea>
					<input type="submit" id="submit" class="btn btn-sm btn-primary" name="submit" data-toggle="tooltip" data-placement="bottom" title="Click to send message" value="Send Message">
				</div>
			</div>
		</div>
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
	function messageSent(form) {
		alert("\nSuccess!\nYour message has been sent.");
		
	}
</script>
</body>
	
	<footer>
	
	</footer>
</html>
