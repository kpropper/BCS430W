<?php
// bcs350_header.php - Page Header
// Written by:  Charles Kaplan, May 2015

//HTML HEAD
echo "
<!DOCTYPE html> 
<html>
<head>
<title>BCS350 - Web DataBase Design - Home Page</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<META NAME='RESOURCE-TYPE' CONTENT='DOCUMENT'>
<META NAME='DISTRIBUTION' CONTENT='GLOBAL'>
<META NAME='AUTHOR' CONTENT='Charles Kaplan'>
<META NAME='COPYRIGHT' CONTENT='Copyright (c) by Charles Kaplan'>
<META NAME='DESCRIPTION' CONTENT='Education website for teaching BCS350 - Web Database Design'>
<META NAME='KEYWORDS' CONTENT='PHP MySQL HTML CSS BCS350 Web Database Design Farmingdale State College'>
<META NAME='ROBOTS' CONTENT='INDEX, FOLLOW'>
<META NAME='ROBOTS' CONTENT='ALL'>
<META NAME='REVISIT-AFTER' CONTENT='1 DAYS'>
<META NAME='RATING' CONTENT='GENERAL'>
<META NAME='GENERATOR' CONTENT='Copyright (c) 2015 by Charles Kaplan'>
<link rel='stylesheet' type='text/css' href='bcs350.css'>

<STYLE><!--
A {text-decoration: none;}
A:hover {text-decoration: underline;}
TD {font: Arial,Arial MT,Arial Narrow,Trebuchet MS,Helv,Helvetica,Monaco,MS Sans Serif;}
 
 P {  
    font-style: normal; 
    font-weight: normal; 
    font-size: 11px; 
    font-family: Tahoma, Verdana, Arial, Helvetica, san-serif;
 }
 --></STYLE>
</head>
<BODY bgColor='#878581' text='black' link='#555453' vlink='#555453' alink='red'>
<a name='top'></a><br>";

// Alternating Message
  if ((!isset($_SESSION['message'])) OR ($_SESSION['message'] > 10)) {
    $_SESSION['message'] = 0;
	echo "<table width='$width' bgcolor='green' align='center' cellspacing='10' frame='border' border='1'>
		  <tr><td align='center'><font color='white'><i><b>
			This website was written as an educational tool for teaching BCS350 - Web Database Design at
			Farmingdale State College. The website can be used for an instructor to administer the class,
			including all interactions with students and the public.
			<p>For more information, please visit the college's website - 
			  <a href='http://www.farmingdale.edu'><img src='$pixdir/fsc-header-logo.gif'></a>
		  </b></i></font>
		  </td></tr></table>";
	}
  $_SESSION['message']++; 

// HTML BODY	
echo "
<TABLE BORDER='0' CELLPADDING='10' CELLSPACING='0' WIDTH='$width' BGCOLOR='#ffffff' align='center'>
  <tr>
  <td align='center'  valign='top' bgcolor='white' width='30%'>
	<a href='bcs350.php'>
	<img src='$pixdir/fsc-header-logo.gif' border='0'></a>
  </td>
  
  <td align='left' bgcolor='#BDBCBB' valign='middle' width='80%'>
	<font face='arial,helvetica' color='white' size=6><b>BCS350 - Web Database Design</b></font>
	<br>
	<font face='arial,helvetica' color=#555453 size=2><b>An educational website for teaching PHP and MySQL</b></font>
 </tr>
 </table>
  	
  	
<TABLE BORDER='0' CELLPADDING='1' CELLSPACING='0' WIDTH='$width' BGCOLOR='#C9E3FA' align='center'>
  <TR>
  <TD align='left' bgcolor='#717171' valign='middle' width='80%'> 	
    <b><center><font color='#CECCCA' face='Tahoma, Verdana, Arial, Helvetica, san-serif' size=3><i>
    A website for the Instructor, Students and the Public</i></font></center></b>
  </TD></TR>
</TABLE>
";
?>