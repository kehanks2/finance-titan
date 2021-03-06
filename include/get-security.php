<?php
include('config.php');

if (isset($_POST['username'])) {
	$data = array();
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	
	if (isset($_POST['answer'])) {
		$answer = mysqli_real_escape_string($db, $_POST['answer']);
		
		$query = 'SELECT Users.* FROM Users, Passwords WHERE Users.UserName ="'.$username.'" and Users.EmailAddress = "'.$email.'" and Users.PasswordID = Passwords.PasswordID and Passwords.SecurityAnswer = "'.$answer.'"';
		$result = mysqli_query($db, $query);
		
		if (mysqli_num_rows($result) == 0) {
			// not found, return error 2
			echo 2;
		} else {
			while ($row = mysqli_fetch_array($result)) {
				//found, return username/email for use with pw
				$data[0] = $row['UserName'];
				$data[1] = $row['EmailAddress'];
				
				echo json_encode($data);
			}
		}
	}
	
	else if (isset($_POST['password'])) {
		$password = mysqli_real_escape_string($db, $_POST['password']);
		
		$checkprev = "SELECT * FROM Passwords WHERE PasswordID = (SELECT Users.PasswordID FROM Users WHERE Users.UserName='$username')";
		$result = mysqli_query($db, $checkprev);
		while ($row = mysqli_fetch_array($result)) {
			if ($password == $row['CurrentPassword'] || $password == $row['PreviousPassword']) {
				echo 2;
			}
		}
		
		$query = "UPDATE Passwords SET PreviousPassword = CurrentPassword, CurrentPassword = '$password' WHERE PasswordID = (SELECT Users.PasswordID FROM Users WHERE Users.UserName='$username')";
		
		if (mysqli_query($db, $query)) {
			echo 0;
		} else {
			echo 1;
		}
	}
	
	else {
		// step 1: get security question for selected user
		$query = "SELECT Passwords.* FROM Passwords, Users WHERE Passwords.PasswordID = Users.PasswordID and Users.UserName = '$username' and Users.EmailAddress = '$email'";
		$result = mysqli_query($db, $query);
		if (mysqli_num_rows($result) == 0) {
			// not found, return error 1
			echo 1;
		} else {
			while ($row = mysqli_fetch_array($result)) {
				//found, return security question
				$data = $row['SecurityQuestion'];
				
				echo json_encode($data);
			}
		}
	}
}
else {
	// code error
	echo -1;
}


?>