<?php
include("config.php");
if(isset($_POST["id"])) {
 	$query = "DELETE FROM Users WHERE UserID = '".$_POST["id"]."'";
 	if(mysqli_query($db, $query)) {
  		echo 'Data Deleted';
 	}
}
?>