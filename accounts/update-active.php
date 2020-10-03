<?php
include("../include/config.php");
if(isset($_POST['isActive'], $_POST['accountID'])) {
	$accountID = mysqli_real_escape_string($db, $_POST["accountID"]);
	$isActive = mysqli_real_escape_string($db, $_POST["isActive"]);
		
	$query = "UPDATE Accounts SET isActive = '".$isActive."' WHERE AccountNumber = '".$accountID."'";
	if(mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 3;
	}
	
	echo $data;
}
?>