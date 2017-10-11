<?php

// Connect to MySQL and the BCS350 Database
  $mysqli = new mysqli('localhost', 'root', NULL, 'bcs350'); 
  
// Variables
$tot = 0;
$students = 0;
$dis = 0;

// Query the Seniors Table
  $query = "SELECT district, school, seniors, honors, regents, dropouts
			FROM seniors
			ORDER BY district, school";
  $result = $mysqli->query($query);
  
  while(list($district, $school, $seniors, $honors, $regents, $dropouts) = $result->fetch_row()) {
  $tot++;
  $students += $seniors;
  }
  
  $st = mysqli_fetch_row(mysqli_query($mysqli,"SELECT district FROM seniors GROUP BY district"));
$dis = $st[0] + 1;
  
  echo "There are " . $tot . " school on Long Island<br>";
  echo "There are " . $dis . " districts on Long Island<br>";
  echo "There are " . number_format($students) . " seniors on Long Island";
  
 ?>