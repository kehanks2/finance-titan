<?php
include('config.php');
if (isset($_POST['accountName'], $_POST['entry_id'])) {
	$accountName = mysqli_real_escape_string($db, $_POST['accountName']);
	$entry_id = mysqli_real_escape_string($db, $_POST['entry_id']);
	
	$query = "SELECT * FROM LedgerEntries WHERE LedgerEntryID = '$entry_id'";
	
	/* MODAL LAYOUT
	
	Journal Entry
	----------------------------------------------------------------------
	Date:	Y-m-d		Creator:	jsmith0920		Status:		Pending
	Type:	Adjustment				Description:	This is an adjustment
	----------------------------------------------------------------------
	Accounts								| Debits		| Credits
	----------------------------------------------------------------------
	100 - Cash								| 50.00			|
	101 - Accounts Receivable				| 100.00		|
		201 - Accounts Payable				|				| 150.00
	----------------------------------------------------------------------
	*/
	
	$result = mysqli_query($db, $query);
	$count = mysqli_num_rows($result);
	
	$data = array();
	while ($row = mysqli_fetch_array($result)) {
		$data[0] = $row['DateAdded'];
		$data[1] = $row['Creator'];
		$data[2] = $row['Status'];
		$data[3] = $row['Type'];
		$data[4] = $row['Description'];
		
		$child_query = "
			SELECT
				Accounts.AccountNumber, Accounts.AccountName, 
				LedgerAccountsAffected.AccountSide, LedgerAccountsAffected.Balance 
			FROM 
				Accounts, LedgerAccountsAffected 
			WHERE 
				LedgerAccountsAffected.LedgerEntryID = '$entry_id' 
				AND LedgerAccountsAffected.AccountNumber = Accounts.AccountNumber";
		
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
		}
		
		$data[5] = $child_account_info;
		$data[6] = $child_debits;
		$data[7] = $child_credits;		
	}
	
	if (mysqli_num_rows($result) != 1) {
		echo json_encode($count);
	} else {
		echo json_encode($data);		
	}
}


?>