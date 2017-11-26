<?PHP
include("sqlConnect.php");

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