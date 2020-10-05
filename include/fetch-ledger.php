<?php
include("session.php");
if(isset($_POST['accountName'])) {
	$accountName = mysqli_real_escape_string($db, $_SESSION['accountName']);
	
	$query = "SELECT * FROM Accounts WHERE AccountName = '".$accountName."'";
	$result = mysqli_query($db, $query);
	
	$data = array();	
	while ($row = mysqli_fetch_array($result)) {
		$data[0] = $row['AccountNumber'];
		$data[1] = $row['AccountName'];
		$data[2] = $row['Description'];
		$data[3] = $row['Category'];
		$data[4] = $row['SubCategory'];
		
		$data[5] = $row['InitialBalance'];
		$data[6] = $row['Debit'];
		$data[7] = $row['Credit'];
		$data[8] = $row['CurrentBalance'];
		$data[9] = $row['NormalSide'];
		
		$data[10] = $row['DateAdded'];
		$data[11] = $row['CreatorID'];
		$data[12] = $row['AccountStatement'];
		$data[13] = $row['AccountOrder'];
		if ($row['IsActive'] == 0) {
			$data[14] = "No";
		} else if ($row['IsActive'] == 1) {
			$data[14] = "Yes";
		}
		
		for ($i = 0; $i < count($data); $i++) {
			if (is_null($data[$i]))
			{
				$data[$i] = "-";
			}
		}
	}		
	
	
	if (mysqli_num_rows($result) != 1) {
		echo json_encode($count);
	} else {
		echo json_encode($data);		
	}
	
}


?>