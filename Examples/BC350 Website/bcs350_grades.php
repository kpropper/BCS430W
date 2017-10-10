<?php
// bcs350_grades.php - Show a Student's Grades
// Written by: Charles Kaplan, May 2015

// Verify that program was called from bcs350_php and Student or Faculty Logon
  require('bcs350_landing.php');
  require('bcs350_student.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');

// Variables
  $total = 0;

// Get Input
  if (isset($_GET['r'])) {
    $student = $_GET['r'];
	$query = "SELECT firstname, lastname 
			  FROM roster
			  WHERE rowid='$student'";
	$result = $mysqli->query($query);    
    list($firstname, $lastname) = $result->fetch_row();
    $name = "$firstname $lastname";
	}
	else { 
	  $student = $sstudent;
	  $name = $sname;
	  }

// Set up Query
  $query = "SELECT rowid, event, grade, date, comment
			FROM grades
			WHERE student='$student'
			ORDER BY date";
  $result = $mysqli->query($query);
  
// Output Page
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td align='center'><p><b><font size='+1'>Student Grades for $name</font></b></td></tr></table>
		<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr>
		<td><b><u>Rowid</u></b></td>
		<td><b><u>Event</u></b></td>
		<td><b><u>Grade</u></b></td>
		<td><b><u>Date</u></b></td>
		<td><b><u>Comment</u></b></td>
		</tr>\n";
  $num_rows = $result->num_rows;  
  if (($num_rows) > 0) {
	while(list($rowid, $event, $grade, $date, $comment) = $result->fetch_row()) {
	  $total += $grade;
	  if ($srole == "Faculty") 
	    $u = "<td><a href='bcs350.php?p=assign_grades&r=$rowid'><button>Update</button></a></td>"; 	
		else $u = NULL;	  
	  echo "<tr><td>$rowid</td>
				<td>$event</td>
				<td>$grade</td>
				<td>$date</td>
				<td>$comment</td>
				<td>$u</td>
			</tr>\n";
	  }
	}

  if ($num_rows > 0) $average = $total / $num_rows;		else $average = 0;
  $average = round($average, 2);
  echo "</table>
	    <table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td align='center'>$num_rows Grade(s) Found, Average = $average</td></tr></table>";
  
?>