<?php
//fetch.php
	include("config.php");
	$before = array('DebitBefore', 'CreditBefore', 'BalanceBefore', 'ActivityBefore');
	$after = array('DebitAfter', 'CreditAfter', 'BalanceAfter', 'ActivityAfter');
	$columns = array('EventID', 'AccountAffectedID', 'AccountAffected', $before, $after, 'Username', 'EventDateTime');

	$query = "SELECT * FROM AccountEvents ";

	if(isset($_POST["search"]["value"])) {
 		$query .= '
 			WHERE AccountAffected LIKE "%'.$_POST["search"]["value"].'%" 
 			OR AccountAffectedID LIKE "%'.$_POST["search"]["value"].'%" 
 			OR Username LIKE "%'.$_POST["search"]["value"].'%"
 			';
	}

	if(isset($_POST["order"])) {
 		$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 		';
	} else {
 		$query .= 'ORDER BY EventID DESC ';
	}

	$query1 = '';

	if($_POST["length"] != -1) {
 		$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$number_filter_row = mysqli_num_rows(mysqli_query($db, $query));

	$result = mysqli_query($db, $query . $query1);

	$data = array();

	while($row = mysqli_fetch_array($result)) {
		// set number formats to x,xxx.xx
		$debit_before = number_format($row["DebitBefore"], 2);
		$debit_after = number_format($row["DebitAfter"], 2);
		$credit_before = number_format($row["CreditBefore"], 2);
		$credit_after = number_format($row["CreditAfter"], 2);
 		$bal_before = number_format($row["BalanceBefore"], 2);
		$bal_after = number_format($row["BalanceAfter"], 2);
		// child column data
		$activebefore = '';
		$activeafter = '';
		if ($row['ActivityBefore'] == 1) {
			$activebefore = "Yes";
		} else if ($row['ActivityBefore'] == 0) {
			$activebefore = "No";
		}
		if ($row['ActivityAfter'] == 1) {
			$activeafter = "Yes";
		} else if ($row['ActivityAfter'] == 0) {
			$activeafter = "No";
		}
		
		$child_row = array();
		$child_row[0] = '<div class="row child-row">Debit</div><div class="row child-row">Credit</div><div class="row child-row">Balance</div><div class="row child-row">Active?</div>';
		
		$child_row[1] = '<div class="row child-row">' .$debit_before. '</div><div class="row child-row">' .$credit_before. '</div><div class="row child-row">' .$bal_before. '</div><div class="row child-row">' .$activebefore. '</div>';
		
		$child_row[2] = '<div class="row child-row child-row-last">' .$debit_after. '</div><div class="row child-row child-row-last">' .$credit_after. '</div><div class="row child-row child-row-last">' .$bal_after. '</div><div class="row child-row child-row-last">' .$activeafter. '</div>';
		
		// column data
		$sub_array = array();
 		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="EventID">' .$row["EventID"]. '</div>';
		
 		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="AccountAffected">' .$row["AccountAffected"]. '</div>';
		
 		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="AccountAffectedID">' .$row["AccountAffectedID"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="FieldChanged">' .$child_row[0]. '</div>';
		
 		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="From">' .$child_row[1]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="To">' .$child_row[2]. '</div>';
		
 		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="Username">' .$row["Username"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="' .$row["EventID"]. '" data-column="EventDateTime">' .$row["EventDateTime"]. '</div>';
		
 		$data[] = $sub_array;
	}

	function get_all_data($db) {
 		$query = "SELECT * FROM AccountEvents";
 		$result = mysqli_query($db, $query);
 		return mysqli_num_rows($result);
	}

	$output = array(
 		"draw"    => intval($_POST["draw"]),
 		"recordsTotal"  =>  get_all_data($db),
 		"recordsFiltered" => $number_filter_row,
 		"data"    => $data
	);

	echo json_encode($output);

?>