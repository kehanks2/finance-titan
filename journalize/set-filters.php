<?php 
include('../include/config.php');
session_start();

$_SESSION['filters'] = true;

$_SESSION['startDate'] = $_POST['startDate'];
$_SESSION['endDate'] = $_POST['endDate'];
$_SESSION['minAmount'] = $_POST['minAmount'];
$_SESSION['maxAmount'] = $_POST['maxAmount'];

$_SESSION['type'] = false;
$typecount = 0;
if ($_POST['type1'] == 1) {
	$_SESSION['regular'] = 'Regular';
	$_SESSION['type'] = true;
	$typecount++;
}
if ($_POST['type2'] == 1) {
	$_SESSION['adjusting'] = 'Adjusting';
	$_SESSION['type'] = true;
	$typecount++;
}
if ($_POST['type3'] == 1) {
	$_SESSION['reversing'] = 'Reversing';
	$_SESSION['type'] = true;
	$typecount++;
}
if ($_POST['type4'] == 1) {
	$_SESSION['closing'] = 'Closing';
	$_SESSION['type'] = true;
	$typecount++;
}

$_SESSION['typecount'] = $typecount;

$_SESSION['status'] = false;
$statuscount = 0;
if ($_POST['status1'] == 1) {
	$_SESSION['pending'] = 'Pending';
	$_SESSION['status'] = true;
	$statuscount++;
}
if ($_POST['status2'] == 1) {
	$_SESSION['approved'] = 'Approved';
	$_SESSION['status'] = true;
	$statuscount++;
}
if ($_POST['status3'] == 1) {
	$_SESSION['rejected'] = 'Rejected';
	$_SESSION['status'] = true;
	$statuscount++;
}

$_SESSION['statuscount'] = $statuscount;

echo 'success';
?>