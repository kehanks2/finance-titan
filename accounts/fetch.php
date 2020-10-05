<?php
	include("../include/config.php");
	// start column sort and search query
	$columns = array('AccountNumber', 'AccountName', 'Description', 'Category', 'SubCategory', 'InitialBalance', 'Debit', 'Credit', 'CurrentBalance', 'NormalSide', 'DateAdded', 'CreatorID');
	
	$query = "SELECT * FROM Accounts ";
	
	if(isset($_POST["search"]["value"])) {
		
 		$query .= '
 			WHERE AccountName LIKE "%'.$_POST["search"]["value"].'%"
			OR AccountNumber LIKE "%'.$_POST["search"]["value"].'%"
 			OR Category LIKE "%'.$_POST["search"]["value"].'%" 
 			OR SubCategory LIKE "%'.$_POST["search"]["value"].'%"
 			';
		
		if ($_POST["search"]["value"] == "active"){
			$query .= "OR IsActive = '1'";
		} else if ($_POST["search"]["value"] == "inactive") {
			$query .= "OR IsActive = '0'";
		};
		
	}

	if(isset($_POST["order"])) {
 		$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 		';
	} else {
 		$query .= 'ORDER BY AccountNumber ASC ';
	}
	// end column sort and serach query

	$query1 = '';

	if($_POST["length"] != -1) {
		// get table data
 		$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$number_filter_row = mysqli_num_rows(mysqli_query($db, $query));

	$result = mysqli_query($db, $query . $query1);

	$data = array();
	
	// loop through each row in query result and display in the table
	while($row = mysqli_fetch_array($result)) {
		// format numbers as x,xxx.xx
		$initbal = number_format($row["InitialBalance"], 2);
		$debit = number_format($row["Debit"], 2);
		$credit = number_format($row["Credit"], 2);
		$currbal = number_format($row["CurrentBalance"], 2);
		// changed active button based on account's active status
		$isActive = "";
		if ($row["IsActive"] == 1) {
			$isActive = "Active";
			$edit = "";
		} else if ($row["IsActive"] == 0) {
			$isActive = "Inactive";
			$edit = "disabled";
		}
		
 		$sub_array = array();
 		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="AccountNumber">'. $row["AccountNumber"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="AccountName"><a href="#" id="ledger" class="ledger">'. $row["AccountName"].'</a></div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="Description">'. $row["Description"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="Category">'. $row["Category"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="SubCategory">'. $row["SubCategory"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt num" data-id="'.$row["AccountNumber"].'" data-column="InitialBalance">'. $initbal .'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt nm" data-id="'.$row["AccountNumber"].'" data-column="Debit">'. $debit .'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt num" data-id="'.$row["AccountNumber"].'" data-column="Credit">'. $credit .'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update num" data-id="'.$row["AccountNumber"].'" data-column="CurrentBalance" id="CurrentBalance">'. $currbal .'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["AccountNumber"].'" data-column="NormalSide">'. $row["NormalSide"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="DateAdded">'. $row["DateAdded"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["AccountNumber"].'" data-column="CreatorID">'. $row["CreatorID"].'</div>';	
		
		$sub_array[] = '<div class="btn-group" role="group"><button type="button" name="edit" id="edit" data-toggle="tooltip" data-placement="bottom" title="Make changes to this account" class="btn btn-success btn-divider-right edit-btn '. $edit .'">Edit</button><button type="button" data-toggle="tooltip" data-placement="bottom" title="Change active status of this account" class="btn btn-danger active-btn" name="active" id="active">'. $isActive .'</button></div></td>';
 		$data[] = $sub_array;
	}

	// send data back to table
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