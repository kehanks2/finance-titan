<?php
include("../include/config.php");
if(isset($_POST["username"], $_POST["firstname"], $_POST["lastname"], $_POST['dob'], $_POST["email"], $_POST["usertype"])) {
 	$username = mysqli_real_escape_string($db, $_POST["username"]);
	$firstname = mysqli_real_escape_string($db, $_POST["firstname"]);
 	$lastname = mysqli_real_escape_string($db, $_POST["lastname"]);	
	$dob = mysqli_real_escape_string($db, $_POST["dob"]);
	$date = strtotime($dob);
	$date = date('Y-m-d', $date);
 	$email = mysqli_real_escape_string($db, $_POST["email"]);
 	$usertype = mysqli_real_escape_string($db, $_POST["usertype"]);
 	$query = "UPDATE Users SET UserName='".$username."', FirstName = '".$firstname."', LastName = '".$lastname."', BirthDate = '".$date."', EmailAddress = '".$email."', UserType = '".$usertype."' WHERE UserID = '".$_POST["id"]."'";
 	if(mysqli_query($db, $query)) {
  		echo 'Data Updated';
 	}
}
?>