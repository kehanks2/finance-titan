<?php
	include("../include/config.php");

	$query = 'SELECT * From Accounts WHERE CurrentBalance != 0 AND (Category = "Expense" OR Category = "Revenue") ORDER BY Category DESC';

	$result = mysqli_query($db, $query);

	$data = array();
	$data[] = "<h3>Date: " . date('Y-m-d'). "</h4>";
	$data[] = "<div class='row report'><div class='col-sm-5'><em>Revenues</em></div></div>";
	$category = 'Revenue';

	$totalexp = (double) 0.00;
	$totalrev = (double) 0.00;

	// loop through each row in query result and display in the table
	while($row = mysqli_fetch_array($result)) {
		$sub_array = array();
		$curr = $row['CurrentBalance'];
		
		if ($row['Category'] != $category) {
			$category = 'Expense';
			$data[] = "<div class='row report'><div class='col-sm-5'><em>Expenses</em></div></div>";
		}

		if ($category == 'Revenue') {		
			$sub_array = "<div class='row report'><div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div><div class='col-sm-3'></div><div class='col-sm-3' style='text-align: right;'>".$row['CurrentBalance']."</div>";
			
			$totalrev += (double) $curr;
		} else {
			$sub_array = "<div class='row report'><div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div><div class='col-sm-3' style='text-align: right;'>".$row['CurrentBalance']."</div><div class='col-sm-3'></div>";
			
			$totalexp += (double) $curr;
		}
		
 		$data[] = $sub_array;
	}

	$data[] = "<div class='row report'><div class='col-sm-5' style='text-align: right;'><strong>Total Expenses</strong></div><div class='col-sm-3'></div><div class='col-sm-3' style='text-align: right;'>".$totalexp."</div>";

	$total = (double) ($totalrev - $totalexp);

	$data[] = "<div class='row report' style='margin-bottom:10px;'><div class='col-sm-5'><strong>Net Income</strong></div><div class='col-sm-3'></div><div class='col-sm-3' style='text-align: right;'>".$total."</div>";

	$output = array('Income Statement', $data);

	echo json_encode($output);

?>