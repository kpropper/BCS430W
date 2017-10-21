<?PHP

// Variables
  $msg = NULL;			// Error Message

// Get Form Input
  if(isset($_POST['register'])) {
	if ($_POST['email'] == NULL) 			    $msg = "Email field is empty";				   else $email = 'email';
    if ($_POST['password'] == NULL) 			$msg = "Password field is missing";            else $password = $_POST['password'];
	if ($_POST['verifypassword'] == NULL) 	    $msg = "Verify Password field is missing";
	if ($_POST['firstname'] == NULL) 	        $msg = "First Name field is missing";		   else $firstname = $_POST['firstname'];
	if ($_POST['lastname'] == NULL) 	        $msg = "Last Name field is missing";           else $lastname = $_POST['lastname'];
	if ($_POST['companyname'] == NULL) 	        $msg = "Company Name field is missing";        else $companyname = $_POST['companyname'];
	if ($_POST['phone'] == NULL) 	        	$msg = "Phone Number field is missing";        else $phone = $_POST['phone'];
	if (!($_POST['password'] == $_POST['verifypassword']))      $msg = "The passwords do not match";

	if ($msg == NULL) 
	{
		$mysqli = new mysqli('localhost', 'root', '', 'test1');
		if ($mysqli->connect_error)
			die('Connect Error: ' . $mysqli->connect_error);
		
		$email = $mysqli->escape_string($_POST['email']);
		$result = $mysqli->query("SELECT * FROM user WHERE Email='$email'");

		if ( $result->num_rows == 0 )
		{
			$query = "INSERT INTO user SET
					  FName = '$firstname',
					  LName = '$lastname',
					  Email = '$email',
					  Password = '$password',
					  Company_Name = '$companyname',
					  Telephone = '$phone'";
			$result = $mysqli->query($query);
			if($result)
			{
				$msg = "$email has been registered";
			}
			else
			{
				$msg = "Registration failed " . mysqli_error();
			}
		}

		else
		{
			// Email already exists
			$msg = "User with that email already exists";
		}
			
	}
  }
?>