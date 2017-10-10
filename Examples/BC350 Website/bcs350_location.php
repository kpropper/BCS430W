<?php
// bcs350_overview.php - BCS350
// Written by:  Charles Kaplan, May 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');
  
// Body
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
			<tr><td align='center'><b>BCS 350 - Web Database Design</b></td></tr>
			<tr><td align='center'><b>Walt Whitman Hall, Room 209</b></td></tr>
			<tr><td align='center'><b>Tuesdays, 5:55pm to 8:25pm</b></td></tr>		
			<tr><td align='center'><img src='$pixdir/whitman.jpg'></td></tr>
			<tr><td>
			<table align='center'>
				<tr><td width='150'>&nbsp;</td>
				<td align='right'><img src='$pixdir/FSC_logo.jpg'>
				<td align='left'><img src='$pixdir/fsc-header-logo.gif'><br>
					2350 Broadhollow Road<br>
					Farmingdale, NY  11735<br>		
					(631) 420-2190</td></tr>
			</table>
			</td></tr>

			<tr><td align='center'>
			<iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4167.355856327756!2d-73.43008356236611!3d40.75244967936943!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e82af841868f33%3A0x8f0e637b61323d64!2sWhitman+Hall%2C+Farmingdale%2C+NY+11735!5e1!3m2!1sen!2sus!4v1470664171568' 
						 width='750' height='600' frameborder='0' style='border:0' allowfullscreen>
			</iframe>
			</td></tr>
		</table>";
?>  