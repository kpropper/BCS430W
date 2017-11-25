<?php

	//Start the session
	session_start();

	//Read in session variables
	if(isset($_SESSION['logged_in'])) 			$loggedIn = $_SESSION['logged_in']; 		else $loggedIn = false;
	if(isset($_SESSION['userid'])) 				$userID = $_SESSION['userid'];				else $userID = NULL;
	if(isset($_SESSION['email']))				$userEmail = $_SESSION['email'];			else $userEmail = NULL;
	if(isset($_SESSION['first_name']))			$userFName = $_SESSION['first_name'];		else $userFName = NULL;
	if(isset($_SESSION['last_name']))			$userLName = $_SESSION['last_name'];		else $userLName = NULL;
	if(isset($_SESSION['user_type']))			$userType = $_SESSION['user_type'];			else $userType = NULL;
	if(isset($_SESSION['value_multiplier']))	$userMult = $_SESSION['value_multiplier'];	else $userMult = NULL;

	$fullName = $userFName . " " . $userLName;
	
	//Function to format a number as dollars
	function asDollars($value) 
	{
		return '$' . number_format($value, 2);
	}
?>
