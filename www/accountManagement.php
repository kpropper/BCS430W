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
if(isset($_POST['update'])) {
	if ($_POST['email'] == NULL) 			    $msg = "Email field is empty";				   else $email = $_POST['email'];
	if ($_POST['firstname'] == NULL) 	        $msg = "First Name field is missing";		   else $firstname = $_POST['firstname'];
	if ($_POST['lastname'] == NULL) 	        $msg = "Last Name field is missing";           else $lastname = $_POST['lastname'];
	if ($_POST['companyname'] == NULL) 	        $msg = "Company Name field is missing";        else $companyname = $_POST['companyname'];
	if ($_POST['phone'] == NULL) 	        	$msg = "Phone Number field is missing";        else $telephone = $_POST['phone'];

	if ($msg == NULL) 
	{
		$continue = true;
		$result = $mysqli->query("SELECT Email FROM user WHERE UserID='$userID'");
		list($oldemail) = $result->fetch_row();
		if($email != $oldemail)
		{
			$result = $mysqli->query("SELECT * FROM user WHERE Email='$email'");
			if ($result->num_rows >= 1 ) $continue = false;
			
		}

		if($continue)
		{	
			$query = "UPDATE user SET
				FName			= '$firstname',
				LName			= '$lastname',
				Email			= '$email',
				Company_Name 	= '$companyname',
				Telephone 		= '$telephone'
					WHERE UserID 	= '$userID'";
									  
			$result = $mysqli->query($query);
			if ($result) {
				$msg = "User $firstname $lastname Updated";
			}
			else
			{
				$msg = "$$firstname $lastname NOT Updated" . mysqli_error($mysqli); 
			}
		}
		else $msg = "$email already exists.";
	}
}
else
{
	$result = $mysqli->query("SELECT FName, LName, Email, Company_Name, Telephone FROM user WHERE UserID ='$userID'");
		
	if ( $result->num_rows == 1 )
	{
		list($firstname, $lastname, $email, $companyname, $telephone) = $result->fetch_row();
	}
	else
	{
		$msg = "User does not exist";
	}
}		
?>