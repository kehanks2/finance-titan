<?php
include("../include/session.php");
if(isset($_POST['isActive'], $_POST['accountID'])) {
	$accountID = mysqli_real_escape_string($db, $_POST["accountID"]);
	$isActive = mysqli_real_escape_string($db, $_POST["isActive"]);
	$username = mysqli_real_escape_string($db, $_SESSION["login_user"]);
    	
	$query = "UPDATE Accounts SET isActive = '".$isActive."' WHERE AccountNumber = '".$accountID."'";
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
	
	echo $data;
}
?>