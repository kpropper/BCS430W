<?php
// bcs350_hw_submit.php -Homework Dropbox
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php and Student or Faculty logon
  require('bcs350_landing.php');
  require('bcs350_student.php');

// Connect MySQL and Database
  include('bcs350_mysql_connect.php');
  
// Variables
  $pgm = "bcs350.php?p=hw_submit";
  $quote = array("'" => "&#039;", 
				 '"' => "&quot;", 
				 '“' => "&quot;", 
				 '”' => "&quot;");
  $msg = NULL;
  $date = date("Y/m/d");
  
// If SUBMIT, Get Form Input
  if (isset($_POST['Submit'])) {
	$lecture = 	$_POST['lecture'];
	$date = 	$_POST['date'];
	$comments =	trim(strtr($_POST['comments'], $quote));
	
// Determine Filename for Submitted Homework
    $query = "SELECT rowid FROM homework ORDER BY rowid DESC LIMIT 1";
    $result = $mysqli->query($query);
    list($rowid) = $result->fetch_row();
    $rowid++;

// Upload Homework
    $var = "homework";
    $dir = "homework/";
    $ext = array(".txt", ".doc", ".docx", ".jpg", ".gif", ".png", ".pdf", ".xls", ".xlsx");	
    $fn = $rowid;
	$max = 10000000;
    list($err_code, $err_msg) = upload($var, $dir, $ext, $fn, $max);
	
// Update Homework Table
    if ($err_code == 0) {
	  $file = $err_msg;
	  $query = "INSERT INTO homework SET
				student = 	'$sstudent',
				lecture =	'$lecture',
				date = 		'$date',
				file = 		'$file',
				comments = 	'$comments'";
      $result = $mysqli->query($query);
	  $rowid = $mysqli->insert_id;
	  if ($fn != $rowid) $msg = "Filename Error";
        else $msg = "Homework [$dir$file] uploaded";
	  }
	  else $msg = "<font color='red'>Error Code = $err_code: $err_msg</font>";
    }

// No submit, first pass
    else {
	  $lecture = $comments = NULL;
	  $msg = "Select File and Press SUBMIT";
	  }
	  
// Output Page
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='0'><tr><td>
		<center><font size='+1'>Homework Dropbox</font><center><br><br>
		<form action='$pgm' enctype='multipart/form-data' method='post'>
		<table align='center' width='$width'>
		<tr><td>Student</td><td><input type='text' name='student' value='$sname' size='30' maxlength='30' READONLY></td></tr>
		<tr><td>Lecture</td><td><select name='lecture'><option> </option>";
  foreach($lectures as $key => $value) {
    if ($key == $lecture) $se = "SELECTED"; else $se = NULL;
	echo "<option value='$key' $se>Week $key - $value</option>\n";
	}
  echo "</select></td></tr>
		<tr><td>Date</td><td><input type='text' name='date' value='$date' size='10' maxlength='10' READONLY></td></tr>
		<tr><td>Homework</td><td><input type='file' name='homework'></td></tr>
		<tr><td width='20%' align='right'>Comments</td><td><textarea name='comments' cols='80' rows='4'>$comments</textarea></td></tr>
		</table><br>
		<center><input type='submit' name='Submit' value='Submit' style='color:white;background-color:blue;font-weight:bold'></center>
		</form><br><br>
		<center>Message: $msg</center>
		</td></tr></table>";		
	
?>		