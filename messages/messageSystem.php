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

<html>
	<head></head>
	<body>
		<h1>Send Message:</h1>
		<form action='messageSystem.php' method='POST'>
		<table>
			<tbody>
				<tr>
					<td>To: </td><td><input type='text' name='to' /></td>
				</tr>
				<tr>
					<td>From: </td><td><input type='text' name='from' /></td>
				</tr>
				<tr>
					<td>Message: </td><td><input type='text' name='message' /></td>
				</tr>
				<tr>
					<td></td><td><input type='submit' value='Send' name='sendMessage' /></td>
				</tr>
			</tbody>
		</table>
		</form>
	</body>
</html>
	
	<?php
	$con = mysqli_connect('localhost', 'root', '', 'messagesTutorial') or die(mysql_error());
	if (isSet($_POST['sendMessage'])) {
		if (isSet($_POST['to']) && $_POST['to'] != '' && isSet($_POST['from']) && $_POST['from'] != '' && isSet($_POST['message']) && $_POST['message'] != '') {
			$to = $_POST['to'];
			$from = $_POST['username'];
			$message = $_POST['message'];
			$q = mysqli_query($con, "INSERT INTO `messages` VALUES ('', '$message', '$to', '$from')") or die(mysql_error());
			if ($q) {
				echo 'Message sent.';
			}else
				echo 'Failed to send message.';
		}
	}
?>
	
<h1>My Messages:</h1>
<table>
	<tbody>
		<?php
			$user = 'myUsername'; //$user = $_SESSION['username'];
			$qu = mysqli_query($con, "SELECT * FROM `messages` WHERE `to`='$user'");
			if (mysqli_num_rows($qu) > 0) {
				while ($row = mysqli_fetch_array($qu)) {
					echo '<tr><td>'.$row["from"].'</td><td>'.$row["message"].'</td></tr>';
				}
			}
		?>
	</tbody>
</table>

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
</script>
</body>
	
	<footer>
	
	</footer>
</html>