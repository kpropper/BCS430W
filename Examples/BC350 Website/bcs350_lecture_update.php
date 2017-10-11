<?php
// bcs350_lecture_update.php - Lecture Update Program
// Written by: Charles Kaplan, June 2015

// Verify that program was called from bcs350_php and Faculty User
  require('bcs350_landing.php');
  require('bcs350_faculty.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');
	
// Variables
  $task = "first";
  $pgm = "bcs350.php?p=lecture_update";
  $table = "lectures";
  $title2 = "BCS350 Lectures Update";
  $msg = NULL;
  $msg_color = "black";

// Get Task Input    
  if (isset($_POST['task']))	$task = strtolower($_POST['task']);
  if (isset($_GET['r']))		$r = $_GET['r'];			else $r = NULL;
  
// Get Field Input  
  if (isset($_POST['rowid']))		$rowid 		= trim($_POST['rowid']);		else $rowid 	= NULL;
  if (isset($_POST['lecture']))		$lecture	= trim($_POST['lecture']);		else $lecture 	= NULL;
  if (isset($_POST['title']))		$title		= trim($_POST['title']);		else $title 	= NULL;
  if (isset($_POST['hfile']))		$file		= trim($_POST['hfile']);		else $file		= NULL;
  if (isset($_POST['last']))		$last		= $_POST['last']; 				else $last 		= NULL;
	
  if ($r != NULL) {
	$rowid = $r;
	$task = "show";
	}

// Verify Input
//  if (($task != "first") AND ($task != "clear"))
//	include('roster_verify_input.php');

// Upload Lecture
  if (isset($_FILES['file']['name']) AND ($_FILES['file']['name'] != NULL)) {
    $var = "file";
    $dir = "lectures/";
    $ext = array(".txt", ".doc", ".docx", ".jpg", ".gif", ".png", ".pdf", ".xls", ".xlsx", ".ppt", ".pptx", ".php", ".html", ".css", ".js");
	sort($ext);
    $fn = "original";
	$max = 10000000;
    list($err_code, $err_msg) = upload($var, $dir, $ext, $fn, $max);
	if ($err_code == 0) 
	  $file = $err_msg;
	  else {$msg = "Error Code = $err_code: $err_msg"; $msg_color = "red";}
	}
	
// Process Task
  if ($msg != NULL)
	$msg_color = "red";
	else
  switch($task) {
  
  case "first":  
    $msg = "Enter Information"; 
	break;

  case "clear":
    $rowid = $lecture = $title = $file = $last = NULL;
	$msg = "Screen cleared";
	break;

  case "previous record":
  case "next record":
  case "show":
    if ($task == "previous record") $rowid = $rowid - 1;
	if ($task == "next record") 	$rowid = $rowid + 1;
	if($rowid < 1) {$msg = "To SHOW a record, enter a ROWID"; break;}
	$query = "SELECT lecture, title, file
			  FROM $table
			  WHERE rowid='$rowid'";
	$result = $mysqli->query($query);
	if (($result->num_rows) < 1) {
	  $msg = "ROWID $rowid not found. " . $mysqli->error;
	  $msg_color = "red";
      $rowid = $lecture = $title = $file = $last = NULL;
	  }
	  else {	
		list($lecture, $title, $file) = $result->fetch_row(); 
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
    $query = "UPDATE $table SET
			  lecture		= '$lecture',
			  title			= '$title',
			  file			= '$file'
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
		$rowid = $lecture = $title = $file = $last = NULL;
		}
  break;
  
  case "add":
    $query = "INSERT INTO $table SET
			  lecture		= '$lecture',
			  title			= '$title',
			  file			= '$file'";
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
  
  $tda = "10%";		$tdb = "90%";  
  echo "<form action='$pgm' enctype='multipart/form-data' method='post'>
		<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td align='center'><b>$title2</b></td></tr>
		</table>
		<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>	
		<tr><td width='$tda'>ROWID</td><td width='$tdb'><input type='text' name='rowid' size='5' maxlength='5' value='$rowid'>
				<input type='hidden' name='last' value='$last'></td></tr>
		<tr><td width='$tda'>Lecture</td><td width='$tdb'><select name='lecture'><option> </option>";
  foreach($lectures as $key => $value) {
    if ($key == $lecture) $se = "SELECTED"; else $se = NULL;
	echo "<option value='$key' $se>Week $key - $value</option>\n";
	}		
  echo "</select></td></tr>
		<tr><td width='$tda'>Title</td><td width='$tdb'><input type='text' name='title'  size='30' maxlength='30' value='$title'></td></tr>
		<tr><td width='$tda'>File</td><td width='$tdb'>$file <input type='file' name='file'><input type='hidden' name='hfile' value='$file'></td></tr>";

  echo "</table>";
		
  echo "<table align='center' width='$width' bgcolor='white' cellspacing='10' class='text'>
		<tr><td>
		<table align='center'><tr>
		<td><input type='submit' name='task'  value='Show'   style='background-color:lightgreen;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Add'    style='background-color:lightblue;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Change' style='background-color:yellow;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Delete' style='background-color:red;font-weight:bold' Onclick='return ConfirmDelete();'></td>
		<td><input type='submit' name='task'  value='Clear'  style='background-color:white;font-weight:bold'></td>
		<td>&nbsp;</td>
		<td><input type='submit' name='task'  value='Previous Record' style='background-color:lightgray;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Next Record' style='background-color:orange;font-weight:bold'></td>
		</tr></table>
		</td></tr></table>
		</form>";

  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'><tr><td><b>Message</b>: <font color='$msg_color'>$msg</font></td></tr></table>";		

?>