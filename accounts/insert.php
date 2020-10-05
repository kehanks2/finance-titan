<?php
include("../include/session.php");
if(isset($_POST["accountID"], $_POST["accountname"], $_POST["desc"], $_POST["cat"], $_POST["subcat"], $_POST["initbal"], $_POST["debit"], $_POST["credit"], $_POST["currbal"], $_POST["nside"], $_POST["dateadded"], $_POST["creator"])) {
 	$username = mysqli_real_escape_string($db, $_SESSION["login_user"]);
    $accountID = mysqli_real_escape_string($db, $_POST["accountID"]);
	$accountname = mysqli_real_escape_string($db, $_POST["accountname"]);
 	$desc = mysqli_real_escape_string($db, $_POST["desc"]);	
	$cat = mysqli_real_escape_string($db, $_POST["cat"]);
	$subcat = mysqli_real_escape_string($db, $_POST["subcat"]);
 	$initbal = mysqli_real_escape_string($db, $_POST["initbal"]);
 	$debit = mysqli_real_escape_string($db, $_POST["debit"]);
	$credit = mysqli_real_escape_string($db, $_POST["credit"]);
	$currbal = mysqli_real_escape_string($db, $_POST["currbal"]);
	$nside = mysqli_real_escape_string($db, $_POST["nside"]);
	$dateadded = mysqli_real_escape_string($db, $_POST["dateadded"]);
	$creator = mysqli_real_escape_string($db, $_POST["creator"]);
	
	$sql_check = "SELECT AccountNumber, AccountName FROM Accounts";
	$result_check = mysqli_query($db, $sql_check);
	
	$data = 4;
	while($row = mysqli_fetch_array($result_check)) {
		
		if ($row["AccountNumber"] == $accountID) {
			$data = 1;
			break;
		} else if ($row["AccountName"] == $accountname) {
			$data = 2;
			break;
		}
	}
	
	if ($data != 1 && $data != 2) {
        
		$query = "INSERT INTO Accounts(AccountNumber, AccountName, Description, Category, SubCategory, InitialBalance, Debit, Credit, CurrentBalance, NormalSide, DateAdded, CreatorID) VALUES('$accountID', '$accountname', '$desc', '$cat', '$subcat', '$initbal', '$debit', '$credit', '$currbal', '$nside', '$dateadded', '$creator')";
        $eventQuery ="INSERT INTO AccountEvents(
         Username,
         AccountAffected,
         AccountAffectedID,
         DebitAfter,
         CreditAfter,
         BalanceAfter) 
         VALUES(
            '$username',
            (SELECT AccountName FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT AccountNumber FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT Debit FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT Credit FROM Accounts WHERE '$accountID' = AccountNumber),
            (SELECT CurrentBalance FROM Accounts WHERE '$accountID' = AccountNumber))";	
 			if(mysqli_query($db, $query)&& mysqli_query($db, $eventQuery)) {
  				$data = 0;
 			} else {
				$data = 4;
			}
	}
	
	echo $data;
	
}
?>