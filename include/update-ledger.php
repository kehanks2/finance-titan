<?php
include('session.php');
if (isset($_POST['desc'], $_POST['cat'], $_POST['subcat'], $_POST['stmt'], $_POST['order'], $_POST['id'])) {
	$desc = mysqli_real_escape_string($db, $_POST['desc']);
	$cat = mysqli_real_escape_string($db, $_POST['cat']);
	$subcat = mysqli_real_escape_string($db, $_POST['subcat']);
	$stmt = mysqli_real_escape_string($db, $_POST['stmt']);
	$order = mysqli_real_escape_string($db, $_POST['order']);
	$id = mysqli_real_escape_string($db, $_POST['id']);
	
	$query = "UPDATE Accounts SET Description = '".$desc."', Category = '".$cat."', SubCategory = '".$subcat."', AccountStatement = '".$stmt."', AccountOrder = '".$order."' WHERE AccountNumber = '".$id."'";
	
	if (mysqli_query($db, $query)) {
		echo 1;
	} else {
		echo 0;
	}
}

?>