<?php
include('../include/config.php');
session_start();

if (isset($_POST['accountID'], $_POST['accountName'])) {
	// if all data has successfully been retrieved from table...
	// generate variables to hold clean data
	$accountID = mysqli_real_escape_string($db, $_POST['accountID']);
	$accountName = mysqli_real_escape_string($db, $_POST['accountName']);
	// set account id and account name session variables
	$_SESSION['accountID'] = $accountID;
	$_SESSION['accountName'] = $accountName;
	
	// send redirect location back to table
	$data = "ledger.php";
	echo $data;
}

?>