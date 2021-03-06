<?php
//fetch.php
	include("../include/config.php");
	$columns = array('UserName', 'LastName', 'FirstName', 'BirthDate', 'EmailAddress', 'UserType');

	$query = "SELECT * FROM Users ";

	if(isset($_POST["search"]["value"])) {
 		$query .= '
 			WHERE FirstName LIKE "%'.$_POST["search"]["value"].'%" 
 			OR LastName LIKE "%'.$_POST["search"]["value"].'%" 
 			OR UserName LIKE "%'.$_POST["search"]["value"].'%"
 			OR EmailAddress LIKE "%'.$_POST["search"]["value"].'%"
 			OR UserType LIKE "%'.$_POST["search"]["value"].'%"
 			';
	}

	if(isset($_POST["order"])) {
 		$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 		';
	} else {
 		$query .= 'ORDER BY UserID ASC ';
	}

	$query1 = '';

	if($_POST["length"] != -1) {
 		$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$number_filter_row = mysqli_num_rows(mysqli_query($db, $query));

	$result = mysqli_query($db, $query . $query1);

	$data = array();

	while($row = mysqli_fetch_array($result)) {
		$ut = array('', '', '');
		if ($row['UserType'] == 'admin') {
			$ut[0] = 'admin';
			$ut[1] = 'accountant';
			$ut[2] = 'manager';
		} else if ($row['UserType'] == 'accountant') {
			$ut[0] = 'accountant';
			$ut[1] = 'manager';
			$ut[2] = 'admin';
		} else if ($row['UserType'] == 'manager') {
			$ut[0] = 'manager';
			$ut[1] = 'accountant';
			$ut[2] = 'admin';
		} else {
			$ut[0] = 'accountant';
			$ut[1] = 'manager';
			$ut[2] = 'admin';
		}
		
		$isActive = "";
		if ($row["IsActive"] == 1) {
			$isActive = "Active";
			$edit = "";
			$modal = 'data-toggle="modal" data-target="#active-modal"';
		} else if ($row["IsActive"] == 0) {
			$isActive = "Inactive";
			$edit = "disabled";
			$modal = '';
		}
		
 		$sub_array = array();
 		$sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["UserID"].'" data-column="UserName">'. $row["UserName"].'</div>';
		
 		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["UserID"].'" data-column="LastName">'. $row["LastName"].'</div>';
		
 		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["UserID"].'" data-column="FirstName">'. $row["FirstName"].'</div>';
		
		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["UserID"].'" data-column="BirthDate">'. $row["BirthDate"].'</div>';
		
 		$sub_array[] = '<div contenteditable="false" class="update edt" data-id="'.$row["UserID"].'" data-column="EmailAddress">'. $row["EmailAddress"] .'</div>';
		
 		$sub_array[] = '<div class="update" data-id="'.$row["UserID"].'" data-column="UserType"><select id="user-type" disabled><option id="'.$ut[0].'">'.$ut[0].'</option><option id="'.$ut[1].'">'.$ut[1].'</option><option id="'.$ut[2].'">'.$ut[2].'</option></select></div>';
		
		$sub_array[] = '<div class="btn-group" role="group"><button type="button" name="edit" id="edit" data-toggle="tooltip" data-placement="bottom" title="Make changes to this account" class="btn btn-success btn-divider-right edit-btn '. $edit .'">Edit</button><button type="button" '. $modal .' class="btn btn-danger active-btn" name="active" id="active" data-id="'.$row["UserID"].'">'. $isActive .'</button></div></td>';
		
 		$data[] = $sub_array;
	}

	function get_all_data($db) {
 		$query = "SELECT * FROM Users";
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