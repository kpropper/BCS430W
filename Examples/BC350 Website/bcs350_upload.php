<?php
// bcs350_upload.php - File Upload Function
// Written by:  Charles Kaplan, June 2015

// Inputs
// $var	- Name of $_POST variable to upload
// $dir - Directory to store file
// $ext - Array of valid file extensions for this upload
// $fn -  Filename for stored file
// $max - Maximum File Upload Size (bytes)

// Outputs
// 1) error code: 0 = success, otherwise > 0 = failure
// 2) error msg:  filename (success), Error Message (failure)

function upload($var, $dir, $ext, $fn, $max) {
// echo "VAR [$var], DIR [$dir], EXT [$ext], FN [$fn], MAX [$max]<br><br>";

// Local Variables 
  $msg = NULL;
  $error = 0;
  $fn2 = $fn;

// Validate Input
// $var - Name of $_POST variable to upload
  //$var = "'$var'";
  if (!isset($_FILES[$var]['tmp_name']))
    $msg .= "POST variable $var does not exist. ";
	
// $dir - Directory to store file
  if (substr($dir, -1, 1) != "/")
    $dir .= "/";
  if (!file_exists($dir)) 
    $msg .= "Directory $dir does not exist. ";
	else if (is_file($dir))
	  $msg .= "$dir is a file, not a directory. ";

// $ext - Array of valid file extensions for this upload
  if (!is_array($ext))
	$msg .= "$ext is not an array of valid Extensions. ";

// $fn -  Filename for stored file
  if ($fn2 == "original") $fn = $_FILES[$var]['name'];
//  $fn = strtolower($fn);
//  if(!preg_match('/^[a-z0-9-]+$/',$fn))
//    $msg .= "Invalid filename [$fn]. ";

// $max - Maximum File Upload Size (bytes)
  if($max < 1)
    $msg .= "Invalid Maximum File Upload Size [$max]. ";

// Set Error Code if Validation Error
  if ($msg != NULL)
	$error = 9;
  	
// Check File Upload Error Code
  if ($_FILES[$var]['error'] > 0) {
    $error = $_FILES[$var]['error'];
	$msg .= "File Upload Failed, Error Code = $error. ";
	}
	
// Validate Uploaded File Information
  if ($msg == NULL) {
  
// Check File Size	 
	$size = $_FILES[$var]['size'];
	if ($size == 0)
	  $msg .= "Invalid File Size - 0 [zero]. ";
	$upload_max_filesize = 1000000 * substr(ini_get('upload_max_filesize'),0,-1);	
	if ($max > $upload_max_filesize)
	  $max = $upload_max_filesize;
	if ($size > $max) {
	  $msg .= "Uploaded File Size [$size] greater than Maximum allowed File Size [$max]. ";
	  $error = 10;
	  }
	   
// Check for uploaded file valid file extension
	$extn = strtolower(trim(strrchr(trim($_FILES[$var]['name']), ".")));
	if (!in_array($extn, $ext)) {
	  $msg .= "File Type [$extn] is invalid. ";
	  $error = 11;
	  }
	}
	
// If no error messages, move file
	if ($msg == NULL) {
	  if ($fn2 == "original") $file = $fn;
	    else $file = $fn . $extn;
      $result = move_uploaded_file($_FILES[$var]['tmp_name'], $dir.$file);
	  if ($result) 
	    $msg = $file;
		else {
	      $msg = "File Move Failed";
		  $error = 12;
		  }
	  }
	
// End of Function
  return(array($error, $msg));
  }  
	
?>	 