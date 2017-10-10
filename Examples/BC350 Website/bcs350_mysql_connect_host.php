<?php
// bcs350_mysql_connect.php - Logon to MySQl and connect to the BCS350 database
// Written by: Charles Kaplan, May 2015

// Connect to MySQL and the personal Database
  $mysqli = new mysqli('db589593745.db.1and1.com', 'dbo589593745', 'smart123', 'db589593745');
  if ($mysqli->connect_error)
    die('Connect Error: ' . $mysqli->connect_error);	
?>   