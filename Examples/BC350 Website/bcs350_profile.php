<?php
// bcs350_profile.php - Roster Update Program
// Written by: Charles Kaplan, May 2015

// Verify that program was called from bcs350_php and Student or Faculty Logon
  require('bcs350_landing.php');
  require('bcs350_student.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');
	
// Variables
  $task = "first";
  $pgm = "bcs350.php?p=profile";
  $table = "roster";
  $title = "BCS350 Roster Update";
  $msg = NULL;
  $msg_color = "black";
  $roles = array("Student", "Faculty", "Administration");
  $stats = array(1,0);

// Get Task Input    
  if (isset($_POST['task']))	$task = strtolower($_POST['task']); 
  if (isset($_GET['r']))		$r = $_GET['r'];			else $r = NULL; 
  if ($srole == "Student")		{$r = $sstudent; $readonly = "READONLY "; $disabled = "DISABLED ";} 	
    else {$readonly = NULL; $disabled = NULL;}
  
// Get Field Input  
  if (isset($_POST['rowid']))		$rowid 		= trim($_POST['rowid']);		else $rowid 	= NULL;
  if (isset($_POST['firstname']))	$firstname	= trim($_POST['firstname']);	else $firstname = NULL;
  if (isset($_POST['lastname']))	$lastname	= trim($_POST['lastname']);		else $lastname 	= NULL;
  if (isset($_POST['ramid']))		$ramid		= trim($_POST['ramid']);		else $ramid		= NULL;
  if (isset($_POST['email']))		$email		= trim($_POST['email']);		else $email		= NULL;
  if (isset($_POST['role']))		$role		= trim($_POST['role']);			else $role		= NULL;
  if (isset($_POST['userid']))		$userid		= trim($_POST['userid']);		else $userid	= NULL;
  if (isset($_POST['password']))	$password	= trim($_POST['password']);		else $password	= NULL;
  if (isset($_POST['status']))		$status		= trim($_POST['status']);		else $status 	= NULL;
  if ($status == "Active") 			$status 	= 1; 							else $status	= 0;   
  if (isset($_POST['last']))		$last		= $_POST['last']; 				else $last 		= NULL;
	
  if (($r != NULL) AND ($task == "first")) {
	$rowid = $r;
	$task = "show";
	}

// Verify Input
//  if (($task != "first") AND ($task != "clear"))
//	include('roster_verify_input.php');
	
// Process Task
  if ($msg != NULL)
	$msg_color = "red";
	else
  switch($task) {
  
  case "first":  
    $msg = "Enter Information"; 
	break;

  case "clear":
    $rowid = $firstname = $lastname = $ramid = $email = $role = $userid = $password = $status = $last = NULL;
	$msg = "Screen cleared";
	break;

  case "previous record":
  case "next record":
  case "show":
    if ($task == "previous record") $rowid = $rowid - 1;
	if ($task == "next record") 	$rowid = $rowid + 1;
	if($rowid < 1) {$msg = "To SHOW a record, enter a ROWID"; break;}
	$query = "SELECT firstname, lastname, ramid, email, role, userid, password, status
			  FROM $table
			  WHERE rowid='$rowid'";
	$result = $mysqli->query($query);
	if (($result->num_rows) < 1) {
	  $msg = "ROWID $rowid not found. " . $mysqli->error;
	  $msg_color = "red";
	  $firstname = $lastname = $ramid = $email = $role = $userid = $password = $status = $last = NULL;
	  }
	  else {	
		list($firstname, $lastname, $ramid, $email, $role, $userid, $password, $status) = $result->fetch_row(); 
		$role 		= ucwords($role);
		$msg        = "Row $rowid found";
		$last       = $rowid;
		}
    break;
  
  case "change":
    if ($rowid != $last) {
	  $msg = "Show row before updating, ROWID [$rowid], LAST [$last]";
	  $msg_color = "red";
	  break; 
	  }
	  
	if ($srole == "Student") { 
	  $query = "UPDATE $table SET
			  email			= '$email',
			  password		= '$password'
			  WHERE rowid='$rowid'";
	  if (isset($_POST['role2'])) $role = trim($_POST['role2']);
	  if (isset($_POST['status2'])) $status = trim($_POST['status2']);
	}
      else $query = "UPDATE $table SET
			  firstname		= '$firstname',
			  lastname		= '$lastname',
			  ramid			= '$ramid',
			  email			= '$email',
			  role			= '$role',
			  userid		= '$userid',
			  password		= '$password',
			  status		= '$status'
			  WHERE rowid='$rowid'";
	$result = $mysqli->query($query);			  
	if ($mysqli->error != NULL) {
	  $msg = "ROWID $rowid not updated, " . $mysqli->error;
	  $msg_color = "red";
	  }
	  else {			  
		$msg = "ROWID $rowid updated";
		}
	break;
 
  case "delete":
    if ($rowid != $last) {
	  $msg = "Show ROWID before deleting";
	  $msg_color = "red";  
	  break; 
	  }
	$query = "DELETE FROM $table WHERE rowid='$rowid'";
	$result = $mysqli->query($query);
	if ($mysqli->error != NULL) {
	  $msg = "ROWID $rowid not deleted, " . $mysqli->error;
	  $msg_color = "red";
	  }
	  else {
	    $last = NULL;
		$msg = "ROWID $rowid deleted";
		}
  break;
  
  case "add":
    $query = "INSERT INTO $table SET
			  firstname		= '$firstname',
			  lastname		= '$lastname',
			  ramid			= '$ramid',
			  email			= '$email',
			  role			= '$role',
			  userid		= '$userid',
			  password		= '$password',
			  status		= '$status'";
	$result = $mysqli->query($query);			  
	if ($mysqli->error != NULL) {
	  $msg = "ROWID not added, " . $mysqli->error;
	  $msg_color = "red";
	  }
	  else {			  
		$rowid = $mysqli->insert_id;
		$last = $rowid;
		$msg = "ROWID $rowid added";
		}
	break;
    
  default:  break; 
  }

