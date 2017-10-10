<?php
// bcs350_hw_grade.php - Grade Homework
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php and Faculty User
  require('bcs350_landing.php');
  require('bcs350_faculty.php');
  
// Connect MySQL and Database
  include('bcs350_mysql_connect.php');
  
// Variables
  $pgm = "bcs350.php?p=hw_grade";
  $quote = array("'" => "&#039;", 
				 '"' => "&quot;", 
				 '“' => "&quot;", 
				 '”' => "&quot;");
  $msg = NULL;
  $date = date("Y/m/d");
  $dir = "homework/";
  
// Get Input - Homework
  if (isset($_GET['r']))	$hw = $_GET['r'];
    else {
    header("Location: bcs350.php"); 
	exit;
	}    
  
// If SUBMIT, Get Form Input
  if (isset($_POST['Submit'])) {
	$lecture = 	$_POST['lecture'];
	$date = 	$_POST['date'];
	$file = 	$_POST['file'];
	$grade = 	$_POST['grade'];
	$comments =	trim(strtr($_POST['comments'], $quote));
	
// Update Homework Table
    $query = "UPDATE homework SET
  			  student 	= '$sstudent',
			  lecture 	= '$lecture',
			  status 	= '$grade',
			  comments 	= '$comments'
			  WHERE rowid='$hw'";
    $result = $mysqli->query($query);
    $msg = "Homework Graded";
	}

// No submit, first pass
    else {
	  $query = "SELECT student, lecture, date, file, status, comments
				FROM homework
				WHERE rowid='$hw'";
	  $result = $mysqli->query($query);
	  list($student, $lecture, $date, $file, $grade, $comments) = $result->fetch_row();
	  $msg = "Grade homework and Press SUBMIT";
	  }
	  
// Output Page
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='0' class='text'><tr><td>
		<br><center><font size='+1'>Grade Homework</font><center><br><br>
		<form action='$pgm&r=$hw' enctype='multipart/form-data' method='post'>
		<table align='center' width='$width'>
		<tr><td>Student</td><td><input type='text' name='student' value='$sname' size='30' maxlength='30' READONLY></td></tr>
		<tr><td>Lecture</td><td><select name='lecture'><option> </option>";
  foreach($lectures as $key => $value) {
    if ($key == $lecture) $se = "SELECTED"; else $se = NULL;
	echo "<option value='$key' $se>Week $key - $value</option>\n";
	}
  $extn = strrchr($file, ".");
  if (($extn == ".jpg") OR ($extn == ".gif") OR ($extn == ".png"))	$target = " target='_blank' ";	else $target = NULL;
  if ($grade == 0) 	$grade = NULL;
  echo "</select></td></tr>
		<tr><td>Date</td><td><input type='text' name='date' value='$date' size='10' maxlength='10' READONLY></td></tr>
		<tr><td>Grade</td><td><input type='text' name='grade' value='$grade' size='3' maxlength='3'></td></tr>
		<tr><td>Homework</td><td><a href='$dir$file' $target>$file</a><input type='hidden' name='file' value='$file'></td></tr>
		<tr><td width='20%' align='right'>Comments</td><td><textarea name='comments' cols='80' rows='4'>$comments</textarea></td></tr>
		</table><br>
		<center><input type='submit' name='Submit' value='Submit' style='color:white;background-color:blue;font-weight:bold'></center>
		</form><br>
		<center>Message: $msg</center>
		</td></tr></table>";		
	
?>		