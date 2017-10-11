<?php
// bcs350_hw_list.php - Homework List
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');
  require('bcs350_faculty.php');  
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');  

// Variables
  $pgm = "bcs350.php?p=hw_list";
  $status = "Ungraded";
  $stats = array("Ungraded", "Graded", "All");
  
// Get Input
  if (isset($_POST['status'])) 	$status = $_POST['status'];		else $status = "Ungraded";
  if (isset($_POST['student'])) $student = $_POST['student'];	else $student = "All";

// Set up Query WHERE clause for STATUS
  switch($status) {
	case "Ungraded":	$where = "WHERE (homework.status = 0)";	break;
	case "Graded":		$where = "WHERE (homework.status > 0)";	break;
	case "All":			$where = NULL;							break;
	default:			$where = "WHERE (homework.status = 0)";	break;
	}

// Set up Query WHERE clause for STUDENT
  if ($student != "All") { 
    if ($where == NULL) $where = "WHERE (homework.student='$student')";
	  else $where .= " AND (homework.student = '$student')";	
	}
	
// Output Page

// Start of the Form		
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='0' class='text'><tr><td>
		<br><center><font size='+1'>BCS350 Homework</font><br><br>
		<form action='$pgm' method='post'>
		<table align='center' width='$width'>";

// Student Dropdown		
  $query = "SELECT rowid, firstname, lastname
			FROM roster
			WHERE ((role='student') AND (status='1'))
			ORDER BY lastname, firstname";
  $result = $mysqli->query($query);
  if (!$result) echo $mysqli->error;
  echo "<tr><td align='right'> Student <select name='student'><option>All</option>\n";  
  while(list($rowid, $firstname, $lastname) = $result->fetch_row()) {
    if ($rowid == $student) $se = "SELECTED";	else $se = NULL;
	echo "<option value='$rowid' $se>$firstname $lastname</option>\n";
	}
  echo "</select></td> \n";
	
// Status Dropdown		
  echo "<td align='left'> Status: <select name='status'>";
		
  foreach($stats as $stat) {
	if ($stat == $status)	$se = "SELECTED";	else $se = NULL;
	echo "<option $se>$stat</option>";
	}
  echo "</select>&nbsp;&nbsp;
		<input type='submit' name='submit' value='Submit'> 
		</td></tr></table></form><br>		
		<table align='center' width='$width'>
		<tr>
		<td><b><u>Student </u></b></td>
		<td><b><u>Lecture </u></b></td>
		<td><b><u>Date </u></b></td>
		<td><b><u>File </u></b></td>
		<td><b><u>Grade </u></b></td>
		<td>&nbsp;</td>
		<tr>
		";

// Query Homework Table
	$query = "SELECT homework.rowid, roster.firstname, roster.lastname, homework.lecture, homework.date, homework.file, homework.status 
			  FROM homework
			  LEFT JOIN roster ON homework.student=roster.rowid
			  $where
			  ORDER BY homework.date, roster.lastname";			  
    $result = $mysqli->query($query);
	if (!$result) echo $mysqli->error;
		
// Loop Through Query Results
  while(list($rowid, $firstname, $lastname, $lecture, $date, $file, $status) = $result->fetch_row()) {
    if ($status == 0) $status = NULL;
	$lecture2 = $lectures[$lecture];
	echo "<tr>
		  <td>$firstname $lastname</td>
		  <td>$lecture2</td>
		  <td>$date</td>
		  <td>$file</td>
		  <td>$status</td>
		  <td><a href='bcs350.php?p=hw_grade&r=$rowid'><button>Grade</button></a></td>
		  <tr>";
	}
  if ($result->num_rows < 1)
    echo "<tr><td><b>None Found</td><tr>";
  
// End of Page
  echo "</table>
		</td></tr></table>\n";
	
?>	