<?php
include("../include/session.php");
if(isset($_POST["date"], $_POST["creator"], $_POST["status"], $_POST["debit"], $_POST["credit"])) {
	$date = mysqli_real_escape_string($db, $_POST['date']);
	$creator = mysqli_real_escape_string($db, $_POST['creator']);
	$type = mysqli_real_escape_string($db, $_POST['type']);
	$desc = mysqli_real_escape_string($db, $_POST['desc']);
	$status = mysqli_real_escape_string($db, $_POST['status']);
	
	$debit = json_decode($_POST["debit"], true);
	$debit_ids = [];
	$debit_amts = [];
	$debit_total = 0;
	for ($i = 0; $i < count($debit); $i++) {
		$debit_ids[] = $debit[$i][0];
		$debit_amts[] = $debit[$i][1];
		$debit_total += $debit[$i][1];
	}
	
	
	$credit = json_decode($_POST["credit"], true);
	$credit_ids = [];
	$credit_amts = [];
	$credit_total = 0;
	for ($i = 0; $i < count($credit); $i++) {
		$credit_ids[] = $credit[$i][0];
		$credit_amts[] = $credit[$i][1];
		$credit_total += $credit[$i][1];
	}
		
	// initial insert into ledger entries table
	$entryquery = "INSERT INTO LedgerEntries (DateAdded, Creator, Type, Description, Debit, Credit, Status) VALUES ('$date', '$creator', '$type', '$desc', '$debit_total', '$credit_total', '$status')";
	
	// on success do subsequent inserts for accounts affected table
	if(mysqli_query($db, $entryquery)) {
		// get id for ledger entry inserted above
		$entry_id = mysqli_insert_id($db);
		$accountsquery = "";

		for ($i = 0; $i < count($debit_ids); $i++) {
			$id = $debit_ids[$i];
			$bal = $debit_amts[$i];
						
			// for each debit id, insert into accounts affected table
			$accountsquery .= "INSERT INTO LedgerAccountsAffected (AccountSide, AccountNumber, Balance, LedgerEntryID) VALUES ('0', '$id', '$bal', '$entry_id'); ";
		}
		
		for ($i = 0; $i < count($credit_ids); $i++) {
			$id = $credit_ids[$i];
			$bal = $credit_amts[$i];
			
			// for each credit id, insert into accounts affected table
			$accountsquery .= "INSERT INTO LedgerAccountsAffected (AccountSide, AccountNumber, Balance, LedgerEntryID) VALUES ('1', '$id', '$bal', '$entry_id'); ";
		}
				
		if (mysqli_multi_query($db, $accountsquery)) {
			
			if (isset($_POST['manager']) && ($_POST['manager'] == true)) {
				//if successful update debit/credit and current balance for each affected account
				mysqli_next_result($db);
				mysqli_next_result($db);

				$updatequery = "";			

				for ($j = 0; $j < count($debit_ids); $j++) {				
					$id = $debit_ids[$j];
					// for each id, update values to be inserted, based on normal side
					$acctquery = "SELECT * FROM Accounts WHERE AccountNumber = '$id';";
					$res = mysqli_query($db, $acctquery);

					$d = 0;
					$curr = 0;
					while ($row = mysqli_fetch_array($res)) {					
						$d = (double)($row['Debit'] + $debit_amts[$j]);

						if ($row['NormalSide'] == 'left') {
							$curr = (double)($row['CurrentBalance'] + $debit_amts[$j]);
						} else if ($row['NormalSide'] == 'right') {
							$curr = (double)($row['CurrentBalance'] - $debit_amts[$j]);
						}
					}

					$updatequery .= "UPDATE Accounts SET Debit = '$d', CurrentBalance = '$curr' WHERE AccountNumber = '$id'; ";

					mysqli_free_result($res);
					mysqli_next_result($db);
				}

				for ($j = 0; $j < count($credit_ids); $j++) {
					$id = $credit_ids[$j];
					// for each id, update values to be inserted, based on normal side
					$acctquery = "SELECT * FROM Accounts WHERE AccountNumber = '$id';";
					$res = mysqli_query($db, $acctquery);
					$c = 0;
					$curr = 0;
					while ($row = mysqli_fetch_array($res)) {					
						$c = (double)($row['Credit'] + $credit_amts[$j]);	

						if ($row['NormalSide'] == 'left') {
							$curr = (double)($row['CurrentBalance'] - $credit_amts[$j]);
						} else if ($row['NormalSide'] == 'right') {
							$curr = (double)($row['CurrentBalance'] + $credit_amts[$j]);
						}
					}		

					$updatequery .= "UPDATE Accounts SET Credit = '$c', CurrentBalance = '$curr' WHERE AccountNumber = '$id'; ";

					mysqli_free_result($res);
					mysqli_next_result($db);
				}
				
				if (mysqli_multi_query($db, $updatequery)) {
					$data = 0;
				} else {
					$data = 1;
				}
				
			} else {
				$data = 0;
			}
			
		} else {
			$data = 2;
		}
			
	} else {
		$data = 3;
	}
}
	echo $data;
?>