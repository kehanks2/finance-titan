<?php
include('../include/config.php');

if (isset($_POST['id'])) {
	$id = mysqli_real_escape_string($db, $_POST['id']);
	
	$query = "SELECT LedgerAccountsAffected.AccountNumber, LedgerAccountsAffected.AccountSide, Accounts.NormalSide, LedgerAccountsAffected.Balance, Accounts.Debit, Accounts.Credit, Accounts.CurrentBalance FROM LedgerAccountsAffected, Accounts WHERE LedgerAccountsAffected.LedgerEntryID = '$id' and LedgerAccountsAffected.AccountNumber = Accounts.AccountNumber";
	
	$result = mysqli_query($db, $query);
	
	$updatequery = "";
	while ($row = mysqli_fetch_array($result)) {	
		
		$acct_id = $row['AccountNumber'];
		$d = (double)($row['Debit']);
		$c = (double)($row['Credit']);
		$curr = (double)($row['CurrentBalance']);
		
		if ($row['AccountSide'] == 0) {
			$d += $row['Balance'];
			if ($row['NormalSide'] == 'left') {
				$curr += $row['Balance'];				
			} else {
				$curr -= $row['Balance'];
			}
		} else {
			$c += $row['Balance'];
			if ($row['NormalSide'] == 'right') {
				$curr += $row['Balance'];				
			} else {
				$curr -= $row['Balance'];
			}
		}

		$updatequery .= "UPDATE Accounts SET Debit = '$d', Credit = '$c', CurrentBalance = '$curr' WHERE AccountNumber = '$acct_id'; ";
	}	
	// query to insert change into event log
	$eventQuery = "INSERT INTO AccountEvents(
    Username,
    AccountAffected,
    AccountAffectedID,
    DebitBefore,
    DebitAfter,
    CreditBefore,
    CreditAfter,
    BalanceBefore,
    BalanceAfter,
    ActivityAfter,
    ActivityBefore) VALUES(
        'Journal Approved',
        (SELECT AccountName FROM Accounts WHERE '$acct_id' = AccountNumber),
        (SELECT AccountNumber FROM Accounts WHERE '$acct_id' = AccountNumber),
        (SELECT Debit FROM Accounts WHERE '$acct_id' = AccountNumber),
        $d,
        (SELECT Credit FROM Accounts WHERE '$acct_id' = AccountNumber),
        $c,
        (SELECT CurrentBalance FROM Accounts WHERE '$acct_id' = AccountNumber),
        $curr,
        (SELECT IsActive FROM Accounts WHERE '$acct_id' = AccountNumber),
        (SELECT IsActive FROM Accounts WHERE '$acct_id' = AccountNumber))";	
    
	$updatequery .= "UPDATE LedgerEntries SET Status = 'Approved' WHERE LedgerEntryID = '$id'; ";

	if (mysqli_multi_query($db, $eventQuery)&&mysqli_multi_query($db, $updatequery)) {
		$data = 10;
	} else {
		$data = 11;
	}
	
	echo $data;
}
	
?>