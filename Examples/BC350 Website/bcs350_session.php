<?php
// BCS350_session.php - Check for Logon and Load Session Variables
// Written by:  Charles Kaplan, May 2015

  session_start();
  
  if (isset($_SESSION['userid'])) {
    $logon = 	TRUE;
	$sname = 	$_SESSION['name'];
	$suserid = 	$_SESSION['userid'];
	$srole = 	$_SESSION['role'];
	$sstudent = $_SESSION['student'];	
	}
	
	else {
	  $logon = FALSE;
	  $sname = $suserid = $srole = $sstudent = NULL;
	  }
?>