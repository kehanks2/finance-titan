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
	$account_info = array('AccountNumber', 'AccountName');
	$columns = array('DateAdded', 'Creator', 'Type', $account_info, 'Status');
	
	$query = "SELECT * FROM Table";
	
	if(isset($_POST["search"]["value"])) {
		
 		$query .= '
 			WHERE item1 LIKE "%'.$_POST["search"]["value"].'%"
			OR item2 LIKE "%'.$_POST["search"]["value"].'%"
 			OR item3 LIKE "%'.$_POST["search"]["value"].'%" 
 			OR item...n LIKE "%'.$_POST["search"]["value"].'%"
 			';		
	}

	if(isset($_POST["order"])) {
 		$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 		';
	} else {
 		$query .= 'ORDER BY DateAdded ASC ';
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
		// format numbers as x,xxx.xx
		$var = number_format($row["column-to-format"], 2);
		
		$child_account_info = '';
		$child_debits = '';
		$child_credits = '';
		// this may need to be done outside of this while loop and into another using a different query, but i'm not sure
		for ($i = 0; $i < count(/*accounts with same LedgerEntryId*/); $i++) {
			$child_account_info .= '<div class="row child-row">'.$row["AccountNumber"].' - '.$row['AccountName'].'</div>';
			// put balance under debit or credit depending on normal side of account and entry data
			if ((($row['NormalSide'] == 'left') && ($row['AccountSide'] == 0)) ||
			    (($row['NormalSide'] == 'right') && ($row['AccountSide'] == 1))) {
					$child_debits .= '<div class="row child-row">'.$row['Balance'].'</div>';
					$child_credits .= '<div class="row child-row"> </div>';
			} else {
					$child_debits .= '<div class="row child-row"> </div>';
					$child_credits .= '<div class="row child-row">'.$row['Balance'].'</div>';
			}
		}
		// add description to the end of child rows
		$chils_account_info .= '<div class="row child-row">Description: '.$row['Description'].'</div>';
		
 		$sub_array = array();
		
		// one line for each column, except the accounts/debit/credit columns,
		// which will use child_row data, from above
 		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="DateAdded">'.$row["DateAdded"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Creator">'.$row["Creator"]. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Type">'.$row["Type"].'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Accounts">'.$child_account_info .'</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Debits">'.$child_debits. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Credits">'.$child_credits. '</div>';
		
		$sub_array[] = '<div class="update" data-id="'.$row["LedgerEntryID"].'" data-column="Status">'.$row["Status"]. '</div>';
		
 		$data[] = $sub_array;
	}

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