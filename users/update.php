<?php
include("../include/config.php");
if(isset($_POST["firstname"], $_POST["lastname"], $_POST['dob'], $_POST["email"])) {
	$firstname = mysqli_real_escape_string($db, $_POST["firstname"]);
 	$lastname = mysqli_real_escape_string($db, $_POST["lastname"]);	
	$dob = mysqli_real_escape_string($db, $_POST["dob"]);
	$date = strtotime($dob);
	$date = date('Y-m-d', $date);
 	$email = mysqli_real_escape_string($db, $_POST["email"]);
 	$query = "UPDATE Users SET FirstName = '".$firstname."', LastName = '".$lastname."', BirthDate = '".$date."', EmailAddress = '".$email."' WHERE UserID = '".$_POST["id"]."'";
 	
	if(mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 3;
	}
	
	echo $data;
}
?>