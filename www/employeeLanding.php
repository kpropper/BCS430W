<?php
	session_start();
	
	echo "You made it to the Employee Landing Page";
	
	//Temporary Form/Button to go to inventory page
	echo"
		<form id='inventorypage' action='inventory.php' method='post'>
		</form>
		
		<table width='1024' align='center'>
		  <tr><td align='center'>
			  <button type='submit' form='inventorypage' value='Inventory'>Inventory</button>
		  </td></tr>
		  </table>";
?>