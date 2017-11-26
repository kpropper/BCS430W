<?php
	include('siteInit.php');
	include('menu.php');
	include('sqlconnect.php');
	

	if(!$loggedIn || $userType != 'Employee')
	{
		echo "<script> location.href='selectLanding.php'; </script>";
	}
	
	$query = "SELECT UserID, FName, LName, Email, Company_Name, Telephone, UserType, Value_Multiplier
				FROM User";

			$result = $mysqli->query($query);
			if($result)
			{
				if($result->num_rows >=1)
				{
					echo"
						<table width='1024' id='assets'>
						<tr>
						<th>User ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Company Name</th>
						<th>Telephone</th>
						<th>User Type</th>
						<th>Value Multiplier</th>
						<th>Update User</th>
						</tr>";
					while(list($thisUserID, $thisFirstName, $thisLastName, $thisEmail, $thisCompanyName, $thisTelephone, $thisUserType, $thisUserMult) = $result->fetch_row())
					{
						echo"<tr><td>$thisUserID</td>
							<td>$thisFirstName</td>
							<td>$thisLastName</td>
							<td>$thisEmail</td>
							<td>$thisCompanyName</td>
							<td>$thisTelephone</td>
							<td>$thisUserType</td>
							<td>$thisUserMult</td>
							<td><form action='employeemanageaccount.php' method='post'>
							<input type='hidden' name='userUserID' value='$thisUserID'>
							<input type='submit' name='updateuser' value='Update User'>
							</form>
							</td></tr>";
					}
				}
				else echo "<b>No Results Found<b>";
			}
			else echo"Inventory Lookup Error " . mysqli_error($mysqli);
			
	echo "</body>

</html>";
?>