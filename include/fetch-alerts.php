<?php
include('config.php');

$query = "SELECT * FROM LedgerEntries";

$result = mysqli_query($db, $query);

$num_results = 0;
while ($row = mysqli_fetch_array($result)) {
	if ($row['Status'] == 'Pending') {
		$num_results++;
	}
}

echo $num_results;

?>