<?php
include("../include/config.php");
if(isset($_POST['isActive'], $_POST['userID'])) {
	$userID = mysqli_real_escape_string($db, $_POST["userID"]);
	$isActive = mysqli_real_escape_string($db, $_POST["isActive"]);	
	if ($isActive == 1) {
		$expDate = date("Y-m-d", strtotime("+60 days"));
		$queryPW = "Update Passwords SET ExpiryDate = '$expDate', ExpiryEnd = NULL WHERE Passwords.PasswordID = (SELECT PasswordID FROM Users WHERE UserID = '$userID')";
		
		if (mysqli_query($db, $queryPW)) {
			$data = 0;
		} else {
			$data = 1;
		}
	}
	
	$query = "UPDATE Users SET IsActive = '".$isActive."' WHERE UserID = '".$userID."'";
	
	if ($_POST['startDate'] != 0 && $_POST['endDate'] != 0) {
		$start = mysqli_real_escape_string($db, $_POST['startDate']);	
		$end = mysqli_real_escape_string($db, $_POST['endDate']);
		
		$queryDate = "UPDATE Passwords SET ExpiryDate = '$start', ExpiryEnd = '$end' WHERE Passwords.PasswordID = (SELECT PasswordID FROM Users WHERE UserID = '$userID')";
		
		if(mysqli_query($db, $queryDate)) {
			$data = 0;
		} else {
			$data = 1;
		}
		
	}
		
	if(mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 1;
	}
	
	echo $data;
}
?>