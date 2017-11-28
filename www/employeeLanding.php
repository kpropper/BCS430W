<?php
	include('siteInit.php');
	include('menu.php');
	include('sqlconnect.php');
	
	//functions
	//Function to format a number as dollars
	function asDollars($value) 
	{
		return '$' . number_format($value, 2);
	}
	
	if(!$loggedIn || $userType != 'Employee')
	{
		echo "<script> location.href='selectLanding.php'; </script>";
	}
	
	$categories	= array("Inventory ID", "Customer Last Name", "Customer Email", "Company Name", "Show All");
	$se = NULL;
	
	if(isset($_POST['category']))		$searchcat = ($_POST['category']); else $searchcat  = NULL;
	if(isset($_POST['searchitem']))		$searchitem = ($_POST['searchitem']); else $searchitem  = NULL;
	$searchitem = trim($searchitem);
	
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



				<a href='viewusers.php' class='manage-account'>Manage Accounts</a>

		</div>";
		
	//Complete Task on the selected Inventoy
	if(isset($_POST['task']))
	{
		$task = $_POST['task'];
		
		switch($task)
		{
			case 'Open':
				$invID = $_POST['inventoryID'];
				$invValue = $_POST['statusValue'];
				
				$query = "INSERT INTO Status SET
						  InventoryID = '$invID',
						  QuoteValue = '$invValue',
						  StatusName = 'Open',
						  StatusMessage = 'Inventory opened by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else echo "[$invValue] Inventory Status NOT updated " . mysqli_error($mysqli);
				
				$query = "Update Inventory SET
							StatusID = '$statID'
							WHERE
							InventoryID = '$invID'";
				$result = $mysqli->query($query);
				if($result);
				else echo "Unable to submit inventory $invID " . mysqli_error($mysqli);
				break;
			default:
		}
	}
	//Show Selected Inventory
	if(isset($_POST['takeaction']))
	{
		//Variables
		$value = NULL;
		
		if(isset($_POST['invID'])) 	$invID = ($_POST['invID']); else $invID = NULL;
		
		$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Status.QuoteValue, User.Value_Multiplier
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
					  JOIN User ON Inventory.UserID = User.UserID
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
				list($thisInvID, $thisStatusName, $thisStatusDate, $thisStatusValue, $thisValueMult) = $result->fetch_row();
				$lowValue = asDollars(($thisStatusValue * ($thisValueMult -.2)));
				$highValue = asDollars(($thisStatusValue * ($thisValueMult)));
				$thisValue = $lowValue . " - " . $highValue;
				$value = $thisStatusValue;
						
				echo"<tr><td>$thisInvID</td>
					<td>$thisStatusName</td>
					<td>$thisStatusDate</td>
					<td>$thisValue</td>
					</td></tr>";
					
				$query = "SELECT StatusID, StatusName, StatusDate, QuoteValue, StatusMessage
				      FROM Status
					  WHERE InventoryID = '$invID'
					  ORDER BY StatusDate ASC";
							$result = $mysqli->query($query);
				if($result)
				{
					echo"<b>History<b>
						<table width='1024' id='assets'>
						<tr>
						<th>Status Date ID</th>
						<th>Status</th>
						<th>Quoted Value</th>
						<th>Message</th>
						</tr>";
						
					while(list($thisstatID, $thisstatname, $thisstatdate, $thisquotevalue, $thisstatmessage) = $result->fetch_row())
					{		
						$statusValue = asDollars($thisquotevalue);
						echo"<tr><td>$thisstatdate</td>
							<td>$thisstatname</td>
							<td>$statusValue</td>
							<td>$thisstatmessage</td>
							</td></tr>";
					}
				}
				else "Status History NOT found " . mysqli_error($mysqli);
					
				if($thisStatusName = "Started" || $thisStatusName = "Open")
				{
					echo "<tr><td><form action='inventory.php' method='post'>
					<input type='hidden' name='inventoryID' value='$thisInvID'>
					<input type='submit' name='updateinventory' value='Update Inventory'>
					</form></td>
					<td><form action='employeeLanding.php' method='post'>
					<input type='hidden' name='inventoryID' value='$thisInvID'>
					<input type='hidden' name='statusValue' value='$thisStatusValue'>
					<input type='submit' name='task' value='Open'>
					</form></td></tr>";
				}
			}
			else echo "Inventory NOT found " . mysqli_error($mysqli);
	}
	
	
	//Inventory Search Buttons
	echo "<form action='employeeLanding.php' method='post'>
					<b>Search: <b><select name='category'>";
	foreach ($categories as $cat) 
	{
		//if ($cat == $category) $se = "SELECTED"; else $se = NULL;
		echo "<option $se>$cat</option>";
	}
	echo "</select>
		  <input type='text' name='searchitem'>
		  <input type='submit' name='searchinventory' value='Search Inventory'>
		  </form>";
					
	//Display all inventories
	if(isset($_POST['searchinventory']) && ($searchcat != "Show All"))
	{
		
		switch($searchcat)
		{
			case 'Inventory ID':
				$querycat = 'Inventory.InventoryID';
				break;
			case 'Customer Last Name':
				$querycat = 'User.LName';
				break;
			case 'Customer Email':
				$querycat = 'User.Email';
				break;
			case 'Company Name':
				$querycat = 'User.Company_Name';
				break;
			default:
				$querycat = NULL;
		}
		
		$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Inventory.Inventory_Value, Status.QuoteValue, User.Value_Multiplier
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
					  JOIN User ON Inventory.UserID = User.UserID
					  WHERE $querycat = '$searchitem'";
	}
	else
	{
	$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Inventory.Inventory_Value, Status.QuoteValue, User.Value_Multiplier
				FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
				JOIN User ON Inventory.UserID = User.UserID";
	}

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
							<td><form action='employeeLanding.php' method='post'>
							<input type='hidden' name='invID' value='$thisInvID'>
							<input type='submit' name='takeaction' value='Take Action'>
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
