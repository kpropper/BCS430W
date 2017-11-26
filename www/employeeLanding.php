<?php
	include('siteInit.php');
	include('menu.php');
	
	//functions
	//Function to format a number as dollars
	function asDollars($value) 
	{
		return '$' . number_format($value, 2);
	}
	
	echo "You made it to the Employee Landing Page <br>";

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

				<a href='inventory.php' class='inventory-button'>Inventory</a>



				<a href='#' class='new-quote'>Request New Quote</a>



				<a href='#' class='inventory-lookup'>Inventory Lookup</a>



				<a href='manageaccount.php' class='manage-account'>Manage Account</a>

		</div>";
		
	//Display all inventories
	include('sqlconnect.php');
	$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Inventory.Inventory_Value, Status.QuoteValue, User.Value_Multiplier
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
					  JOIN User ON Inventory.UserID = User.UserID";
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
						<th>Apprased Value</th>
						<th>Estimated Value</th>
						<th>Take Action</th>
						</tr>";
					while(list($thisInvID, $thisStatusName, $thisStatusDate, $thisInventoryValue, $thisStatusValue, $thisUserMult) = $result->fetch_row())
					{
						$lowValue = asDollars(($thisStatusValue * ($thisUserMult - .2)));
						$highValue = asDollars(($thisStatusValue * ($thisUserMult)));
						$thisStatusValue = $lowValue . " - " . $highValue;
						
						echo"<tr><td>$thisInvID</td>
							<td>$thisStatusName</td>
							<td>$thisStatusDate</td>
							<td>$thisInventoryValue</td>
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
			
	echo "</body>

</html>";
?>
