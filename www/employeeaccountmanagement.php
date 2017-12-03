<?PHP
include("sqlConnect.php");

	/**
	* Generate a random string, using a cryptographically secure 
	* pseudorandom number generator (random_int)
	* 
	* For PHP 7, random_int is a PHP core function
	* For PHP 5.x, depends on https://github.com/paragonie/random_compat
	* 
	* @param int $length      How many characters do we want?
	* @param string $keyspace A string of all possible characters
	*                         to select from
	* @return string
	*/
	function random_str($length, $keyspace = '0123456789!@#$%&abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')	
	{
		require_once "/random_compat-master/lib/random.php";
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}	
		return $str;
	}
	
// Variables
$msg = NULL;			// Error Message

$useruserID = NULL;
$userfirstname = NULL;
$userlastname = NULL;
$useremail = NULL;
$usercompanyname = NULL;
$usertelephone = NULL;
$userValueMult = NULL;
$userUserType = NULL;



// Get Form Input
if ($_POST['userUserID'] == NULL) 			    $msg = "User ID is empty";				   else $useruserID = $_POST['userUserID'];
if (isset($_POST['message'])) 			    	$msg = $_POST['message'];

if(isset($_POST['update'])) {
	if ($_POST['userEmail'] == NULL) 			    $msg = "Email field is empty";			   else $useremail = $_POST['userEmail'];
	if ($_POST['userFirstName'] == NULL) 	        $msg = "First Name field is missing";		   else $userfirstname = $_POST['userFirstName'];
	if ($_POST['userLastName'] == NULL) 	        $msg = "Last Name field is missing";           else $userlastname = $_POST['userLastName'];
	if ($_POST['userCompanyName'] == NULL) 	        $msg = "Company Name field is missing";        else $usercompanyname = $_POST['userCompanyName'];
	if ($_POST['userTelephone'] == NULL) 	        	$msg = "Phone Number field is missing";        else $usertelephone = $_POST['userTelephone'];
	if ($_POST['userUserType'] == NULL) 	        	$msg = "Phone Number field is missing";        else $userUserType = $_POST['userUserType'];
	if ($_POST['userUserMult'] == NULL) 	        	$msg = "Phone Number field is missing";        else $userValueMult = $_POST['userUserMult'];

	if ($msg == NULL) 
	{
		$continue = true;
		$result = $mysqli->query("SELECT Email FROM user WHERE UserID='$useruserID'");
		list($email) = $result->fetch_row();
		if($email != $useremail)
		{
			$result = $mysqli->query("SELECT * FROM user WHERE Email='$useremail'");
			if ($result->num_rows >= 1 ) $continue = false;
			
		}

		if($continue)
		{			
			$query = "UPDATE User SET
				FName			= '$userfirstname',
				LName			= '$userlastname',
				Email			= '$useremail',
				Company_Name 	= '$usercompanyname',
				Telephone 		= '$usertelephone',
				UserType		= '$userUserType',
				Value_Multiplier = '$userValueMult'
					WHERE UserID 	= '$useruserID'";
									  
			$result = $mysqli->query($query);
			if ($result) {
				$rows = mysqli_affected_rows($mysqli);
				$msg = "User $userfirstname $userlastname Updated";
			}
			else
			{
				$msg = "$userfirstname $userlastname NOT Updated" . mysqli_error($mysqli); 
			}
		}
		else $msg = "$useremail already exists.";
	}
}
elseif (isset($_POST['deleteuser'])) 
{
	if ($_POST['email'] == NULL) 			    $msg = "Email field is empty";			   else $oldemail = $_POST['email'];
	$newemail = "deleted-" . $oldemail . "-deleted";
	$password = random_str(150);
	$query = "UPDATE User SET
			Email			= '$newemail',
			Password 		= '$password'
				WHERE UserID 	= '$useruserID'";
									  
		$result = $mysqli->query($query);
		if ($result) {
			$rows = mysqli_affected_rows($mysqli);
			$msg = "User $userfirstname $userlastname Deleted";
		}
		else
		{
			$msg = "$userfirstname $userlastname NOT Deleted" . mysqli_error($mysqli); 
		}
	
}
else
{
		
	$result = $mysqli->query("SELECT FName, LName, Email, Company_Name, Telephone, UserType, Value_Multiplier FROM user WHERE UserID ='$useruserID'");
		
	if ( $result->num_rows == 1 )
	{
		list($userfirstname, $userlastname, $useremail, $usercompanyname, $usertelephone, $userUserType, $userValueMult) = $result->fetch_row();
	}
	else
	{
		$msg = "User does not exist";
	}
}		
?>