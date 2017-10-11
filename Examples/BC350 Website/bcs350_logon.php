<?PHP
// BCS350_logon.php - Logon to BCS350 Website
// Written by:  Charles Kaplan, May 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');
  
// Variables  
  $msg = NULL;			// Error Message
  
// Get Form Input  
  if(isset($_POST['logon'])) {
    $userid = trim($_POST['userid']);
    $pword = trim($_POST['password']);
	if ($userid == NULL) 			$msg = "USERID is missing";
    if ($pword == NULL) 			$msg = "PASSWORD is missing";
    if (($userid == NULL) AND ($pword == NULL)) $msg = "USERID & PASSWORD are missing";
	if ($msg == NULL) {
      include('bcs350_mysql_connect.php');
	  $query = "SELECT rowid, firstname, lastname, role, password, status FROM roster WHERE userid='$userid'";
      $result = $mysqli->query($query);
	  if (!$result) $msg = "Error accessing Roster Table " . mysql_error;
	  if ($result->num_rows > 0) {
	    list($student, $firstname, $lastname, $role, $password, $status) = $result->fetch_row();
	    if ($pword == $password)
	      if ($status) {
		    $_SESSION['userid'] = $userid;
		    $_SESSION['role'] = $role;
		    $_SESSION['name'] = $name = "$firstname $lastname";
			$_SESSION['student'] = $student;
		    $logon = TRUE;
			$location = "location: bcs350.php";
			$msg = "<font color='green'><b>$name Logon Successful</b></font>"; 
			header($location);
			exit; 
		    }
		  else $msg = "Your LOGON ID is inactive";
		else $msg = "Invalid Password";
	    }
	  else $msg = "USERID is invalid";
	  }
	}
  
// Logon Screen
  $td = "width='20%' align='right'";
  $tf = "width='80%' align='left'";
  if ($msg == NULL)  	$msg = "Enter User ID and Password";
	else if ($logon == FALSE) $msg = "<font color='yellow'>$msg, please try again</font>";  
  echo "<form action='bcs350.php?p=logon' enctype='multipart/form-data' method='post'>\n
		<table width='$width' align='center' bgcolor='white' cellspacing='10' class='text'>\n
		<tr><td $td>&nbsp;</td><td $td>&nbsp;</td></tr>
		<tr><td $td>&nbsp;</td><td $tf><b>BCS350 Student/Faculty Logon</b></td></tr>\n
		<tr><td $td>&nbsp;</td><td $td>&nbsp;</td></tr>
		<tr><td $td>User ID</td>	<td $tf><input type='text' name='userid' size='60' maxlength='80' value=''></td></tr>\n
		<tr><td $td>Password</td>	<td $tf><input type='password' name='password' size='12' maxlength='12' value=''></td></tr>\n
		<tr><td $td>&nbsp;</td>		<td $tf>&nbsp;</td></tr>\n
		<tr><td $td>&nbsp;</td>		<td $tf><input type='submit' name='logon' value='LOGON' style='background-color:lightgreen;font-weight:bold'></td></tr>\n
		<tr><td $td>&nbsp;</td>		<td $tf>&nbsp;</td></tr>\n
		<tr><td $td>Message</td>	<td $tf><b>$msg<b></td></tr>\n
		</table>\n
		</form>\n";
?>