<?php
// bcs350_schedule.php - BCS350 - Schedule
// Written by:  Prof. Kaplan, June 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');
 
// Body
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td align='center'>
		<p><embed src='schedule.pdf' width='850' height='1100'>
		</td></tr></table>";

?>  