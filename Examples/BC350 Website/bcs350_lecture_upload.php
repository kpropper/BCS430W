<?php
// bcs350_lecture_upload.php - Lecture Upload
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');
  require('bcs350_faculty.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');
  
// Variables
  $task = "First";
  $pgm = "bcs350.php?p=lecture_upload";
  $quote = array("'" => "&#039;", 
				 '"' => "&quot;", 
				 '“' => "&quot;", 
				 '”' => "&quot;");
  $msg = $err_msg = NULL;
  $err_code = 0;

// Input
  if (isset($_GET['r']))	{$rowid = $_GET['r']; $task = "Show";}	else $rowid = NULL;
  
// If SUBMIT, Get Form Input
  if (isset($_POST['Submit'])) {
    $rowid 		= trim($_POST['rowid']);
    if ($rowid == NULL) $task = "Add"; else $task = "Update";
	$lecture 	= $_POST['lecture'];
	$title 		= trim(strtr($_POST['title'], $quote));
	$file		= $_POST['hfile'];
	}
	
// Determine Filename for Submitted Lecture
  if ($task == "Add") {    
	$query = "SELECT rowid FROM lectures ORDER BY rowid DESC LIMIT 1";
    $result = $mysqli->query($query);
    list($rowid) = $result->fetch_row();
    $rowid++;
	}

// Upload Lecture
  if (isset($_FILES['file']['tmp_name'])) {
    $var = "file";
    $dir = "lectures/";
    $ext = array(".txt", ".doc", ".docx", ".jpg", ".gif", ".png", ".pdf", ".xls", ".xlsx", ".ppt", ".pptx");	
    $fn = $rowid;
	$max = 10000000;
    list($err_code, $err_msg) = upload($var, $dir, $ext, $fn, $max);
	}

// Process Request
  switch($task) {
  
// Add 
  case "Add":  
	  if ($err_code == 0) {
	  $file = $err_msg;
	  $query = "INSERT INTO lectures SET
				lecture =	'$lecture',
				title = 	'$title',
				file = 		'$file'";
      $result = $mysqli->query($query);
	  $rowid = $mysqli->insert_id;
	  if ($fn != $rowid) $msg = "Filename Error";
        else $msg = "Lecture [$dir$file] uploaded";
	  }
	  else $msg = "<font color='red'>Error Code = $err_code: $err_msg</font>";
	  break;

// Update
  case "Update":
	  if ($err_code == 0) {
	  $file = $err_msg;
	  $query = "UPDATE lectures SET
				lecture =	'$lecture',
				title = 	'$title',
				file = 		'$file'
				WHERE rowid = '$rowid'";
      $result = $mysqli->query($query);
	  $msg = "Lecture [$dir$file] uploaded";
	  }
	  else $msg = "<font color='red'>Error Code = $err_code: $err_msg</font>";
	  break;	

// Show
  case "Show":
	  $query = "SELECT rowid, lecture, title, file 
				FROM lectures
				WHERE rowid = '$rowid'";
      $result = $mysqli->query($query);
	  list($rowid, $lecture, $title, $file) = $result->fetch_row();
	  $msg = "Make Changes and Press SUBMIT";
	  break;	
	  
// First
  case "First":
  default:
	  $lecture = $title = NULL;	  
	  $msg = "Select File and Press SUBMIT";
	  break;
	  }
	  
// Output Page
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='0' class='text'><tr><td>
		<br><center><font size='+1'>Lecture Upload</font><center><br><br>
		<form action='$pgm' enctype='multipart/form-data' method='post'>
		<table align='center' width='$width'>
		<tr><td>ROWID</td><td><input type='text' name='rowid' size='5' maxlength='5' value=$rowid></td></tr>
		<tr><td>Lecture</td><td><select name='lecture'><option> </option>";
  foreach($lectures as $key => $value) {
    if ($key == $lecture) $se = "SELECTED"; else $se = NULL;
	echo "<option value='$key' $se>Week $key - $value</option>\n";
	}
  echo "</select></td></tr>
		<tr><td>Title</td><td><input type='text' name='title' size='30' maxlength='30' value='$title'></td></tr>
		<tr><td>File</td><td>$file <input type='file' name='file'><input type='hidden' name='hfile' value='$file'></td></tr>
		</table><br>
		<center><input type='submit' name='Submit' value='Submit' style='color:white;background-color:blue;font-weight:bold'></center>
		</form><br>
		<center>Message: $msg</center>
		</td></tr></table>";		
	
?>		