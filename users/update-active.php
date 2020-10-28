<?php
include("../include/config.php");
if(isset($_POST['isActive'], $_POST['userID'])) {
	$userID = mysqli_real_escape_string($db, $_POST["userID"]);
	$isActive = mysqli_real_escape_string($db, $_POST["isActive"]);	
	
	$query = "UPDATE Users SET IsActive = '$isActive'";
	
	if ($isActive == 1) {
		$query .= ", ExpiryStart = NULL, ExpiryEnd = NULL";		
	} else {
		if ($_POST['startDate'] != 0 && $_POST['endDate'] != 0) {
			$start = mysqli_real_escape_string($db, $_POST['startDate']);	
			$end = mysqli_real_escape_string($db, $_POST['endDate']);

			$query .= ", ExpiryStart = '$start', ExpiryEnd = '$end'";
				
		} else {
			$start = date('Y-m-d');
			$query .= ", ExpiryStart = '$start', ExpiryEnd = NULL";
		}
	}
		
	$query .= " WHERE UserID = '$userID'";
		
	if(mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 1;
	}
	
	echo $data;
}
?>