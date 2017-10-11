<?php

$tot = 0;
$pop = 0;
$max = 0;
$min = 0;

$mysqli = new mysqli('localhost', 'root', NULL, 'bcs350');

  $query = "SELECT city, population
			FROM cities
			ORDER BY city";
  $result = $mysqli -> query($query);
  while(list($city, $population) = $result->fetch_row()) {
	$tot++;
	$pop += $population;
	}

	$st = mysqli_fetch_row(mysqli_query($mysqli,"SELECT max(population) AS max FROM cities"));
$max = $st[0] + 1;

	$st = mysqli_fetch_row(mysqli_query($mysqli,"SELECT min(population) AS min FROM cities"));
$min = $st[0] + 1;
	
	
	echo "There are " . $tot . " cities in the table<br>";
	echo "The total population of all the cities is " . number_format($pop) . "<br>";
	echo "The largest population is " . number_format($max) . "<br>";
	echo "The smallest population is " . number_format($min);

?>