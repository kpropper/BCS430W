<?PHP

// Variables
$msg       = NULL; // Error Message
$loginpage = "login.php";

// Get Form Input
if (isset($_POST['register'])) {
    if ($_POST['email'] == NULL) {
        $msg = "Email field is empty " ;
    } else
        $email = 'email';
    if ($_POST['password'] == NULL) {
        $msg = "Password field is missing " ;
    } elseif (strlen($_POST['password']) <= 6) {
        $msg = "Password Length to short " ;
    } else
        $password = $_POST['password'];
    if ($_POST['verifypassword'] == NULL) {
        $msg = "Verify Password field is missing " ;
    }
    if ($_POST['firstname'] == NULL) {
        $msg = "First Name field is missing " ;
    } else
        $firstname = $_POST['firstname'];
    if ($_POST['lastname'] == NULL) {
        $msg = "Last Name field is missing " ;
    } else
        $lastname = $_POST['lastname'];
    if ($_POST['companyname'] == NULL) {
        $msg = "Company Name field is missing " ;
    } else
        $companyname = $_POST['companyname'];
    if ($_POST['phone'] == NULL) {
        $msg = "Phone Number field is missing " ;
    } else
        $phone = $_POST['phone'];
    if (!($_POST['password'] == $_POST['verifypassword'])) {
        $msg = "The passwords do not match " ;
    }
    if(($_POST['email'] == NULL)&&($_POST['password'] == NULL)&&($_POST['verifypassword'] == NULL)&&($_POST['firstname'] == NULL)&&($_POST['lastname'] == NULL)&&($_POST['companyname'] == NULL)&&($_POST['phone'] == NULL))
        $msg = "All fields are empty";

    if ($msg == NULL) {
        include("sqlConnect.php");

        $email  = $mysqli->escape_string($_POST['email']);
        $result = $mysqli->query("SELECT * FROM user WHERE Email='$email'");

        if ($result->num_rows == 0) {
            $query  = "INSERT INTO user SET
                      FName = '$firstname',
                      LName = '$lastname',
                      Email = '$email',
                      Password = '$password',
                      Company_Name = '$companyname',
                      Telephone = '$phone',
                      Value_Multiplier = '.5',
                      UserType = 'Client'";
            $result = $mysqli->query($query);
            if ($result) {
                $msg = "$email has been registered";
                echo "<form id='registration_success' action='$loginpage' method='post'>
                      <input type='hidden' name='message' value='$msg'>
                      </form>

                      <script type='text/javascript'>
                        document.getElementById('registration_success').submit();
                      </script>";
            } else {
                $msg = "Registration failed " . mysqli_error();
            }
        }

        else {
            // Email already exists
            $msg = "User with that email already exists";
        }

    }
}
?>
