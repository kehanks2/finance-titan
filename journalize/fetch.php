<?php
	include("../include/config.php");
	/*
	For the journalize table we need something like this for each entry:
	
	Date 	| Creator 	| Type 		| Accounts 						| Debits | Credits | Status
	--------------------------------------------------------------------------------------------
	Y-m-d	| jsmith	| khdgjh	| 100 - Cash					| 100.00 | 		   | Pending
			|			|			| 101 - Accounts Receivable		| 50.00	 |		   |		
			|			|			|		201 - Accounts Payable	|		 | 150.00  |
			|			|			| Description: dfgkhdkfjghdg	|		 |		   |
	--------------------------------------------------------------------------------------------
	
	From LedgerEntries: 			DateAdded, Creator, Type, Description, Status
	From LedgerAccountsAffected:	LedgerEntryID, AccountNumber, AccountSide, Balance
	From Accounts:					AccountNumber, AccountName, NormalSide
	
	Need to determine the correct queries to make this work.
	Seems like we need to use joins but I cant figure them out.
	
	This page is currently a skeleton of what we need.
	
	Particularly the columns array and the initial $query select need to be resolved
	before I can build the table with the data.
	*/

	// start column sort and search query
	$columns = array('Date', 'Creator', 'Type', 'AccountName', 'Debit', 'Credit', 'Status');
	
	$query = "SELECT * FROM LedgerEntries ";
	
	if(isset($_POST["search"]["value"])) {
		
 		$query .= '
 			WHERE DateAdded LIKE "%'.$_POST["search"]["value"].'%"
			OR Creator LIKE "%'.$_POST["search"]["value"].'%"
 			OR Type LIKE "%'.$_POST["search"]["value"].'%" 
 			OR Status LIKE "%'.$_POST["search"]["value"].'%"
 			';		
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
		
		//*** start child query ***//
		
		$entry_id = $row["LedgerEntryID"];
		
		$child_query = "SELECT Accounts.AccountNumber, Accounts.AccountName, LedgerAccountsAffected.AccountSide, LedgerAccountsAffected.Balance FROM Accounts, LedgerAccountsAffected WHERE LedgerAccountsAffected.LedgerEntryID = '$entry_id' and LedgerAccountsAffected.AccountNumber = Accounts.AccountNumber";
		
		$child_result = mysqli_query($db, $child_query);
		
		$child_account_info = array('', '', '');
		$child_debits = array('', '');
		$child_credits = array('', '');
		
		while ($child_row = mysqli_fetch_array($child_result)) {
			// put balance under debit or credit depending on AccountSide
			if ($child_row['AccountSide'] == 0) {			
				$child_account_info[0] .= '<div class="row child-row-2">'.$child_row["AccountNumber"].' - '.$child_row['AccountName'].'</div>';

				$child_debits[0] .= '<div class="row child-row-2 right-align">'.number_format($child_row['Balance'], 2).'</div>';
				$child_credits[0] .= '<div class="row child-row-2 child-row-empty child-row-last"><br><br></div>';
			} else {							
				$child_account_info[1] .= '<div class="row child-row-2 child-row-credit">'.$child_row["AccountNumber"].' - '.$child_row['AccountName'].'</div>';
				
				$child_debits[1] .= '<div class="row child-row-2 child-row-empty"><br><br></div>';
				$child_credits[1] .= '<div class="row child-row-2 right-align  child-row-last">'. number_format($child_row['Balance'], 2).'</div>';
			}
		// add description to the end of child rows
		}
		$child_account_info[2] = '<div class="row child-row-2"><strong>Description: &nbsp;</strong>'.$row['Description']. '</div>';
		
		//*** end child query ***//
		
 		$sub_array = array();
		
		// one line for each column, except the accounts/debit/credit columns which uses child query data from above
 		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="DateAdded">'.$row["DateAdded"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Creator">'.$row["Creator"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Type">'.$row["Type"].'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Accounts">'.$child_account_info[0] . $child_account_info[1] . $child_account_info[2] .'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Debits">'.$child_debits[0] . $child_debits[1] .'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Credits">'.$child_credits[0] . $child_credits[1] .'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Status">'.$row["Status"]. '</div>';
		
 		$data[] = $sub_array;
	}

	mysqli_free_result($result);

	// send table data back to table
	function get_all_data($db) {
 		$query = "SELECT * FROM LedgerEntries";
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