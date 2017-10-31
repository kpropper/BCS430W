<?php
	session_start();

	//Remove any whitepace from the user_type session variable and assign it to $userType
	$userType=trim($_SESSION['user_type']);

	
	if ($_SESSION['logged_in'] == true)
	{
		if($userType == "Employee")
		{
			echo "<script> location.href='employeeLanding.php'; </script>";
		}
		elseif($userType == 'Client')
		{
			echo "<script> location.href='clientLanding.php'; </script>";
		}
		else
		{
			echo "Something went wrong, Please consult with an ITAMG representative.";
		}
	}
	else
	{
		echo "<script> location.href='login.php'; </script>";
	}
?>