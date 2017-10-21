<?php

  $msg = NULL;
  if(isset($_POST['signup'])) {
    //Checking if not nullable fields are empty
    if ($_POST['email'] == NULL) 			$msg = "Email field is empty";
    if ($_POST['password'] == NULL) 			$msg = "Password field is empty";
    //if ($_POST['verifypassword'] == NULL)  $msg = "Verify Password field is empty";
    if ($_POST['first'] == NULL)  $msg = "First Name field is empty";
    if ($_POST['last'] == NULL)  $msg = "Last Name field is empty";
    if ($msg == NULL) {
      $mysqli = new mysqli('localhost', 'root', '', 'itamg');

	    if ($mysqli->connect_error)		     die('Connect Error: ' . $mysqli->connect_error);

      if(isset($_POST['signup'])) {
        //set all session var's to be used in register.php
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['first_name'] = $_POST['first'];
        $_SESSION['last_name'] = $_POST['last'];
        $_SESSION['password'] = $_POST['password'];
        //$_SESSION['verify'] = $_POST['verifypassword'];
        $_SESSION['company_name'] = $_POST['companyname'];
        $_SESSION['phonenum'] = $_POST['phone'];

        //if (($_POST['password']) != ($_POST['verifypassword']) ) $msg "Password's don't match";

        $first_name = $mysqli->escape_string($_POST['first']);
        $last_name = $mysqli->escape_string($_POST['last']);
        $email = $mysqli->escape_string($_POST['email']);
        $password = $mysqli->escape_string($_POST['password']);
        $company = $mysqli->escape_string($_POST['companyname']);
        $phone = $mysqli->escape_string($_POST['phone']);
        //$hash = $mysqli->escape_string( md5( rand(0,1000) ) );


  // Check if user with that email already exists
  $result = $mysqli->query("SELECT * FROM test WHERE Email='$email'") or die($mysqli->error());



  // We know user email exists if the rows returned are more than 0
  if ( $result->num_rows > 0 ) {
      $msg = "User with that email already exists";
  }
  else { // Email doesn't already exist in a database, proceed...

      // active is 0 by DEFAULT (no need to include it here)
      $sql = "INSERT INTO test ( FName, LName, Email, Password, Company_Name, Telephone )"
              . "VALUES ('$first_name','$last_name','$email','$password','$company', '$phone')";

      // Add user to the database
      if ( $mysqli->query($sql) ){

          $_SESSION['active'] = 0; //0 until user activates their account with verify.php
          $_SESSION['logged_in'] = true; // So we know the user has logged in
          $msg =  "Registration Succesful!";
      }

      else {
          $msg = 'Registration Failed!';
      }

    }
      }
      }

}
?>
