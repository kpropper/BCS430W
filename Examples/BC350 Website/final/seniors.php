<?php

// Connect to MySQL and the BCS350 Database
  $mysqli = new mysqli('localhost', 'root', NULL, 'bcs350'); 
  
// Query the Seniors Table
  $query = "SELECT district, school, seniors, honors, regents, dropouts
			FROM seniors
			ORDER BY district, school";
  $result = $mysqli->query($query);
  
  
// Output the Results
  echo "<center><b><u>Long Island High School Seniors</u></b></center><br><br>
		<table width='1024' align='center' border='1'>
		<tr>
		<th>District</th>	
		<th>School</th>
		<th>Seniors</th>
		<th>Honors</th>
		<th>Regents</th>
		<th>Dropouts</th>
		<th>Graduate Percent</th>
		<th>Dropout Percent</th>
		</tr>";
  while(list($district, $school, $seniors, $honors, $regents, $dropouts) = $result->fetch_row()) {
	  
	  $gradpercent = number_format((($honors + $regents) / $seniors) * 100);
	  $droppercent = number_format(($dropouts / $seniors) * 100);
	  
	  $color = "white";
	  if ($gradpercent > 95){
		  $color="lightgreen";
	  }
	  if ($droppercent > 5) {
		  $color="pink";
	  }
	  
    echo "<tr bgcolor='$color'>
		  <td>$district</td>
		  <td>$school</td>
		  <td>$seniors</td>
		  <td>$honors</td>
		  <td>$regents</td>
		  <td>$dropouts</td>
		  <td>$gradpercent %</td>
		  <td>$droppercent %</td>
		  </tr>";
	}
  echo "</table>";	


?>