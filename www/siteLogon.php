<?PHP
  
// Variables  
  $msg = NULL;			// Error Message
  
// Get Form Input  
  if(isset($_POST['logon'])) {
    $userid = trim($_POST['email']);
    $pword = trim($_POST['password']);
	if ($userid == NULL) 			$msg = "EMail is missing";
    if ($pword == NULL) 			$msg = "PASSWORD is missing";
    if (($userid == NULL) AND ($pword == NULL)) $msg = "EMail & PASSWORD are missing";
	if ($msg == NULL) {
     // include('sqlConnect.php');
	  
	$mysqli = new mysqli('localhost', 'root', '', 'test1');
	if ($mysqli->connect_error)
		die('Connect Error: ' . $mysqli->connect_error);	
	  
	  
	  
	  $query = "SELECT UserID, FName, LName, Email, Password, CompanyName FROM users WHERE Email='$userid'";
      $result = $mysqli->query($query);
	  if (!$result) $msg = "Error accessing User Table " . mysql_error;
	  if ($result->num_rows > 0) {
	    list($student, $firstname, $lastname, $role, $password, $status) = $result->fetch_row();
	    if ($pword == $password)
	      if ($status) {
		    $_SESSION['userid'] = $userid;
		    //$_SESSION['role'] = $role;
		    //$_SESSION['name'] = $name = "$firstname $lastname";
			//$_SESSION['student'] = $student;
		    $logon = TRUE;
			//$location = "location: bcs350.php";
			$msg = "<font color='green'><b>$name Logon Successful</b></font>"; 
			header($location);
			exit; 
		    }
		  else $msg = "Your LOGON ID is inactive";
		else $msg = "Invalid Password";
	    }
	  else $msg = "EMail is invalid";
	  }
	}
	
?>