<?php
	include("../include/config.php");

	$query = '
		SELECT * From Accounts 
			WHERE (CurrentBalance != 0 OR AccountName = "Retained Earnings") AND 
				(Category = "Asset" OR Category = "Liability" OR Category = "Equity") 
			ORDER BY 
				CASE Category 
					WHEN "Asset" THEN 1 
					WHEN "Liability" THEN 2
					WHEN "Equity" THEN 3
					ELSE 4 
				END, AccountNumber';

	$result = mysqli_query($db, $query);

	$data = array();
	$data[] = "<h3>Date: " . date('Y-m-d'). "</h3>";

	$totala = 0;
	$totall = 0;
	$totale = 0;
	
	$asset = true;
	$liability = false;
	$equity = false;
	// loop through each row in query result and display in the table
	while($row = mysqli_fetch_array($result)) {
		$sub_array = '';
		$curr = $row['CurrentBalance'];
		if ($row['Category'] == "Asset") {
			if ($row['NormalSide'] == 'left') {
				$totala += $row['CurrentBalance'];				
			} else {				
				$totala -= $row['CurrentBalance'];
			}
			if ($asset) {				
				$sub_array = "<div class='row report'><div class='col-sm-5'><em>Assets</em></div></div>";
				$asset = false;
			}
			if ($totala == $curr) {
				$sub_array .= "
					<div class='row report'>
						<div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div>
						<div class='col-sm-3' style='text-align: right;'>$ ".number_format($curr, 2)."</div>
						<div class='col-sm-3'></div>
					</div>";
			} else {
				$sub_array .= "
					<div class='row report'>
						<div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div>
						<div class='col-sm-3' style='text-align: right;'>".number_format($curr, 2)."</div>
						<div class='col-sm-3'></div>
					</div>";
			}				
		} else if ($row['Category'] == "Liability") {
			$totall += $row['CurrentBalance'];
			if (!$liability) {
				$totala = number_format($totala, 2);
				$sub_array = "<div class='row report'><div class='col-sm-5'><strong>Total Assets</strong></div><div class='col-sm-4'></div><div class='col-sm-2' style='text-align: right; border-top: 1px solid #000; border-bottom: 3px double #000'><strong>$ ".$totala."</strong></div></div>";
				$sub_array .= "<div class='row report'><div class='col-sm-5'><em>Liabilities</em></div></div>";
				$liability = true;
			}
			if ($totall == $curr) {
				$sub_array .= "
					<div class='row report'>
						<div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div>
						<div class='col-sm-3' style='text-align: right;'>$ ".number_format($curr, 2)."</div>
						<div class='col-sm-3'></div>
					</div>";
			} else {
				$sub_array .= "
					<div class='row report'>
						<div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div>
						<div class='col-sm-3' style='text-align: right;'>".number_format($curr, 2)."</div>
						<div class='col-sm-3'></div>
					</div>";
			}							
		} else if ($row['Category'] == "Equity" ) {
			$totale += $row['CurrentBalance'];
			if (!$equity) {
				$totallf = number_format($totall, 2);
				$sub_array = "<div class='row report'><div class='col-sm-5'><strong>Total Liabilities</strong></div><div class='col-sm-4'></div><div class='col-sm-2' style='text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000'><strong>$ ".$totallf."</strong></div></div>";
				$sub_array .= "<div class='row report'><div class='col-sm-5'><em>Equities</em></div></div>";
				$equity = true;				
			}
			if ($row['AccountName'] == "Retained Earnings") {
				$sub_array .= "
					<div class='row report'>
						<div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div>
						<div class='col-sm-3' style='text-align: right;'>4,525.00</div>
						<div class='col-sm-3'></div>
					</div>";
				$totale += 4525;
			} else {
				$sub_array .= "
					<div class='row report'>
						<div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div>
						<div class='col-sm-3' style='text-align: right;'>$ ".number_format($curr, 2)."</div>
						<div class='col-sm-3'></div>
					</div>";
			}			
		}
 		$data[] = $sub_array;
	}

	$totalef = number_format($totale, 2);
	$data[] = "<div class='row report'><div class='col-sm-5'><strong>Total Equities</strong></div><div class='col-sm-4'></div><div class='col-sm-2' style='text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000'><strong>$ ".$totalef."</strong></div></div>";

	$tle = $totall + $totale;
	$tle = number_format($tle, 2);

	$data[] = "<div class='row report' style='margin-bottom:10px; margin-top:20px;'><div class='col-sm-5'><strong>Total Liabilities & Equities</strong></div><div class='col-sm-4'></div><div class='col-sm-2' style='text-align: right; border-top: 1px solid #000; border-bottom: 3px double #000'><strong>$ ".$tle."</strong></div></div>";

	$output = array('Balance Sheet', $data);

	echo json_encode($output);

?>