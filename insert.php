<?php
include("config.php");
if(isset($_POST["username"], $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["usertype"])) {
 	$username = mysqli_real_escape_string($db, $_POST["username"]);
	$firstname = mysqli_real_escape_string($db, $_POST["firstname"]);
 	$lastname = mysqli_real_escape_string($db, $_POST["lastname"]);	
 	$email = mysqli_real_escape_string($db, $_POST["email"]);
 	$usertype = mysqli_real_escape_string($db, $_POST["usertype"]);
 	$query = "INSERT INTO Users(LastName, FirstName, UserName, EmailAddress, UserType) VALUES('$lastname', '$firstname', '$username', '$email', '$usertype')";
 	if(mysqli_query($db, $query)) {
  		echo 'Data Inserted';
 	}
}
?>