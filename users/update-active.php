<?php
include("../include/config.php");
if(isset($_POST['isActive'], $_POST['userID'])) {
	$userID = mysqli_real_escape_string($db, $_POST["userID"]);
	$isActive = mysqli_real_escape_string($db, $_POST["isActive"]);
		
	$query = "UPDATE Users SET IsActive = '".$isActive."' WHERE UserID = '".$userID."'";
	if(mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 1;
	}
	
	echo $data;
}
?>