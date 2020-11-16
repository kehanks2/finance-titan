<?php
	include("../include/config.php");

	$query = 'SELECT * From Accounts';

	$result = mysqli_query($db, $query);

	$data = array();
	
	// loop through each row in query result and display in the table
	while($row = mysqli_fetch_array($result)) {
 		$sub_array = array();
 		
		$sub_array = '<p>Account Name: '.$row['AccountName'].'</p>';
		
 		$data[] = $sub_array;
	}

	$output = array('Balance Sheet', $data);

	echo json_encode($output);

?>