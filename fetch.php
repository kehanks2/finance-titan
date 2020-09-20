<?php
//fetch.php
	include("config.php");
	$columns = array('LastName', 'FirstName', 'UserName', 'EmailAddress', 'UserType');

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
 		$query .= 'ORDER BY UserID DESC ';
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
 		$sub_array[] = '<div contenteditable class="update" data-id="'.$row["UserID"].'" data-column="UserName">' . $row["UserName"] . '</div>';
 		$sub_array[] = '<div contenteditable class="update" data-id="'.$row["UserID"].'" data-column="LastName">' . $row["LastName"] . '</div>';
 		$sub_array[] = '<div contenteditable class="update" data-id="'.$row["UserID"].'" data-column="FirstName">' . $row["FirstName"] . '</div>';
 		$sub_array[] = '<div contenteditable class="update" data-id="'.$row["UserID"].'" data-column="EmailAddress">' . $row["EmailAddress"] . '</div>';
 		$sub_array[] = '<div contenteditable class="update" data-id="'.$row["UserID"].'" data-column="UserType">' . $row["UserType"] . '</div>';
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