// Output Page  
  echo "<script>
		  function ConfirmDelete() {
			var x = confirm('Are you sure you want to delete?');
			if (x) return true;
			  else return false;
		  }
		</script>";
		
  echo "<form action='$pgm' method='post'>
		<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td align='center'><b>$title</b></td></tr>
		</table>
		<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>	
		<tr><td>ROWID</td><td><input type='text' name='rowid' size='5' maxlength='5' value='$rowid' $readonly>
				<input type='hidden' name='last' value='$last'></td></tr>
		<tr><td>First Name</td><td><input type='text' name='firstname' size='25' maxlength='25' value='$firstname' $readonly></td></tr>
		<tr><td>Last Name</td> <td><input type='text' name='lastname'  size='25' maxlength='25' value='$lastname' $readonly></td></tr>
		<tr><td>Ram ID</td>    <td><input type='text' name='ramid'     size='15' maxlength='13' value='$ramid' $readonly></td></tr>
		<tr><td>Email</td>     <td><input type='text' name='email'     size='80' maxlength='80' value='$email'> *Student Can Update</td></tr>
		<tr><td>User ID</td>   <td><input type='text' name='userid'    size='20' maxlength='20' value='$userid' $readonly></td></tr>
		<tr><td>Password</td>  <td><input type='text' name='password'  size='80' maxlength='80' value='$password'> *Student Can Update</td></tr>		
		<tr><td>Status</td>    <td><select name='status' $disabled>";
  foreach($stats as $stat) {
	if ($stat == $status)
	  $se = "SELECTED";
	  else $se = NULL;
	if ($stat)	$stat2 = "Active"; else $stat2 = "Inactive";
	echo "<option $se>$stat2</option>";
	}
  echo "</select>
		<input type='hidden' name='status2' value='$status'></td></tr>
		<tr><td>Role</td>  	   <td><select name='role' $disabled><option>&nbsp;</option>";
  foreach($roles as $rol) {
	if ($rol == $role)
	  $se = "SELECTED";
	  else $se = NULL;
	echo "<option $se>$rol</option>";
	}
  echo "</select>
		<input type='hidden' name='role2' value='$role'>
		</td></tr>
		</table>";
		
  echo "<table align='center' width='$width' bgcolor='white' cellspacing='10' class='text'>
		<tr><td>
		<table align='center'><tr>
		<td><input type='submit' name='task'  value='Show'   style='background-color:lightgreen;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Add'    style='background-color:lightblue;font-weight:bold' $disabled></td>
		<td><input type='submit' name='task'  value='Change' style='background-color:yellow;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Delete' style='background-color:red;font-weight:bold' Onclick='return ConfirmDelete();' $disabled></td>
		<td><input type='submit' name='task'  value='Clear'  style='background-color:white;font-weight:bold' $disabled></td>
		<td>&nbsp;</td>
		<td><input type='submit' name='task'  value='Previous Record' style='background-color:lightgray;font-weight:bold' $disabled></td>
		<td><input type='submit' name='task'  value='Next Record' style='background-color:orange;font-weight:bold' $disabled></td>
		</tr></table>
		</td></tr></table>
		</form>";

  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'><tr><td><b>Message</b>: <font color='$msg_color'>$msg</font></td></tr></table>";		

?>