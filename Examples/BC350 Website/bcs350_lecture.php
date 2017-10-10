<?php
// bcs350_lecture.php - Class Roster
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php and Student or Faculty Logon
  require('bcs350_landing.php');
  require('bcs350_student.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');

// Variables
  $dir		= "lectures/";
  
// Output Page
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr>
		<td align='center'><font size='+1'><p>BCS350 Lectures</font></td>
		</tr>";

// Query Lectures Table
  $query = "SELECT rowid, lecture, title, file
			FROM lectures
			ORDER BY lecture, title";
  $result = $mysqli -> query($query);

// Process Query Results
  echo "<tr><td><p>
		<table width='1000' align='center'>
		<td align='left'><b><u>Week		</u></b></td>
		<td align='left'><b><u>Lecture	</u></b></td>	
		<td align='left'><b><u>Title	</u></b></td>";
  if ($srole == "Faculty") echo "<td align='left'>&nbsp;</td>";
  echo "</tr>\n";
  if ($result->num_rows < 1) 
    echo "<tr><td><font color='red'>None Found</font></td></tr>";
  while(list($rowid, $lecture, $title, $file) = $result->fetch_row()) {
    $lecture2 = $lectures[$lecture];
    echo "<tr>
			<td align='left'>$lecture</td>
			<td align='left'>$lecture2</td>
		    <td align='left'>$title</td>
			<td align='left'><a href='$dir$file'>$file</a></td>";
    if ($srole == "Faculty") 
	  echo "<td align='left'><a href='bcs350.php?p=lecture_update&r=$rowid'><button>Update</button></a></td>";
	echo "</tr>\n";
	}
  echo "</table>
		</td></tr></table>\n"; 	
?>	