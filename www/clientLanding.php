<?php
	include('siteInit.php');
	include('menu.php');
	
	//functions
	//Function to format a number as dollars
	function asDollars($value) 
	{
		return '$' . number_format($value, 2);
	}

	if(!$loggedIn || $userType != 'Client')
	{
		echo "<script> location.href='selectLanding.php'; </script>";
	}
	
	echo "<b>$userCompanyName</b><br>Welcome $userFName $userLName";

	//Temporary Form/Button to go to inventory page
	echo"
		<html>
			<head>
				<meta charset='utf-8'>
				<title>Landing Page</title>
				<link rel='stylesheet' href='css/landing_style.css'>
			</head>
			<body>
				<div class='container1'>

				<a href='inventory.php' class='inventory-button'>Get a Quote</a>
				<a href='manageaccount.php' class='manage-account'>Manage Account</a>

		</div>";
		

	if(isset($_POST['takeaction']))
	{
		if(isset($_POST['invID'])) 	$invID = ($_POST['invID']); else $invID = NULL;
		
		include('sqlconnect.php');
		$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Status.QuoteValue
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
				      WHERE
			          Inventory.InventoryID = '$invID'";
			$result = $mysqli->query($query);
			if($result)
			{
				echo"
						<table width='1024' id='assets'>
						<tr>
						<th>Inventory ID</th>
						<th>Status</th>
						<th>Status Date</th>
						<th>Estimated Value</th>
						</tr>";
				list($thisInvID, $thisStatusName, $thisStatusDate, $thisStatusValue) = $result->fetch_row();
				$lowValue = asDollars(($thisStatusValue * ($userMult -.2)));
				$highValue = asDollars(($thisStatusValue * ($userMult)));
				if($thisStatusName == "Quoted-Pending") $thisStatusValue = asDollars(($thisStatusValue * $userMult));
				else $thisStatusValue = $lowValue . " - " . $highValue;
						
				echo"<tr><td>$thisInvID</td>
					<td>$thisStatusName</td>
					<td>$thisStatusDate</td>
					<td>$thisStatusValue</td>
					</td></tr>";
					
				if($thisStatusName = "Started" || $thisStatusName = "Open")
				{
					echo "<form action='inventory.php' method='post'>
					<input type='hidden' name='inventoryID' value='$thisInvID'>
					<input type='submit' name='updateinventory' value='Update Inventory'>
					</form>";
				}
			}
			else echo "Inventory NOT found " . mysqli_error($mysqli);
	}
	
	//Display all of the clients inventories
	include('sqlconnect.php');
	$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Status.QuoteValue
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
				      WHERE
			          Inventory.UserID = '$userID'
					  ORDER BY FIELD(STATUS.StatusName, 'Quoted-Pending','Open','Started','Submitted'), Status.StatusDate ASC
					  LIMIT 25";
			$result = $mysqli->query($query);
			if($result)
			{
				if($result->num_rows >=1)
				{
					echo"
						<table width='1024' id='assets'>
						<tr>
						<th>Inventory ID</th>
						<th>Status</th>
						<th>Status Date</th>
						<th>Estimated Value</th>
						<th>Take Action</th>
						</tr>";
					while(list($thisInvID, $thisStatusName, $thisStatusDate, $thisStatusValue) = $result->fetch_row())
					{
						$lowValue = asDollars(($thisStatusValue * ($userMult - .2)));
						$highValue = asDollars(($thisStatusValue * ($userMult)));
						if($thisStatusName == "Quoted-Pending") $thisStatusValue = asDollars(($thisStatusValue * $userMult));
						else $thisStatusValue = $lowValue . " - " . $highValue;
						
						echo"<tr><td>$thisInvID</td>
							<td>$thisStatusName</td>
							<td>$thisStatusDate</td>
							<td>$thisStatusValue</td>
							<td><form action='clientLanding.php' method='post'>
							<input type='hidden' name='invID' value='$thisInvID'>
							<input type='submit' name='takeaction' value='Take Action'>
							</form>
							</td></tr>";
					}
				}
			}
			else echo"Inventory Lookup Error " . mysqli_error($mysqli);
	
	echo"</body>

</html>";

?>
