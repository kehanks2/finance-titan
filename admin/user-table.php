<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">Last Name</th>
				<th scope="col">First Name</th>
				<th scope="col">Username</th>
				<th scope="col">Email</th>
				<th scope="col">User Type</th>
				<th scope="col">Active?</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM Users";
				$result = mysqli_query($db, $query);

				if ($result) {
					while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
						echo "<tr><td>" . $row["FirstName"] . "</td>";
						echo "<td>" . $row["LastName"] . "</td>";
						echo "<td>" . $row["UserName"] . "</td>";
						echo "<td>" . $row["EmailAddress"] . "</td>";
						if ($row['UserType'] != "Inactive") {
							echo "<td>" . $row["UserType"] . "</td><td>Yes</td>";
						} else {
							echo "<td>--</td><td>No</td>";
						}
						echo "</tr>";
					}
				}			
			?>
		</tbody>
	</table>
</div>