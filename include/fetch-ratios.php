<?php
include('config.php');

$query = "SELECT * FROM Accounts";
$result = mysqli_query($db, $query);

$assets_total = 0;
$liabilities_total = 0;
$equities_total = 4525.00;

$income = 0;

// true == left, false == right
$nside = true;

while($row = mysqli_fetch_array($result)) {
	// set $nside variable
	if ($row['NormalSide'] == 'left') {
		$nside = true;
	} else {
		$nside = false;
	}
	
	// add CurrentBalance of each item to appropriate category total
	if ($row['Category'] == 'Asset') {
		if ($nside) {
			$assets_total += $row['CurrentBalance'];
		} else {
			$assets_total -= $row['CurrentBalance'];
		}		 
	} else if ($row['Category'] == 'Liability') {
		if (!$nside) {
			$liabilities_total += $row['CurrentBalance'];
		} else {
			$liabilities_total -= $row['CurrentBalance'];
		}
	} else if ($row['Category'] == 'Equity') {
		if (!$nside) {
			$equities_total += $row['CurrentBalance'];
		} else {
			$equities_total -= $row['CurrentBalance'];
		}
	} else if ($row['Category'] == 'Revenue') {
		if (!$nside) {
			$income += $row['CurrentBalance'];
		} else {
			$income -= $row['CurrentBalance'];
		}
	}
}

$data = array();

// data[0] set to current ratio
$current_ratio = $assets_total / (float) $liabilities_total;
$current_ratio = number_format($current_ratio, 2);
$data[0] = $current_ratio;

// data[1] set to return on assets
$return_assets = $income / (float) $assets_total;
$return_assets = number_format($return_assets, 2);
$data[1] = $return_assets;

// data[2] set to return on equity ratio
$return_equity = $income / (float) ($equities_total - 4525.00);
$return_equity = number_format($return_equity, 2);
$data[2] = $return_equity;

// data[3] set to debt ratio
$debt_ratio = $liabilities_total / (float) $assets_total;
$debt_ratio = number_format($debt_ratio, 2);
$data[3] = $debt_ratio;

// data[4] set to debt to equity ratio
$debt_equity = $liabilities_total / (float) ($equities_total - 4525.00);
$debt_equity = number_format($debt_equity, 2);
$data[4] = $debt_equity;


echo json_encode($data);

?>