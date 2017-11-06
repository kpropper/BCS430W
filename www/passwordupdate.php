<?PHP
include("sqlConnect.php");

// Variables
  $msg = NULL;			// Error Message

  $firstname = NULL;
  $lastname = NULL;
  $email = NULL;
  $password = NULL;
  $companyname = NULL;
  $telephone = NULL;
// Get Form Input
 
  if(isset($_POST['changepassword'])) {
	if ($_POST['oldpassword'] == NULL) 			    $msg = "Old Password field is empty";				   else $oldpassword = $_POST['oldpassword'];
	if ($_POST['newpassword'] == NULL) 	        $msg = "New Password field is missing";		   else $newpassword = $_POST['newpassword'];
	if ($_POST['verifypassword'] == NULL) 	        $msg = "Verify Password field is missing";           else $verifypassword = $_POST['verifypassword'];

	if ($msg == NULL) 
	{
		$result = $mysqli->query("SELECT Password FROM user WHERE UserID ='$userID'");
		
		if ( $result->num_rows == 1 )
		{
			list($password) = $result->fetch_row();
			if($oldpassword == $password)
			{
				if($newpassword == $verifypassword)
				{
					$query = "UPDATE user SET
									  Password		= '$newpassword'
									  WHERE UserID 	= '$userID'";
									  
					$result = $mysqli->query($query);
					if ($result) {
						$msg = "Password Updated";
					}
					else
					{
						$msg = "Password NOT Updated " . mysqli_error($mysqli); 
					}
				}
				else
				{
					$msg = "Password and verify password do not match.";
				}
			}
			else
			{
				$msg = "Old Password is incorrect.";
			}
		}
		else
		{
			$msg = "User does not exist";
		}
	}
  }