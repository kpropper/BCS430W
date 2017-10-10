<?php
// bcs350_roster.php - Class Roster
// Written by:  Charles Kaplan, May 2015

// Verify that program was called from bcs350_php and Student or Faculty Logon
  require('bcs350_landing.php');
  require('bcs350_student.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');

// Variables
  $tot = 0;			// Total enrollments
  $active = 0;		// Active Student Enrollments  
  
// Content
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr>
		<td align='center'><font size='+1'>BCS350 Roster</font></td>
		</tr></table>";

// Query Roster Table
  $query = "SELECT rowid, firstname, lastname, ramid, email, userid, role, status
			FROM roster
			ORDER BY lastname, firstname";
  $result = $mysqli -> query($query);

// Process Query Results
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='5' class='text'>
		<tr>
		<td><b><u>Name		</u></b></td>	
		<td><b><u>Email		</u></b></td>
		<td><b><u>Userid	</u></b></td>
		<td><b><u>Role		</u></b></td>
		<td><b><u>Status	</u></b></td>";
  echo "</tr>\n";
  if ($result->num_rows < 1) 
    echo "<tr><td><font color='red'>None Found</font></td></tr>";
  while(list($rowid, $firstname, $lastname, $ramid, $email, $userid, $role, $status) = $result->fetch_row()) {
    if ($status) $status = "Active"; else $status = "Inactive";
    $x = "$firstname $lastname";
	$update = "<a href='bcs350.php?p=profile&r=$rowid'><button>Update</button><a>";
	$grades = "<a href='bcs350.php?p=grades&r=$rowid'><button>Grades</button></a>";
	if (($srole == "Student") and ($sstudent != $rowid)) $update = $grades = NULL;	
    echo "<tr>
		  <td>$x</td>
		  <td><a href='mailto:$email'>$email</a></td>
		  <td>$userid</td>
		  <td>$role</td>
		  <td>$status</td>";
	echo "<td>$update</td>"; 
	echo "<td>$grades</td>";
	echo "</tr>\n";
	$tot++;
	if (($role == "Student") AND ($status == "Active")) $active++;
	}
  echo "</table>\n
		<table width='$width' align='center' bgcolor='white' cellspacing='5' class='text'>\n
		<tr><td align='center'>Total Records = $tot, Active Students = $active</td></tr></table>"; 
	
?>	