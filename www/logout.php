<?php
//connect to the session
session_start();

//remove all session variables
session_unset();

//destrot the session
session_destroy();

//send user back to the homepage
echo "<script> location.href='index.php'; </script>";
?>