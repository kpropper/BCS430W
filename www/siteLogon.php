<?PHP

// Variables
  $msg = NULL;			// Error Message

// Get Form Input
if (isset($_POST['message'])) 			$msg = $_POST['message'];

  if(isset($_POST['logon'])) {
    if (isset($_POST['message'])) 			$msg = $_POST['message'];  else $msg = "Why am I here?";
	if ($_POST['email'] == NULL) 			$msg = "Email field is empty";
    if ($_POST['password'] == NULL) 			$msg = "Password field is missing";
    if (($_POST['email'] == NULL) AND ($_POST['password'] == NULL)) $msg = "Email and Password fields are empty";

	if ($msg == NULL) {

     // include('sqlConnect.php');

	include("sqlConnect.php");

    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM user WHERE Email='$email'");

    if ( $result->num_rows == 0 ){ // User doesn't exist
        $msg = "User with that email doesn't exist!";
      //  header("location: error.php");
    }
    else { // User exists
        $user = $result->fetch_assoc();

        if ($_POST['password'] == $user['Password'])  {

            $_SESSION['email'] = $user['Email'];
            $_SESSION['first_name'] = $user['FName'];
            $_SESSION['last_name'] = $user['LName'];

            // This is how we'll know the user is logged in
            //$_SESSION['logged_in'] = true;

            $msg = "Logged in";
        }
        else {

            $msg = "You have entered wrong password, try again!";
            //header("location: error.php");
        }



}
}
}

?>
