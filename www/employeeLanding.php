<?php
	include('siteInit.php');
	include('menu.php');
	
	echo "You made it to the Employee Landing Page <br>";

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
       
				<a href='inventory.php' class='inventory-button'>Inventory</a>
       
        
       
				<a href='#' class='new-quote'>Request New Quote</a>
       
        
       
				<a href='#' class='inventory-lookup'>Inventory Lookup</a>
       
        
        
				<a href='manageaccount.php' class='manage-account'>Manage Account</a>
        
		</div>
		</body>
	
</html>>";
?>
