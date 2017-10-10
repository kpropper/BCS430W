<?PHP
// BCS350_logoff.php - Logoff
// Written by:  Charles Kaplan, May 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');

// Logoff by unsetting session variables  
  if (!$logon) $sname = "USER";  
  session_unset();
  
  $logon = FALSE;
 
// LOGOFF SCREEN
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td>&nbsp;</td></tr>
		<tr><td align='center'><b><font size='+2'>$sname Logged Off</font></b></td></tr>
		<tr><td>&nbsp;</td></tr>
		</table>\n";
?>