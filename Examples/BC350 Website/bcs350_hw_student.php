<?php
// bcs350_hw_student.php - Student Homework List
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php and Student or Faculty Logon
  require('bcs350_landing.php');
  require('bcs350_student.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');  

// Variables
  $pgm = "bcs350.php?p=hw_student";
  $stats = array("Ungraded", "Graded", "All");
  
// Get Input
  if (isset($_POST['status'])) 	$status = $_POST['status'];		else $status = "All";

// Set up Query WHERE clause for STATUS
  switch($status) {
	case "Ungraded":	$where = "WHERE (homework.status = 0) ";	break;
	case "Graded":		$where = "WHERE (homework.status > 0) ";	break;
	case "All":			$where = NULL;							break;
	default:			$where = "WHERE (homework.status = 0 )";	break;
	}
  if ($where == NULL)
    $where = "WHERE (homework.student = '$sstudent') ";
	else $where .= " AND (homework.student = '$sstudent') ";
	
// Output Page

// Start of the Form		
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='0' class='text'><tr><td align='center'>
		<p><font size='+1'>BCS350 Student Homework List</font>
		<form action='$pgm' method='post'>
		<table align='center' width='$width'>";

// Status Dropdown		
  echo "<tr><td align='center'> <p>Status: <select name='status'>";
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
		</tr>
		";

// Query Homework Table
	$query = "SELECT homework.rowid, roster.firstname, roster.lastname, homework.lecture, homework.date, homework.file, homework.status 
			  FROM homework
			  LEFT JOIN roster ON homework.student=roster.rowid
			  $where
			  ORDER BY homework.lecture, homework.date";			  
    $result = $mysqli->query($query);
	if (!$result) echo $mysqli->error;
		
// Loop Through Query Results
  while(list($rowid, $firstname, $lastname, $lecture, $date, $file, $status) = $result->fetch_row()) {
    if ($status == 0) $status = NULL;
	$lecture2 = $lectures[$lecture];
	echo "<tr>
		  <td>$firstname $lastname</td>
		  <td>$lecture) $lecture2</td>
		  <td>$date</td>
		  <td>$file</td>
		  <td>$status</td>
		  <td><a href='bcs350.php?p=hw_update&r=$rowid'><button>Update</button></a></td>
		  </tr>";
	}
  if ($result->num_rows < 1)
    echo "<tr><td><b>None Found</td><tr>";

// Submit New Homework
  echo "</table><br><table align='center' width='$width'>
		<tr><td align='center'><a href='bcs350.php?p=hw_submit'><button>Submit New Homework</button</a></td></tr>\n";
  
// End of Page
  echo "</table>
		</td></tr></table>\n";
	
?>	