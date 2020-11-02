<?php
include('../include/config.php');
if (isset($_POST['selected'], $_POST['id'], $_POST['name'])) {
	$name = mysqli_real_escape_string($db, $_POST['name']);
	$selected = mysqli_real_escape_string($db, $_POST['selected']);
	$id = mysqli_real_escape_string($db, $_POST['id']);
	
	$query = "UPDATE Accounts SET ".$name." = '$selected' WHERE AccountNumber = '$id'";
	
	if(mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 3;
	}
	
	echo $data;
}
?>