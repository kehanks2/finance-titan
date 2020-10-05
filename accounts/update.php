<?php
include("../include/session.php");
if(isset($_POST["accountID"], $_POST["desc"], $_POST["cat"], $_POST["subcat"], $_POST["initbal"], $_POST["debit"], $_POST["credit"], $_POST["nside"])) {
	// if all data has successfully been retrieved from table...
	// generate variables to hold clean data
    $username = mysqli_real_escape_string($db, $_SESSION["login_user"]);
	$accountID = mysqli_real_escape_string($db, $_POST["accountID"]);
 	$desc = mysqli_real_escape_string($db, $_POST["desc"]);	
	$cat = mysqli_real_escape_string($db, $_POST["cat"]);
	$subcat = mysqli_real_escape_string($db, $_POST["subcat"]);
 	$initbal = mysqli_real_escape_string($db, $_POST["initbal"]);
 	$debit = mysqli_real_escape_string($db, $_POST["debit"]);
	$credit = mysqli_real_escape_string($db, $_POST["credit"]);
	$nside = mysqli_real_escape_string($db, $_POST["nside"]);
	
	// calculate current balance
	$currbal = 0;
	if ($nside == "right") {
		$currbal = (double)($initbal + $credit - $debit);
	} else if ($nside == "left") {
		$currbal = (double)($initbal + $debit - $credit);
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
        '$username',
        (SELECT AccountName FROM Accounts WHERE '$accountID' = AccountNumber),
        (SELECT AccountNumber FROM Accounts WHERE '$accountID' = AccountNumber),
        (SELECT Debit FROM Accounts WHERE '$accountID' = AccountNumber),
        $debit,
        (SELECT Credit FROM Accounts WHERE '$accountID' = AccountNumber),
        $credit,
        (SELECT CurrentBalance FROM Accounts WHERE '$accountID' = AccountNumber),
        $currbal,
        (SELECT IsActive FROM Accounts WHERE '$accountID' = AccountNumber),
        (SELECT IsActive FROM Accounts WHERE '$accountID' = AccountNumber))";	
	// query to update account
	$query = "UPDATE Accounts SET Description = '".$desc."', Category = '".$cat."', SubCategory = '".$subcat."', InitialBalance = '".$initbal."', Debit = '".$debit."', Credit = '".$credit."', CurrentBalance = '".$currbal."', NormalSide = '".$nside."' WHERE AccountNumber = '".$_POST["accountID"]."'";
	if(mysqli_query($db, $eventQuery)&& mysqli_query($db, $query)) {
		$data = 0;
	} else
        $data = 3;
	
	// return status message to table
	echo $data;
}
?>