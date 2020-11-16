<?php
	include("../include/config.php");

	$query = 'SELECT * From Accounts WHERE CurrentBalance != 0 ORDER BY AccountNumber';

	$result = mysqli_query($db, $query);

	$data = array();
	$data[] = "<h3>Date: " . date('Y-m-d'). "</h4>";
	$data[] = "<div class='row report'><div class='col-sm-5'><h4>Account Name</h4></div><div class='col-sm-3' style='text-align: right;'><h4>Debit</h4></div><div class='col-sm-3' style='text-align: right;'><h4>Credit</h4></div></div>";

	$totald = 0;
	$totalc = 0;
	// loop through each row in query result and display in the table
	while($row = mysqli_fetch_array($result)) {
		// find if credit, debit, or neither
		$nside = $row['NormalSide'];
		$curr = $row['CurrentBalance'];
		$debit = false;
		$credit = false;
		if (($nside == 'left' && $curr > 0) || ($nside == 'right' && $curr < 0)) {
			$debit = true;
		} else if (($nside == 'left' && $curr < 0) || ($nside == 'right' && $curr > 0)) {
			$credit = true;
		}
		
		if ($debit) {			
			$sub_array = array();

			$sub_array = "<div class='row report'><div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div><div class='col-sm-3' style='text-align: right;'>".number_format($curr, 2)."</div><div class='col-sm-3'></div></div>";
			
			$totald += (double) $curr;
			
		} else if ($credit) {			
			$sub_array = array();

			$sub_array = "<div class='row report'><div class='col-sm-5' style='margin-left:15px;'>".$row['AccountName']."</div><div class='col-sm-3'></div><div class='col-sm-3' style='text-align: right;'>".number_format($curr, 2)."</div></div>";
			
			$totalc += (double) $curr;
		}
		
 		$data[] = $sub_array;
	}

	$totalc = number_format($totalc, 2);
	$totald = number_format($totald, 2);

	$data[] = "<div class='row report' style='margin-bottom:10px;'><div class='col-sm-5' style='margin-left:15px;'><strong>Total</strong></div><div class='col-sm-3' style='text-align: right;'><strong>".$totald."</strong></div><div class='col-sm-3' style='text-align: right;'><strong>".$totalc."</strong></div></div>";

	$output = array('Trial Balance', $data);

	echo json_encode($output);

?>