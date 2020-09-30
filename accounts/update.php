<?php
include("../include/config.php");
if(isset($_POST["accountID"], $_POST["desc"], $_POST["cat"], $_POST["subcat"], $_POST["initbal"], $_POST["debit"], $_POST["credit"], $_POST["currbal"], $_POST["nside"])) {
	$accountID = mysqli_real_escape_string($db, $_POST["accountID"]);
 	$desc = mysqli_real_escape_string($db, $_POST["desc"]);	
	$cat = mysqli_real_escape_string($db, $_POST["cat"]);
	$subcat = mysqli_real_escape_string($db, $_POST["subcat"]);
 	$initbal = mysqli_real_escape_string($db, $_POST["initbal"]);
 	$debit = mysqli_real_escape_string($db, $_POST["debit"]);
	$credit = mysqli_real_escape_string($db, $_POST["credit"]);
	$currbal = mysqli_real_escape_string($db, $_POST["currbal"]);
	$nside = mysqli_real_escape_string($db, $_POST["nside"]);
		
	$query = "UPDATE Accounts SET Description = '".$desc."', Category = '".$cat."', SubCategory = '".$subcat."', InitialBalance = '".$initbal."', Debit = '".$debit."', Credit = '".$credit."', CurrentBalance = '".$currbal."', NormalSide = '".$nside."' WHERE AccountNumber = '".$_POST["accountID"]."'";
	if(mysqli_query($db, $query)) {
		$data = 0;
	} else {
		$data = 3;
	}
	
	echo $data;
}
?>