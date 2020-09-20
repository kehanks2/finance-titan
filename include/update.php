<?php
include("config.php");
if(isset($_POST["id"])) {
 	$value = mysqli_real_escape_string($db, $_POST["value"]);
 	$query = "UPDATE Users SET ".$_POST["column_name"]."='".$value."' WHERE UserID = '".$_POST["id"]."'";
 	if(mysqli_query($db, $query)) {
  		echo 'Data Updated';
 	}
}
?>