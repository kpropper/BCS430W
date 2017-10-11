<?php
// bcs350_functions.php - String Handling Functions
// Written by:  Prof. Kaplan, Sept. 2016

// cleanse_input - sanitize input and reformat 
	function cleanse_input($phrase, $format) {
		$phrase = filter_var($phrase, FILTER_SANITIZE_STRING);
		$format = trim($format);
		$format_length = strlen($format);
	
		for ($i=0; $i<$format_length; $i++) {
			$letter = substr($format, $i, 1);
		
			switch($letter) {
				case "a":	$phrase = preg_replace("/[^a-zA-Z ]+/", "", $phrase); break;// Remove any non-alphabetic characters
				case "e":	$phrase = ltrim($phrase);		break;						// Left Trim
				case "f":	$phrase = ucfirst($phrase);		break;						// Capitolize First Word
				case "i":	$phrase = preg_replace('/\s+/', ' ', $phrase);	break;		// Internal Trim
				case "l":	$phrase = strtolower($phrase);	break;						// Lower Case
				case "n":	$phrase = preg_replace("/[^0-9.]+/", "", $phrase); break;	// Remove any non-numeric characters
				case "r":	$phrase = rtrim($phrase);		break;						// Right Trim
				case "s":	$phrase = strip_tags($phrase);	break;						// Remove HTML
				case "t":	$phrase = trim($phrase);		break;						// Trim
				case "u":	$phrase = strtoupper($phrase);	break;						// Upper Case
				case "w":	$phrase = ucwords($phrase);		break;						// Capitolize Words
				default:
				}
			}
			
		return($phrase);
		}

// count # of words is a string		
	function count_words($phrase) {
		$x = explode(' ', $phrase);
		return(count($x));
		}

// validate a phrase		
	function validate_input($phrase, $format) {
		$msg = NULL;
		switch($format) {
			case "email":		if (!filter_var($phrase, FILTER_VALIDATE_EMAIL))	$msg = "$phrase is not a valid Email Address<br>";	break;
			case "interger":	$phrase += 0;	if (!is_integer($phrase)) 	$msg = "$phrase is not an Integer<br>";		break;
			case "number":		if (!is_numeric($phrase))	$msg = "$phrase is not a Number<br>";		break;
			default:			$msg = "Invalid Validation format";		break;
			}
		return($msg);
		} 
	
?>