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
	
	if(isset($_POST['quoteaction']))
	{
		$task = $_POST['quoteaction'];
		$invID = $_POST['invID'];
			include('sqlconnect.php');
			$query = "SELECT Status.QuoteValue
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
				      WHERE
			          Inventory.InventoryID = '$invID'";
			$result = $mysqli->query($query);
			if($result) list($invValue) = $result->fetch_row();
			else $msg = "Unable to update status of Inventory $invID" . mysqli_error($mysqli);

		switch($task)
		{
			
			
			case 'Accept Quote':
				$query = "INSERT INTO Status SET
						  InventoryID = '$invID',
						  QuoteValue = '$invValue',
						  StatusName = 'Accepted-Client',
						  StatusMessage = 'Quote Accepted by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else echo "Inventory Status NOT updated " . mysqli_error($mysqli);

				$query = "Update Inventory SET
							StatusID = '$statID'
							WHERE
							InventoryID = '$invID'";
				$result = $mysqli->query($query);
				if($result);
				else echo "Unable to submit inventory $invID " . mysqli_error($mysqli);
				break;
				
			case 'Decline Quote':
				$query = "INSERT INTO Status SET
						  InventoryID = '$invID',
						  QuoteValue = '$invValue',
						  StatusName = 'Declined-Client',
						  StatusMessage = 'Quote Declined by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else echo "Inventory Status NOT updated " . mysqli_error($mysqli);

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

	echo "<b>Comany Name: $userCompanyName</b><br>Welcome $userFName $userLName";
		//Temporary Form/Button to go to inventory page
?>
<!DOCTYPE html>
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

		  </div>
		<?php

	if(isset($_POST['takeaction']))
	{

		if(isset($_POST['invID'])) 	$invID = ($_POST['invID']); else $invID = NULL;

		include('sqlconnect.php');
		echo"<div class='content-area group section'>
		<div class='client_stats row'>";
		$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Status.QuoteValue
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
				      WHERE
			          Inventory.InventoryID = '$invID'";
			$result = $mysqli->query($query);
			if($result)
			{

				echo"
				<div class='col col-md-6'>
						<table id='assets'>
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
					</td></tr></table>";

				
				if($thisStatusName == "Started" || $thisStatusName == "Open")
				{
					
					echo "<form action='inventory.php' method='post'>
							<input type='hidden' name='inventoryID' value='$thisInvID'>
							<input type='submit' style='margin-left:70px;' class='inventory-button' name='updateinventory' value='Update Inventory'>
							</form></div>";
				}
				else
				{
					echo"<form action='clientLanding.php' method='post'>
						<input type='hidden' name='takeaction' value='Take Action'>
						<input type='hidden' name='invID' value='$thisInvID'>";
					if($thisStatusName == "Quote-Pending")
					{
						echo "<input type='submit' class='inventory-button' name='quoteaction' value='Accept Quote'>";
					}
					if(!(preg_match("/^.*Accepted.*$/",$thisStatusName) || preg_match("/^.*Declined.*$/",$thisStatusName)))
					echo "<input type='submit' class='inventory-button' name='quoteaction' value='Decline Quote'>
							</form></div>";
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
					  ORDER BY FIELD(STATUS.StatusName, 'Quoted-Pending','Open','Started','Accepted','Accepted-Client','Submitted','Declined','Declined-Client'), Status.StatusDate ASC
					  LIMIT 25";
			$result = $mysqli->query($query);
			if($result)
			{
				if($result->num_rows >=1)
				{
					//Column Split
					if(isset($_POST['takeaction'])){
					echo"<div id='client_inv' class='col col-md-6'>
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
							<input type='submit' onClick='changeClass()' class='inventory-button'name='takeaction' value='Take Action'>
							</form>
							</td></tr></div></div></div>";
					}
				}
				else{
					//Column full
					echo"<div id='client_inv' class='col col-md-12'>
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
							<input type='submit' onClick='changeClass()' class='inventory-button'name='takeaction' value='Take Action'>
							</form>
							</td></tr></div></div></div>";
					}
				}
			}
		}
			else echo"Inventory Lookup Error " . mysqli_error($mysqli);

	echo"</body>

</html>";

?>
