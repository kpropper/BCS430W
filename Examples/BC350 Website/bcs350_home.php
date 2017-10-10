<?php
// bcs350_home.php - BCS350 Home Page
// Written by:  Charles Kaplan, May 2015	

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');

// Set Up Name   
  if (!$logon) $sname = NULL;

// Output Page  
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr>
		<td>
		<b>Welcome $sname!</b>\n
		<br><br>\n
		<i>This website was written as an instructional tool for teaching BCS350 - Web Database Design at Farmingdalte State College of
		the State University of	New York.  The website is a working website for the public, students and the instructor to perform 
		their roles in the administration of the course.  Public information is available to everyone.  To access the student and 
		instruction pages a LOGON is required.</i>\n
		<br><br><p align='center'>
		<a href='http://www.farmingdale.edu'><img src='$pixdir/fsc-header-logo.gif' border='0'></a></p>\n
		<br><br>
		<table width='560' align='center'><tr>
        <td align='left'><a href='https://twitter.com/farmingdalesc' target='_blank'><img src='$pixdir/twitter.jpg' width='160'></a></td>
		<td align='right'><a href='https://www.facebook.com/farmingdale' target='_blank'><img src='$pixdir/facebook.jpg' width='160'></a></td>
		</tr></table>\n";

// Popup Message		
  if (file_exists("bcs350_popup.html"))
    echo file_get_contents("bcs350_popup.html");	  

// End of Page	
  echo "</td></tr></table>";	  
  
// <FONT color='#404040' face='Tahoma, Arial, Helvetica, san-serif' size='2'>  
?>