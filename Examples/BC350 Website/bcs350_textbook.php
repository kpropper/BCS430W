<?php
// bcs350_schedule.php - BCS350 - Schedule
// Written by: Charles Kaplan, May 2015
// Updated: August 2016

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');
  
// Body
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr>
		<td align='center'><b>\n
		Murach's PHP and MySQL, 2nd Edition<br>
		by Joel Murach and Ray Harris, 2014
		</b></td></tr>
		<tr><td align='center'>Link to the textbook on<br>
		<a href='https://www.amazon.com/Murachs-PHP-MySQL-Joel-Murach/dp/1890774790/ref=dp_ob_image_bk' target='_blank'>
		<img src='$pixdir/amazon.png'></a>
		</td></tr>
		<tr><td><center><img src='$pixdir/text.jpg'></center>
		</td></tr></table>";
?>  