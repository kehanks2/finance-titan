<?php
include('../include/config.php');
session_start();

if (isset($_POST['accountID'], $_POST['accountName'])) {
	$accountID = mysqli_real_escape_string($db, $_POST['accountID']);
	$accountName = mysqli_real_escape_string($db, $_POST['accountName']);
	$_SESSION['accountID'] = $accountID;
	$_SESSION['accountName'] = $accountName;
	
	$data = "ledger.php";
	echo $data;
}

?>