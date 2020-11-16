<?php
include('config.php');
if (isset($_POST['accountName'])) {
	$accountName = mysqli_real_escape_string($db, $_POST['accountName']);
	
	$query = "SELECT AccountEvents.EventID, Accounts.* FROM AccountEvents, Accounts WHERE AccountEvents.AccountAffected = '$accountName' AND Accounts.AccountName = '$accountName' ORDER BY DateAdded ASC LIMIT 1";
	
	$result = mysqli_query($db, $query);
	$count = mysqli_num_rows($result);
	
	$data = array();
	while ($row = mysqli_fetch_array($result)) {		
		$data[0] = $row['DateAdded'];
		$data[1] = $row['CreatorID'];
		$data[2] = $row['EventID'];
		$data[3] = $row['InitialBalance'];
		$data[4] = $row['Category'];
		$data[5] = $row['SubCategory'];
	}
	
	if (mysqli_num_rows($result) != 1) {
		echo json_encode($count);
	} else {
		echo json_encode($data);		
	}
}


?>