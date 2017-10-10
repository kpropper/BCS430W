<?php
// bcs350_assign_grades.php - Assign Grades
// Written by:  Charles Kaplan, May 2015

// Verify that program was called from bcs350_php and Faculty User
  require('bcs350_landing.php');
  require('bcs350_faculty.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');

// Variables
  $pgm = "bcs350.php?p=assign_grades";
  $table = "grades";
  $quote = array("'" => "&#039;", 
				 '"' => "&quot;", 
				 '“' => "&quot;", 
				 '”' => "&quot;");
  $msg = NULL;
  $msg_color = "black";  
  
// Get Input
  if (isset($_POST['task'])) {
	$task = 	strtolower(trim($_POST['task']));
	$rowid = 	trim($_POST['rowid']);
	$last = 	$_POST['last'];	
	$student = 	trim($_POST['student']);
	$event = 	trim($_POST['event']);
	$grade = 	trim($_POST['grade']);
	$date = 	trim($_POST['date']);	
	$comment = 	trim(strtr($_POST['comment'], $quote));
	}
	else $task = "first";
  if (isset($_GET['r'])) {
    $rowid = $_GET['r'];
	$task = "show";
	}

// Verify Input
  if (($task == "add") OR ($task == "change")) {
    if ($student == NULL)	$msg .= "Student not selected. ";
	if ($event == NULL)		$msg .= "Event not selected. ";
	if ($grade == NULL)		$msg .= "Grade not entered. ";
	if ($date == NULL)		$msg .= "Date not entered. ";	
	}
  if ($msg != NULL)	$task = "error";
	
// Switch Task
  switch($task) {
  case "error":		$msg_color = "red";	break;
  
  case "show":
  case "next record":
  case "previous record":
    if ($task == "previous record") $rowid = $rowid - 1;
	if ($task == "next record") 	$rowid = $rowid + 1;
	if($rowid < 1) {$msg = "To SHOW a record, enter a ROWID"; break;}
	$query = "SELECT student, event, grade, date, comment
			  FROM $table
			  WHERE rowid='$rowid'";
	$result = $mysqli->query($query);
	if (($result->num_rows) < 1) {
	  $msg = "ROWID $rowid not found. " . $mysqli->error;
	  $msg_color = "red";
	  $student = $event = $grade = $date = $comment = $last = NULL;
	  }
	  else {	
		list($student, $event, $grade, $date, $comment) = $result->fetch_row(); 
		$msg        = "Row $rowid found";
		$last       = $rowid;
		}
    break;    
	
  case "add":  
	if ($grade < 1) $grade = 0;
	$query = "INSERT INTO $table SET
			  student	= '$student',
			  event		= '$event',
			  grade		= '$grade',
			  date		= '$date',
			  comment	= '$comment'";
    $result = $mysqli -> query($query);
	if ($result) {
	  $rowid = $mysqli->insert_id;
	  $last = $rowid;	  
	  $msg = "Grade #$rowid recorded";
	  }
	  else {
	    $msg = "Grade not entered " . $mysqli->error; 
		$msg_color = "red";
		}
	break;

  case "change":
    if ($rowid != $last) {
	  $msg = "Show row before updating, ROWID [$rowid], LAST [$last]";
	  $msg_color = "red";
	  break; 
	  }
    $query = "UPDATE $table SET
			  student	= '$student',
			  event		= '$event',
			  grade		= '$grade',
			  date		= '$date',
			  comment	= '$comment'
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
		$student = $event = $grade = $comment = NULL;
		$date = date("m/d/Y");
		$msg = "ROWID $rowid deleted";
		}
  break;
	
	
  case "first":
  case "clear":  
  default:		$msg = "Enter Student Grade Information";
				$date = date("Y-m-d");
				$rowid = $student = $event = $grade = $comment = $last = NULL;	break;	  
	}

// Output Page
// Javascript ConfirmDelete Function
  echo "<script>
		  function ConfirmDelete() {
			var x = confirm('Are you sure you want to delete?');
			if (x) return true;
			  else return false;
		  }
		</script>";

// Start of the Form		
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='0' class='text'><tr><td>
		<center><font size='+1'>BCS350 Assign Grades</font><br><br>
		<form action='$pgm' method='post'>
		<table align='center'>";

// ROWID
  echo "<tr><td align='right'>ROWID </td>	<td><input type='text' size='5'  maxlength='5'  name='rowid' value='$rowid'>
		<input type='hidden' name='last' value='$last'></td></tr>\n";
		
// Student
  $query = "SELECT rowid, firstname, lastname
			FROM roster
			WHERE (role = 'Student') 
			ORDER BY lastname, firstname";
  $result = $mysqli -> query($query);
  echo "<tr><td align='right'>Student </td><td><select name='student'><option> </option>\n";
  while(list($rowid, $firstname, $lastname) = $result->fetch_row()) {
    if ($rowid == $student)	$se = "SELECTED"; 	else $se = NULL;
	echo "<option value='$rowid' $se>$lastname, $firstname</option>\n";
	}
  echo "</select></td></tr>";
  
// Event
  echo "<tr><td align='right'>Event</td><td><select name='event'><option> </option>\n";
  foreach ($events as $eventx) {
    if ($eventx == $event)	$se = "SELECTED";	else $se = NULL;
	echo "<option $se>$eventx</option>\n";
	}
  echo "</select></td></tr>\n";

// Grade, Date, Comment
  echo "<tr><td align='right'>Grade </td>	<td><input type='text' size='3'  maxlength='3'  name='grade' 	value='$grade'></td></tr>  
		<tr><td align='right'>Date </td>	<td><input type='text' size='10' maxlength='10' name='date' 	value='$date'></td></tr>
		<tr><td align='right'>Comment </td>	<td><input type='text' size='80' maxlength='80' name='comment' 	value='$comment'></td></tr>
		</table><br>\n";

// Task Buttons, End of Form		
  echo "<table align='center'>
		<tr>
		<td><input type='submit' name='task'  value='Show'   style='background-color:lightgreen;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Add'  	 style='background-color:lightblue;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Change' style='background-color:yellow;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Delete' style='background-color:red;font-weight:bold' Onclick='return ConfirmDelete();'></td>
		<td><input type='submit' name='task'  value='Clear'  style='background-color:white;font-weight:bold'></td>
		<td>&nbsp;</td>
		<td><input type='submit' name='task'  value='Previous Record' style='background-color:lightgray;font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Next Record' style='background-color:orange;font-weight:bold'></td>
		</tr>
		</table><br>
		</form>";

  echo "<table align='center'><tr><td><b>Message</b>: <font color='$msg_color'>$msg</font></td></tr></table>
		</td></tr></table>"; 
	
?>	