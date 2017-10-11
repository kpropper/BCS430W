<?php
// bcs350_view_grades.php - Show Student Grades
// Written by: Charles Kaplan, June 2015

// Verify that program was called from bcs350_php and Faculty User
  require('bcs350_landing.php');
  require('bcs350_faculty.php');;
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');

// Variables
  $total = 0;
  $pgm = "bcs350.php?p=view_grades";

// Get Input
  if ($srole == "Student") {
    $student = $sstudent;
	$name = $sname;
	}
	else $student = $name = NULL;
  if (isset($_POST['student']))
    $student = $_POST['student'];
  if (isset($_POST['event']))
    $event = trim($_POST['event']);
	else $event = "All";
	
// Output Page
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td align='center'><font size='+1'><b>Student Grades</b></font></td></tr>\n";
		
// If Faculty, allow for Student Dropdown
  if ($role = "Faculty") {
    $query = "SELECT rowid, firstname, lastname
	  		  FROM roster
			  WHERE (role = 'Student') 
			  ORDER BY lastname, firstname";
    $result = $mysqli -> query($query);
    echo "<tr><td align='center'> 
		  <form action='$pgm' method='post'>
		  Student <select name='student'><option>All</option>\n";
    while(list($rowid, $firstname, $lastname) = $result->fetch_row()) {
      if ($rowid == $student)	$se = "SELECTED"; 	else $se = NULL;
	  echo "<option value='$rowid' $se>$lastname, $firstname</option>\n";
	  }
    echo "</select>&nbsp;&nbsp;&nbsp;";
		  
// Event Dropdown
    echo "Event <select name='event'><option>All</option>\n";
    foreach ($events as $eventx) {
      if ($eventx == $event)	$se = "SELECTED";	else $se = NULL;
	  echo "<option $se>$eventx</option>\n";
	  }
    echo "</select> <input type='submit' name='submit' value='Submit'></form></td></tr>\n";      		  
    }		  
	
  echo "</table>
		<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr>
		<td><b><u>Rowid</u></b></td>
		<td><b><u>Name</u></b></td>
		<td><b><u>Event</u></b></td>
		<td><b><u>Grade</u></b></td>
		<td><b><u>Date</u></b></td>
		<td><b><u>Comment</u></b></td>
		</tr>\n";
		
// Query Student Grades
  if ($student != NULL) {
    if ($student == "All") 	
      $where = NULL;
	  else $where = "WHERE (grades.student='$student')";
    if ($event != "All") {
      if ($where == NULL)
	    $where = "WHERE (grades.event='$event')";
	    else $where .= " AND (grades.event='$event')";
	  }	
    $query = "SELECT grades.rowid, grades.event, grades.grade, grades.date, grades.comment, roster.firstname, roster.lastname
			  FROM grades
			  LEFT JOIN roster ON grades.student=roster.rowid
			  $where
			  ORDER BY roster.lastname, roster.firstname, grades.date";
    $result = $mysqli->query($query);	
    $num_rows = $result->num_rows;  
	while(list($rowid, $event, $grade, $date, $comment, $firstname, $lastname) = $result->fetch_row()) {
	  $total += $grade;
	  if ($srole == "Faculty") 
	    $u = "<td><a href='bcs350.php?p=assign_grades&r=$rowid'><button>Update</button></a></td>"; 	
		else $u = NULL;	  
	  echo "<tr><td>$rowid</td>
				<td>$firstname $lastname</td>
				<td>$event</td>
				<td>$grade</td>
				<td>$date</td>
				<td>$comment</td>
				<td>$u</td>
			</tr>\n";
	  }
    if ($num_rows > 0) $average = $total / $num_rows;		else $average = 0;
    $average = round($average, 2);
    echo "</table>
	      <table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		  <tr><td align='center'>$num_rows Grade(s) Found, Average = $average</td></tr>";
	}	  
  echo "</table>";
?>