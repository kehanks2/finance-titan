<?php
//fetch.php
	include("../include/config.php");
	$columns = array('AccountNumber', 'AccountName', 'Description', 'Category', 'SubCategory', 'InitialBalance', 'Debit', 'Credit', 'CurrentBalance', 'DateAdded', 'CreatorID');

	$query = "SELECT * FROM Accounts ";

	if(isset($_POST["search"]["value"])) {
 		$query .= '
 			WHERE AccountName LIKE "%'.$_POST["search"]["value"].'%"
			OR AccountNumber LIKE "%'.$_POST["search"]["value"].'%"
 			OR Category LIKE "%'.$_POST["search"]["value"].'%" 
 			OR Subcategory LIKE "%'.$_POST["search"]["value"].'%"
 			';
	}

	if(isset($_POST["order"])) {
 		$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 		';
	} else {
 		$query .= 'ORDER BY AccountID DESC ';
	}

	$query1 = '';

	if($_POST["length"] != -1) {
 		$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$number_filter_row = mysqli_num_rows(mysqli_query($db, $query));

	$result = mysqli_query($db, $query . $query1);

	$data = array();

	while($row = mysqli_fetch_array($result)) {
 		$sub_array = array();
 		$sub_array[] = $row["AccountNumber"];
		$sub_array[] = $row["AccountName"];
		$sub_array[] = $row["Description"];
		$sub_array[] = $row["Category"];
		$sub_array[] = $row["SubCategory"];
		$sub_array[] = $row["InitialBalance"];
		$sub_array[] = $row["Debit"];
		$sub_array[] = $row["Credit"];
		$sub_array[] = $row["CurrentBalance"];
		$sub_array[] = $row["DateAdded"];
		$sub_array[] = $row["CreatorID"];		
		$sub_array[] = '<button name="edit" id="edit" class="btn btn-link edit-btn">Edit</button></td>';
 		$data[] = $sub_array;
	}

	function get_all_data($db) {
 		$query = "SELECT * FROM Accounts";
 		$result = mysqli_query($db, $query);
 		return mysqli_num_rows($result);
	}

	$output = array(
 		"draw"    => intval($_POST["draw"]),
 		"recordsTotal"  =>  get_all_data($db),
 		"recordsFiltered" => $number_filter_row,
 		"data"    => $data,
		"DT_RowId" => $row["AccountNumber"],
		"DT_RowClass" => "update edt"
	);

	echo json_encode($output);

?>