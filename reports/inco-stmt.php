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
			$data[] = "<div class='row report' style='margin-bottom:10px margin-top: 20px;'><div class='col-sm-5'><strong>Total Revenues</strong></div><div class='col-sm-4'></div><div class='col-sm-2' style='text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000'>$ ".number_format($totalrev, 2)."</div>";
			$data[] = "<div class='row report'><div class='col-sm-5'><em>Expenses</em></div></div>";
		}

		if ($category == 'Revenue') {		
			$sub_array = "<div class='row report'><div class='col-sm-5' style='padding-left:15px;'>".$row['AccountName']."</div><div class='col-sm-3'></div><div class='col-sm-3' style='text-align: right;'>".number_format($curr, 2)."</div>";
			
			$totalrev += (double) $curr;
		} else {
			$sub_array = "<div class='row report'><div class='col-sm-5' style='padding-left:15px;'>".$row['AccountName']."</div><div class='col-sm-3' style='text-align: right;'>".number_format($curr, 2)."</div><div class='col-sm-3'></div>";
			
			$totalexp += (double) $curr;
		}
		
 		$data[] = $sub_array;
	}

	$totalexpa = number_format($totalexp, 2);

	$data[] = "<div class='row report' style='margin-bottom:10px margin-top: 20px;'><div class='col-sm-5'><strong>Total Expenses</strong></div><div class='col-sm-4'></div><div class='col-sm-2' style='text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000'>$ ".$totalexpa."</div>";

	$total = $totalrev - $totalexp;
	$total = number_format($total, 2);

	$data[] = "<div class='row report' style='margin-bottom:10px margin-top: 20px;'><div class='col-sm-5'><strong>Net Income</strong></div><div class='col-sm-4'></div><div class='col-sm-2' style='text-align: right; border-top: 1px solid #000; border-bottom: 3px double #000'>$ ".$total."</div>";

	$output = array('Income Statement', $data);

	echo json_encode($output);

?>