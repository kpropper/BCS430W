<?php
// bcs350_rss.php - RSS News Feed
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');

// Variables
  $z = array("-0000" => NULL,
			 "+0000" => NULL);

// Get News Feed	
  require_once "XML/RSS.php";
  $rss = new XML_RSS("http://www.farmingdale.edu/rss/news-2015.xml");
  $rss->parse();
	
// Output Page  	
  echo "<table align='center' width='$width' bgcolor='white' cellspacing='10' class='text'><tr><td> 
		<font size='+1'><b>Farmingdale State College RSS News Feed</b></font<br><br>";	
  echo "<table width='100%' align='center' cellpadding='1'>";

// Loop Through Feeds  
  $i = 1;	
  foreach ($rss->getItems() as $item) {
	//foreach ($item as $key => $value) echo "KEY [$key], VALUE [$value]<br>";
    if (isset($item['pubdate'])) 		$pubdate = strtr(trim($item['pubdate']), $z); else $pubdate = NULL;
	if (isset($item['description'])) 	$description = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $item['description']); else $description = NULL;
	if (isset($item['title'])) 		$title = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $item['title']); else $title = NULL;
	if (isset($item['link'])) 		$link = $item['link']; else $link = NULL;	  
	echo "<tr><td class='text'>&nbsp;</td></tr>
		  <tr><td class='text'>\n
		  <a href=\"$link\" target='_blank'><b><u>$title</u></b></a><br>$pubdate - $description</td></tr>\n";
    $i++;
	if ($i > 25) break;
	}
  echo "</table>\n
		<br></td></tr></table>";
?>