<?php
include('../include/config.php');
if (isset($_POST['id'], $_POST['comment'])) {
	$id = mysqli_real_escape_string($db, $_POST['id']);
	$comment = mysqli_real_escape_string($db, $_POST['comment']);
	
	$query = "UPDATE LedgerEntries SET Status = 'Rejected', UpdateComments = '$comment' WHERE LedgerEntryID = '$id'";
	
	if (mysqli_query($db, $query)) {
		$data = 12;
	} else {
		$data = 13;
	}
	
	echo $data;
}
?>