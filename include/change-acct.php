<?php 
include('session.php');
if(isset($_POST["accountName"])) {
	$_SESSION['accountName'] = $_POST["accountName"];
}

echo 1;

?>