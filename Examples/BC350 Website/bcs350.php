<?php
// bcs350.php - Landing Page for the BCS350 Website
// Written by:  Charles Kaplan, May 2015

// Set Default PHP Options
  error_reporting('E_ALL');
  ob_start();
  date_default_timezone_set('America/New_York');
  
// Start Session, Set session variables
  include('bcs350_session.php');

// Common Variables, Functions
  include('bcs350_variables.php'); 
  include('bcs350_functions.php');  
  
// Variables
  $online = TRUE;				// Set to FALSE to bring website down
  $landing = TRUE;				// Set variable for page authentication
  
// Get Input
  if (isset($_GET['p']))	$p = $_GET['p'];
  $page = "bcs350_$p.php";
  if (!file_exists($page))	$page = "bcs350_home.php";  
  if (!$online)				$page = "bcs350_offline.php";  

// Output Page
  include('bcs350_header.php'); 			// Page Header 
  include('bcs350_navbar.php');				// Navigation Bar
  echo "<table class='content' align='center' width='1024' cellspacing='0' cellpadding='0' bgcolor='white'><tr><td>\n";	
    include($page);							// Page Content
  echo "</td></tr></table>";
  include('bcs350_footer.php');				// Page Footer
?>