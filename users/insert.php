<?php
include("../include/config.php");
if(isset($_POST["username"], $_POST["firstname"], $_POST["lastname"], $_POST["dob"], $_POST["email"], $_POST["usertype"])) {
 	$username = mysqli_real_escape_string($db, $_POST["username"]);
	$firstname = mysqli_real_escape_string($db, $_POST["firstname"]);
 	$lastname = mysqli_real_escape_string($db, $_POST["lastname"]);	
	$date = mysqli_real_escape_string($db, $_POST['dob']);
 	$email = mysqli_real_escape_string($db, $_POST["email"]);
 	$usertype = mysqli_real_escape_string($db, $_POST["usertype"]);
 	$query = "INSERT INTO Users(LastName, FirstName, BirthDate, UserName, EmailAddress, UserType, IsActive) VALUES('$lastname', '$firstname', '$date' , '$username', '$email', '$usertype', 0)";
 	if(mysqli_query($db, $query)) {
  				$data = 1;
 			} else {
				$data = 2;
			}
	echo $data;
}
?>
