<?php
// Connect to MySQL and the Database
  $mysqli = new mysqli('localhost', 'root', '', 'test1');
  if ($mysqli->connect_error)
    die('Connect Error: ' . $mysqli->connect_error);	
?>  