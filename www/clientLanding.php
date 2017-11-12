<?php
	include('siteInit.php');
	include('menu.php');

	echo "You made it to the Client Landing Page";

	//Temporary Form/Button to go to inventory page
	echo"
		<html>
			<head>
				<meta charset='utf-8'>
				<title>Landing Page</title>
				<link rel='stylesheet' href='css/landing_style.css'>
			</head>
			<body>
				<div class='container1'>

				<a href='inventory.php' class='inventory-button'>Get a Quote</a>
				<a href='#' class='inventory-button'>View Quotes</a>
				<a href='manageaccount.php' class='manage-account'>Manage Account</a>

		</div>
		</body>

</html>";

?>
