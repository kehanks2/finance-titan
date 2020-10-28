<?php
	include("config.php");
	session_start();

if (isset($_POST['accountName'])) {
	// start column sort and search query
	$accountName = mysqli_real_escape_string($db, $_POST['accountName']);
	$columns = array('Date', 'Creator', 'Type', 'Debit', 'Credit', 'Status');
	
	$query = "SELECT LedgerEntries.*, LedgerAccountsAffected.Balance, LedgerAccountsAffected.AccountSide FROM LedgerEntries, LedgerAccountsAffected, Accounts WHERE (LedgerEntries.LedgerEntryID = LedgerAccountsAffected.LedgerEntryID and Accounts.AccountName = '$accountName' and Accounts.AccountNumber = LedgerAccountsAffected.AccountNumber) ";
	
	/*
	 DATE	| CREATOR	| TYPE		| DEBIT		| CREDIT	| STATUS
	 ----------------------------------------------------------------
	 Y-m-d	| jsmith	| adjmt		|			| 100.00	| pending
	 ----------------------------------------------------------------
	 
	 LedgerEntries:				LedgerEntryID, DateAdded, Creator, Type, Status
	 LedgerAccountsAffected:	LedgerEntryID, AccountSide, AccountNumber
	 Accounts:					AccountName, AccountNumber
	
	*/
	
	
	if(isset($_POST["search"]["value"])) {
		
 		$query .= '
 			AND (LedgerEntries.DateAdded LIKE "%'.$_POST["search"]["value"].'%"
			OR LedgerEntries.Creator LIKE "%'.$_POST["search"]["value"].'%"
 			OR LedgerEntries.Type LIKE "%'.$_POST["search"]["value"].'%" 
 			OR LedgerEntries.Status LIKE "%'.$_POST["search"]["value"].'%") 
 			';		
	}
	
	if (isset($_SESSION['filters'])) {
		//date range
		$startDate = mysqli_real_escape_string($db, $_SESSION['startDate']);
		$endDate = mysqli_real_escape_string($db, $_SESSION['endDate']);
		
		$query .= "AND (LedgerEntries.DateAdded >= '$startDate' AND LedgerEntries.DateAdded <= '$endDate') ";
		
		//amount range
		$min = mysqli_real_escape_string($db, $_SESSION['minAmount']);
		$max = mysqli_real_escape_string($db, $_SESSION['maxAmount']);
		
		$query .= "AND (LedgerAccountsAffected.Balance >= '$min' AND LedgerAccountsAffected.Balance <= '$max') ";
		
		//type filters
		if ($_SESSION['type'] == true) {
			$count = $_SESSION['typecount'];
			$count2 = $count;
			$query .= "AND ( ";
			if (isset($_SESSION['regular'])) {
				$query .= "LedgerEntries.Type = 'Regular' ";
				$count2--;
			}
			if ($count2 != $count && $count2 != 0) {
				$query .= " OR ";
				$count = $count2;
			}
			if (isset($_SESSION['adjusting'])) {
				$query .= "LedgerEntries.Type = 'Adjusting' ";
				$count2--;
			}
			if ($count2 != $count && $count2 != 0) {
				$query .= " OR ";
				$count = $count2;
			}
			if (isset($_SESSION['reversing'])) {
				$query .= "LedgerEntries.Type = 'Reversing' ";
				$count2--;
			}
			if ($count2 != $count && $count2 != 0) {
				$query .= " OR ";
				$count = $count2;
			} 
			if (isset($_SESSION['closing'])) {
				$query .= "LedgerEntries.Type = 'Closing' ";
			}
			$query .= ")";
		}
		
		//status filters
		if ($_SESSION['status'] == true) {
			$count = $_SESSION['statuscount'];
			$count2 = $count;
			$query .= "AND ( ";
			if (isset($_SESSION['approved'])) {
				$query .= "LedgerEntries.Status = 'Approved' ";
				$count2--;
			}
			if ($count2 != $count && $count2 != 0) {
				$query .= " OR ";
				$count = $count2;
			}
			if (isset($_SESSION['pending'])) {
				$query .= "LedgerEntries.Status = 'Pending' ";
				$count2--;
			}
			if ($count2 != $count && $count2 != 0) {
				$query .= " OR ";
				$count = $count2;
			}
			if (isset($_SESSION['rejected'])) {
				$query .= "LedgerEntries.Status = 'Rejected' ";
			} 
			$query .= ") ";
		}
		
		//destroy session filter variables
		unset($_SESSION['filters']);
		unset($_SESSION['startDate']);
		unset($_SESSION['endDate']);
		unset($_SESSION['minAmount']);
		unset($_SESSION['maxAmount']);
		unset($_SESSION['type']);
		unset($_SESSION['regular']);
		unset($_SESSION['adjusting']);
		unset($_SESSION['reversing']);
		unset($_SESSION['closing']);
		unset($_SESSION['status']);
		unset($_SESSION['pending']);
		unset($_SESSION['approved']);
		unset($_SESSION['rejected']);
		unset($_SESSION['statuscount']);
		unset($_SESSION['typecount']);
	}

	if(isset($_POST["order"])) {
 		$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 		';
	} else {
 		$query .= 'ORDER BY LedgerEntryID DESC ';
	}
	// end column sort and serach query

	$query1 = '';
	if($_POST["length"] != -1) {
		// get table data
 		$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$number_filter_row = mysqli_num_rows(mysqli_query($db, $query));
	$result = mysqli_query($db, $query . $query1);
	$data = array();
	
	// loop through each row in query result and display in the table
	while($row = mysqli_fetch_array($result)) {
		$debit = '';
		$credit = '';
		// check account side to determine if amount is a debit or a credit
		if ($row['AccountSide'] == 0) {
			$debit = number_format($row['Balance'], 2);
		} else if ($row['AccountSide'] == 1) {
			$credit = number_format($row['Balance'], 2);
		}
		
 		$sub_array = array();
		
		// one line for each column, except the accounts/debit/credit columns which uses child query data from above
 		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="DateAdded">'.$row["DateAdded"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Creator">'.$row["Creator"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Type">'.$row["Type"].'</div>';
						
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Debit">'.$debit.'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Credit">'.$credit.'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Status">'.$row["Status"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Entry"><button data-target="#view-entry-modal" data-toggle="modal" type="button" class="btn btn-primary btn-width" id="view-entry-btn">View Entry</a></div>';
		
 		$data[] = $sub_array;
	}

	mysqli_free_result($result);

	// send table data back to table
	function get_all_data($db) {
		$accountName = mysqli_real_escape_string($db, $_POST['accountName']);
 		$query =  "SELECT LedgerEntries.* FROM LedgerEntries, LedgerAccountsAffected, Accounts WHERE (LedgerEntries.LedgerEntryID = LedgerAccountsAffected.LedgerEntryID and Accounts.AccountName = '$accountName' and Accounts.AccountNumber = LedgerAccountsAffected.AccountNumber)";
 		$result = mysqli_query($db, $query);
 		return mysqli_num_rows($result);
	}

	$output = array(
 		"draw"    => intval($_POST["draw"]),
 		"recordsTotal"  =>  get_all_data($db),
 		"recordsFiltered" => $number_filter_row,
 		"data"    => $data
	);
}
	echo json_encode($output);
?>