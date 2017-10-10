<?php
// bcs350_faculty.php - Verify that logged on user is Faculty
// Written by: Charles Kaplan, June 2015

// $landing is SET in BCS350.PHP. if not set, then program was called directly
  if (($srole != "Faculty") AND ($srole != "Student")) {
    header("Location: bcs350.php"); 
	exit;
	}
?>