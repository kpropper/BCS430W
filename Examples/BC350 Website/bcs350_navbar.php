<?php
// bcs350_navbar.php - BCS350 - Navigation Bar
// Written by:  Charles Kaplan, May 2015

// Verify that program was called from bcs350_php and Faculty User
  require('bcs350_landing.php');

// Variables
  $pwidth = '1030';
  
// Output Navigation Bar  
  echo "<table width='$pwidth' align='center'><tr><td><div>\n";
		
// Links for Style Sheet and JavaScript Functions
// Link to styles used for our Navigation Bar
  echo "<link href=\"bcs350_NavBarStyles.css\" rel=\"stylesheet\" type=\"text/css\">\n";

// Link to a file with couple simple JavaScript functions used for our Navigation Bar
  echo "<script src=\"bcs350_NavBarScripts.js\" language=\"JavaScript\" type=\"text/javascript\"></script>\n";


// main nav bar titles
// Note how the the closing angle bracket of each </a> tag runs up against the next <a> tag,
//   to avoid leaving a gap between each menu title and the next one.

// REPLACE each "placeholder.php" URL below with the specific page you want the user
//   to go to when the given menu title is clicked. For example, the first link below
//   is for the "Home" menu title, so you\"d probably replace the first URL with index.html

  echo "<div class='mynavbar'>
		<a class='navbartitle' id='t1' href='bcs350.php?p=home'
		onMouseOut=\"HideItem('meeting_submenu');\"
        onMouseOver=\"ShowItem('meeting_submenu');\"
		>FSC Info </a>\n";
		
  echo "<a class='navbartitle' id='t2' href='bcs350.php?p=info'
		onMouseOut=\"HideItem('membership_submenu');\"
		onMouseOver=\"ShowItem('membership_submenu');\"
		>Course Information </a>\n";
		
  echo "<a class='navbartitle' id='t3' href='bcs350.php?p=logon'
		onMouseOut=\"HideItem('org_submenu');\"
		onMouseOver=\"ShowItem('org_submenu');\"
		>Logon </a>\n";
		
if (($logon) AND ($page != "bcs350_logoff.php"))	
  echo "<a class='navbartitle' id='t4' href='bcs350.php?p=student'
		onMouseOut=\"HideItem('tech_submenu');\"
		onMouseOver=\"ShowItem('tech_submenu');\"
		>Students </a>\n";
  else echo "<a class='navbartitle' id='t4' href=''
			 ><font color='red'>Students </font></a>\n";

if (($srole == "Faculty") AND ($page != "bcs350_logoff.php"))			 
  echo "<a class='navbartitle' id='t5' href='bcs350.php?p=inst'
		onMouseOut=\"HideItem('contact_submenu');\" 
		onMouseOver=\"ShowItem('contact_submenu');\"
		>Instructor </a>\n";
  else echo "<a class='navbartitle' id='t5' href='bcs350.php?p=inst'
			><font color='red'>Instructor </font></a>\n";

// REPLACE each "placeholder.php" URL below with the specific page you want 
//   the user to go to when the given submenu item is clicked.

// ABOUT US sub-menu, shown as needed
  echo "<div class='submenu' id='meeting_submenu'
		onMouseOver=\"ShowItem('meeting_submenu');\"
		onMouseOut=\"HideItem('meeting_submenu');\">\n";

  echo "<div class='submenubox'>
		<ul>
		<li><a href='bcs350.php?p=home' 													class='submenlink'>BCS350</a></li>
		<li><a href='https://www.farmingdale.edu/business/bcs/index.shtml' target='_blank'  	class='submenlink'>FSC BCS</a></li>
		<li><a href='http://www.farmingdale.edu/' target='_blank' 							class='submenlink'>FSC</a></li>
		<li><a href='https://www.suny.edu/' target='_blank'									class='submenlink'>SUNY</a></li>		
		<li><a href='bcs350.php?p=video' 													class='submenlink'>FSC Video</a></li>
		<li><a href='bcs350.php?p=rss' 														class='submenlink'>FSC RSS News Feed</a></li>		
		</ul>
		</div>
		</div>\n";

// RESOURCES Pages sub-menu, shown as needed */
  echo "<div class='submenu' id='membership_submenu'
		onMouseOver=\"ShowItem('membership_submenu');\" 
		onMouseOut=\"HideItem('membership_submenu');\">\n";
		
  echo "<div class='submenubox'>
		<ul>
		<li><a href='bcs350.php?p=overview' 	class='submenlink'>Overview </a></li>
		<li><a href='bcs350.php?p=syllabus' 	class='submenlink'>Syllabus </a></li>
		<li><a href='bcs350.php?p=textbook' 	class='submenlink'>Textbook </a></li>
		<li><a href='bcs350.php?p=schedule' 	class='submenlink'>Schedule </a></li>
		<li><a href='bcs350.php?p=location' 	class='submenlink'>Location </a></li>		
		</ul>
		</div>
		</div>\n";

// NEWS sub-menu, shown as needed */
  echo "<div class='submenu' id='org_submenu'
		onMouseOver=\"ShowItem('org_submenu');\" 
		onMouseOut=\"HideItem('org_submenu');\">\n";
  
  echo "<div class='submenubox'>
		<ul>
		<li><a href='bcs350.php?p=logon' 		class='submenlink'>Logon </a></li>
		<li><a href='bcs350.php?p=logoff' 		class='submenlink'>Logoff </a></li>		
		</ul>
		</div>
		</div>\n";

// SHOP sub-menu, shown as needed */
if (($logon) AND ($page != "bcs350_logoff.php")) {			
  echo "<div class='submenu' id='tech_submenu' 
		onMouseOver=\"ShowItem('tech_submenu')\" 
		onMouseOut=\"HideItem('tech_submenu');\">\n";
  
  echo "<div class='submenubox'>
		<ul>
		<li><a href='bcs350.php?p=lecture' 		class='submenlink'>Lectures </a></li>
		<li><a href='bcs350.php?p=hw_student'	class='submenlink'>Homework </a></li>
		<li><a href='bcs350.php?p=grades' 		class='submenlink'>Grades </a></li>
		<li><a href='bcs350.php?p=roster' 		class='submenlink'>Class Roster </a></li>
		<li><a href='bcs350.php?p=profile' 		class='submenlink'>Profile </a></li>		
		</ul>
		</div>
		</div>\n";
  }

// SUPPORT sub-menu, shown as needed
if (($srole == "Faculty") AND ($page != "bcs350_logoff.php")) {
  echo "<div class='submenu' id='contact_submenu' 
		onMouseOver=\"ShowItem('contact_submenu');\" 
		onMouseOut=\"HideItem('contact_submenu');\">\n";
		
  echo "<div class='submenubox'>
		<ul>
		<li><a href='bcs350.php?p=lecture_update'	class='submenlink'>Lecture Update </a></li>
		<li><a href='bcs350.php?p=hw_list'			class='submenlink'>Grade Homework </a></li>
		<li><a href='bcs350.php?p=assign_grades' 	class='submenlink'>Assign Grades </a></li>
		<li><a href='bcs350.php?p=view_grades' 		class='submenlink'>View Grades </a></li>		
		<li><a href='bcs350.php?p=roster' 			class='submenlink'>Class Roster </a></li>
		<li><a href='bcs350.php?p=profile' 			class='submenlink'>Profile </a></li>		
		</ul>
		</div>
		</div>\n";
  }
		
  echo "</div>\n";

  echo "</div></td></tr></table>\n";

// ################## end of Navigation Bar ###################

?>