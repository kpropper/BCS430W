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
	$task = NULL;

	if(isset($_POST['category']))		$searchcat = ($_POST['category']); else $searchcat  = NULL;
	if(isset($_POST['searchitem']))		$searchitem = ($_POST['searchitem']); else $searchitem  = NULL;
	$searchitem = trim($searchitem);

	echo "<b>$userFName $userLName<b>";

	//Temporary Form/Button to go to inventory page
	echo"
		<html>
			<head>
				<meta charset='utf-8'>
				<title>Landing Page</title>
				<link rel='stylesheet' href='css/landing_style.css'>
			</head>
			<body>
      <div class='content-area group section'>
				    <div class='container1 row'>
				        <a href='viewusers.php' class='manage-account'>Manage Accounts</a>
          </div>";


	//Complete Task on the selected Inventoy
	if(isset($_POST['task']))
	{
		$task = $_POST['task'];
		
		$invID = $_POST['invID'];
		$invValue = $_POST['statusValue'];
		
		$query = "SELECT UserID FROM Inventory WHERE InventoryID = '$invID'";
			$result = $mysqli->query($query);
			if($result)
			{
				list($usersID) = $result->fetch_row();
				$query = "SELECT FName,
								 LName,
								 Company_Name,
								 Email
								 FROM User WHERE 
								 UserID = '$usersID'";
				$result = $mysqli->query($query);
				if($result)
				{
					list($usersFName, $usersLName, $usersCompany_Name, $usersEMail)= $result->fetch_row();
				}
			}

		switch($task)
		{				  
			case 'Open':
				$query = "INSERT INTO Status SET
						  InventoryID = '$invID',
						  QuoteValue = '$invValue',
						  StatusName = 'Open',
						  StatusMessage = 'Inventory opened by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else echo "[$invValue] Inventory Status NOT updated " . mysqli_error($mysqli);
				
				
				$subject = "ITAMG Status Update";
				$body = "Hello $usersFName $usersLName. Your inventory $invID has been opened. Please feel free to edit the inventory.";		
				break;
			case 'Quote':
				$query = "INSERT INTO Status SET
						  InventoryID = '$invID',
						  QuoteValue = '$invValue',
						  StatusName = 'Quote-Pending',
						  StatusMessage = 'Inventory quoted opened by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else {
					$statID = NULL;
					echo "[$invValue] Inventory Status NOT updated " . mysqli_error($mysqli);
				}
				
				$subject = "ITAMG Status Update";
				$body = "Hello $usersFName $usersLName. Your inventory $invID has been Quoted. Please review the quote and proceed appropriatly.";
				break;
			case 'Accept Quote':
				$query = "INSERT INTO Status SET
					InventoryID = '$invID',
					QuoteValue = '$invValue',
					StatusName = 'Accepted',
					StatusMessage = 'Inventory quote accepted by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else {
					$statID = NULL;
					echo "[$invValue] Inventory Status NOT updated " . mysqli_error($mysqli);
				}	 

				$subject = "ITAMG Status Update";
				$body = "Hello $usersFName $usersLName. Your inventory $invID has been Accepted. Thank You for doing bussiness with us.";
				break;
			case 'Decline Quote':
				$query = "INSERT INTO Status SET
							InventoryID = '$invID',
							QuoteValue = '$invValue',
							StatusName = 'Declined',
							StatusMessage = 'Inventory quote declined by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else 
				{
					$statID = NULL;
					echo "[$invValue] Inventory Status NOT updated " . mysqli_error($mysqli);
				}
				$subject = "ITAMG Status Update";
				$body = "Hello $usersFName $usersLName. Your inventory $invID has been Declined. We are unable to purchase your equipment at this time. Thank You for doing bussiness with us.";
				break;
			case 'Override Quote Process':

				$newValue = $_POST['overridevalue'];
				$oldStatusName = $_POST['oldstatusname'];

				$query = "INSERT INTO Status SET
						InventoryID = '$invID',
						QuoteValue = '$newValue',
						StatusName = '$oldStatusName',
						StatusMessage = 'Inventory quote was overridden by $userFName $userLName'";
				$result = $mysqli->query($query);
				if($result) $statID = $mysqli->insert_id;
				else 
				{
					$statID = NULL;
					echo "[$invValue] Inventory Status NOT updated " . mysqli_error($mysqli);
				}
				$subject = "ITAMG Status Update";
				$body = "Hello $usersFName $usersLName. Your inventory $invID has been updated. Please review the updated information.";
				break;	
			default:
		}
		
		if($task != NULL && $task !="Override Quote Display")
		{
		if ($task == 'Accept Quote')
		{
			$query = "Update Inventory SET
              StatusID = '$statID',
			  FinalQuote = '$invValue'
              WHERE
              InventoryID = '$invID'";
		}
		else
		{
			$query = "Update Inventory SET
              StatusID = '$statID'
              WHERE
              InventoryID = '$invID'";
		}	
        $result = $mysqli->query($query);
        if($result)
		{
			include('sendmail.php');
			sendmail($usersEMail,$subject,$body);
		}
        else echo "Unable to submit inventory $invID " . mysqli_error($mysqli);
		}
	}
	//Show Selected Inventory
	if(isset($_POST['takeaction']))
	{
		//Variables
		$value = NULL;
		if(isset($_POST['invID'])) 	$invID = ($_POST['invID']); else $invID = NULL;
    $query = "SELECT StatusID, StatusName, StatusDate, QuoteValue, StatusMessage
          FROM Status
        WHERE InventoryID = '$invID'
        ORDER BY StatusDate ASC";
          $result = $mysqli->query($query);
    if($result)
    {
      ?>
    <div class="row">
        <table width='1024' id='assets'>
        <tr>
        <th>Status Date ID</th>
        <th>Status</th>
        <th>Quoted Value</th>
        <th>Message</th>
        </tr>
        <h1>History</h1>
        <?php

      while(list($thisstatID, $thisstatname, $thisstatdate, $thisquotevalue, $thisstatmessage) = $result->fetch_row())
      {

        $statusValue = asDollars($thisquotevalue);
        echo"
        <tr><td>$thisstatdate</td>
          <td>$thisstatname</td>
          <td>$statusValue</td>
          <td>$thisstatmessage</td>
          </td></tr>";
      }
      echo"</table>
      </div>";
    }
    else "Status History NOT found " . mysqli_error($mysqli);

		$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Status.QuoteValue, User.Value_Multiplier, User.FName, User.LName, User.Company_Name
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
					  JOIN User ON Inventory.UserID = User.UserID
				      WHERE
			          Inventory.InventoryID = '$invID'";
			$result = $mysqli->query($query);
			if($result)
			{
				echo"
        <div class='row'>

						<table width='1024' id='assets'>
						<tr>
						<th>Inventory ID</th>
						<th>Company</th>
						<th>User</th>
						<th>Status</th>
						<th>Status Date</th>
						<th>Estimated Value</th>
						</tr>";
				list($thisInvID, $thisStatusName, $thisStatusDate, $thisStatusValue, $thisValueMult, $userFName, $userLName, $userCompanyName) = $result->fetch_row();
				$lowValue = asDollars(($thisStatusValue * ($thisValueMult -.2)));
				$highValue = asDollars(($thisStatusValue * ($thisValueMult)));
				$thisValue = $lowValue . " - " . $highValue;
				$value = $thisStatusValue;
				$fullName = $userLName . ", " . $userFName;


				echo"<tr><td>$thisInvID</td>
					<td>$userCompanyName</td>
					<td>$fullName</td>
					<td>$thisStatusName</td>
					<td>$thisStatusDate</td>
					<td>$thisValue</td>
					</td></tr></table>

          </div>";


				if(($thisStatusName == "Started") || ($thisStatusName == "Open"))
				{
					echo "<form action='inventory.php' style='display:inline;' method='post'>
						<input type='hidden' name='inventoryID' value='$thisInvID'>
						<input type='submit'class='inventory-button' style='margin-left:20px;' name='updateinventory' value='Update Inventory'>
						</form>";
				}
				else
				{
					echo"<form action='employeeLanding.php'  style='display:inline;' method='post'>
							<input type='hidden' name='invID' value='$thisInvID'>
							<input type='hidden' name='statusValue' value='$thisStatusValue'>
							<input type='hidden' name='oldstatusname' value='$thisStatusName'>
							<input type='hidden' name='takeaction' value='Take Action'>
							<input type='submit'class='inventory-button' style='margin-left:5px;' name='task' value='Open'>";
							if($thisStatusName == "Submitted")
							{
								echo"<input type='submit'class='inventory-button' style='margin-left:5px;' name='task' value='Quote'>";
							}
							elseif($thisStatusName == "Accepted-Client")
							{
								echo "<input type='submit'class='inventory-button' style='margin-left:5px;' name='task' value='Accept Quote'>";
							}
							if(!($thisStatusName == 'Accepted' || preg_match("/^.*Declined.*$/",$thisStatusName)))
							{
								echo "<input type='submit'class='inventory-button' style='margin-left:5px;' name='task' value='Decline Quote'>";
									if(!(preg_match("/^.*Accepted.*$/",$thisStatusName)))
									{
										echo "<input type='submit'class='inventory-button' style='margin-left:5px;' name='task' value='Override Quote Display'>";
										if($task == "Override Quote Display")
										{
											echo "<label for='OverrideQuote'>Process Override</label>
												<input type='number' step='any' name='overridevalue'>
												<input type='submit'class='inventory-button' style='margin-left:5px;' name='task' value='Override Quote Process'>";
										}
									}
							}
					echo "</form>";
				}	
			}
			else echo "Inventory NOT found " . mysqli_error($mysqli);
	}


	//Inventory Search Buttons
	echo "<div id='manage_requests'>
				<h1>Manage Requests</h1>";
	echo "<form action='employeeLanding.php' method='post'>
					<b>Search: <b><select class='search_drop' name='category'>";
	foreach ($categories as $cat)
	{
		//if ($cat == $category) $se = "SELECTED"; else $se = NULL;
		echo "<option $se>$cat</option>";
	}
	echo "</select>
		  <input type='text' class='search_drop' name='searchitem'>
		  <input type='submit' class='inventory-button' name='searchinventory' value='Search Inventory'>
		  </form>";
	echo "</div'>";

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

		$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Inventory.Inventory_Value, Status.QuoteValue, User.Value_Multiplier, User.FName, User.LName, User.Company_Name
				      FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
					  JOIN User ON Inventory.UserID = User.UserID
					  WHERE $querycat = '$searchitem'
					  ORDER BY FIELD(STATUS.StatusName,'Accepted-Client','Submitted','Open','Started', 'Quote-Pending','Accepted', 'Declined'), Status.StatusDate ASC
					  LIMIT 25";
	}
	else
	{

	$query = "SELECT Inventory.InventoryID, Status.StatusName, Status.StatusDate, Inventory.Inventory_Value, Status.QuoteValue, User.Value_Multiplier, User.FName, User.LName, User.Company_Name
				FROM Inventory JOIN Status ON Inventory.StatusID = Status.StatusID
				JOIN User ON Inventory.UserID = User.UserID
				ORDER BY FIELD(STATUS.StatusName, 'Accepted-Client','Submitted','Open','Started', 'Quote-Pending','Accepted', 'Declined'), Status.StatusDate ASC
				LIMIT 25";
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
						<th>Company</th>
						<th>User</th>
						<th>Status</th>
						<th>Status Date</th>
						<th>Appraised Value</th>
						<th>Estimated Value</th>
						<th>Take Action</th>
						</tr>";
					while(list($thisInvID, $thisStatusName, $thisStatusDate, $thisInventoryValue, $thisStatusValue, $thisUserMult, $userFName, $userLName, $userCompanyName) = $result->fetch_row())
					{
						$lowValue = asDollars(($thisStatusValue * ($thisUserMult - .2)));
						$highValue = asDollars(($thisStatusValue * ($thisUserMult)));
						$thisStatusValue = $lowValue . " - " . $highValue;
						$fullName = $userLName . ", " . $userFName;


						echo"<tr><td>$thisInvID</td>
							<td>$userCompanyName</td>
							<td>$fullName</td>
							<td>$thisStatusName</td>
							<td>$thisStatusDate</td>
							<td>$thisInventoryValue</td>
							<td>$thisStatusValue</td>
							<td><form action='employeeLanding.php' method='post'>
							<input type='hidden' name='invID' value='$thisInvID'>
							<input type='hidden' name='statusValue' value='$thisStatusValue'>
							<input type='submit' class='inventory-button' name='takeaction' value='Take Action'>
							</form>
							</td></tr>";
					}
          echo"</table>";
				}
				else echo "<b>No Results Found<b>";
			}
			else echo"Inventory Lookup Error " . mysqli_error($mysqli);

	echo "</body>

</html>";
?>
