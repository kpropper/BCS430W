<?php

	//Start the session
	session_start();
//	$loggedIn = false;
//	$userID = NULL;
//	$userEmail = $_SESSION['email'];
//	$userFName = $_SESSION['first_name'];
//	$userLName = $_SESSION['last_name'];
//	$userType = $_SESSION['user_type'];
	
	//Read in session variables
	if(isset($_SESSION['logged_in'])) 	$loggedIn = $_SESSION['logged_in']; 	else $loggedIn = false;
	if(isset($_SESSION['userid'])) 		$userID = $_SESSION['userid'];			else $userID = NULL;
	if(isset($_SESSION['email']))		$userEmail = $_SESSION['email'];		else $userEmail = NULL;
	if(isset($_SESSION['first_name']))	$userFName = $_SESSION['first_name'];	else $userFName = NULL;
	if(isset($_SESSION['last_name']))	$userLName = $_SESSION['last_name'];	else $userLName = NULL;
	if(isset($_SESSION['user_type']))	$userType = $_SESSION['user_type'];		else $userType = NULL;
			
?>