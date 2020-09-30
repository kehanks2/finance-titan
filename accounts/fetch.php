<?php
//fetch.php
	include("../include/config.php");
	$columns = array('AccountNumber', 'AccountName', 'Description', 'Category', 'SubCategory', 'InitialBalance', 'Debit', 'Credit', 'CurrentBalance', 'NormalSide', 'DateAdded', 'CreatorID');

	$query = "SELECT * FROM Accounts ";

	if(isset($_POST["search"]["value"])) {
 		$query .= '
 			WHERE AccountName LIKE "%'.$_POST["search"]["value"].'%"
			OR AccountNumber LIKE "%'.$_POST["search"]["value"].'%"
 			OR Category LIKE "%'.$_POST["search"]["value"].'%" 
 			OR SubCategory LIKE "%'.$_POST["search"]["value"].'%"
 			';
	}

	if(isset($_POST["order"])) {
 		$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 		';
	} else {
 		$query .= 'ORDER BY AccountNumber ASC ';
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
 		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="AccountNumber">'. $row["AccountNumber"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="AccountName">'. $row["AccountName"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="Description">'. $row["Description"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="Category">'. $row["Category"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="SubCategory">'. $row["SubCategory"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="InitialBalance">'. $row["InitialBalance"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="Debit">'. $row["Debit"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="Credit">'. $row["Credit"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="CurrentBalance">'. $row["CurrentBalance"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="NormalSide">'. $row["NormalSide"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="DateAdded">'. $row["DateAdded"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="CreatorID">'. $row["CreatorID"].'</div>';	
		
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
 		"data"    => $data
	);

	echo json_encode($output);

?>