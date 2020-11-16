<?php
	include("../include/config.php");

	$query = 'SELECT * From Accounts WHERE CurrentBalance != 0 AND (Category = "Expense" OR Category = "Revenue") ORDER BY Category DESC';

	$result = mysqli_query($db, $query);

	$data = array();
	$data[] = "<h3>Date: " . date('Y-m-d'). "</h4>";
	$category = 'Revenue';

	$totalexp = (double) 0.00;
	$totalrev = (double) 0.00;

	// loop through each row in query result and display in the table
	while($row = mysqli_fetch_array($result)) {
		$curr = $row['CurrentBalance'];
		$re = '';
		if ($row['AccountName'] == 'Retained Earnings') {
			$re = $row['CurrentBalance'];
		}
		
		if ($row['Category'] != $category) {
			$category = 'Expense';
		}
		
		if ($category == 'Revenue') {
			$totalrev += (double) $curr;
		} else {
			$totalexp += (double) $curr;
		}		
	}

	$total = (double) ($totalrev - $totalexp);

	$data[] = "<div class='row report'><div class='col-sm-5'><strong>Beg Retained Earnings</strong></div><div class='col-sm-3' style='text-align: right;'>".$re."</div>";

	$data[] = "<div class='row report'><div class='col-sm-5'>Add: Net Income</div><div class='col-sm-3' style='text-align: right;'>".$total."</div>";

	$data[] = "<div class='row report'><div class='col-sm-5'>Less: Dividends</div><div class='col-sm-3' style='text-align: right;'>0</div>";

	$data[] = "<div class='row report' style='margin-bottom:10px;'><div class='col-sm-5'><strong>End Retained Earnings</strong></div><div class='col-sm-3' style='text-align: right;'>".$total."</div>";

//	$input_query = 'Insert INTO Accounts
//						(AccountName, CurrentBalance)'

	$output = array('Retained Earnings', $data);

	echo json_encode($output);

?>