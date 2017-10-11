<?php
// bcs350_landing.php - Verify that program was called by BCS350.PHP, if not transfer to BCS350.PHP
// Written by: Charles Kaplan, May 2015

// $landing is SET in BCS350.PHP. if not set, then program was called directly
  if (!isset($landing)) {
    header("Location: bcs350.php"); 
	exit;
	}
?>