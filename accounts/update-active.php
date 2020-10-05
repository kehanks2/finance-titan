<?php
include("../include/session.php");
if(isset($_POST['isActive'], $_POST['accountID'])) {
	// if all data has successfully been retrieved from table...
	// generate variables to hold clean data
	$accountID = mysqli_real_escape_string($db, $_POST["accountID"]);
	$isActive = mysqli_real_escape_string($db, $_POST["isActive"]);
	$username = mysqli_real_escape_string($db, $_SESSION["login_user"]);
    	
	// query to update active status for account
	$query = "UPDATE Accounts SET isActive = '".$isActive."' WHERE AccountNumber = '".$accountID."'";
	// query to insert change to event log
    $eventQuery ="INSERT INTO AccountEvents(
         Username,
         AccountAffected,
         AccountAffectedID,
         DebitAfter,
         CreditAfter,
         BalanceAfter,
         ActivityBefore,
         ActivityAfter) 
         VALUES(
            '$username',
            (SELECT AccountName FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT AccountNumber FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT Debit FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT Credit FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT CurrentBalance FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT IsActive FROM Accounts WHERE '$accountID'= AccountNumber),
            '$isActive')";	
	if(mysqli_query($db, $eventQuery) && mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 3;
	}
	
	// send return message to table
	echo $data;
}
?>