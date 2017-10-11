<?php
// bcs350_mysql_connect.php - Logon to MySQl and connect to the BCS350 database
// Written by: Charles Kaplan, May 2015

// Connect to MySQL and the personal Database
  $mysqli = new mysqli('localhost', 'root', '', 'bcs350');
  if ($mysqli->connect_error)
    die('Connect Error: ' . $mysqli->connect_error);	
?>   