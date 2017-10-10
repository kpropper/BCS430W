<?php
// bcs350_rss.php - FSC RSS News Feed
// Written by:  Charles Kaplan, June 2015

// Verify that program was called from bcs350_php
  require('bcs350_landing.php');

// RSS News Feed
  require_once "../XML/RSS.php";
  $rssnews = "http://www.farmingdale.edu/rss/news-2015.xml";
  $rss =& new XML_RSS($rssnews);
  $rss->parse();
  
// Output Page  
  echo "<table width='$width' align='center' bgcolor='white' cellspacing='0' class='text'><tr><td>\n
		<br><center><font size='+1'>Farmingdale State College RSS News Feed</font><center><br><br>\n
		<table width='650' align='left' cellpadding='0'>\n";
  $i = 1;	
  foreach ($rss->getItems() as $item) {
    echo "<tr><td><font face='arial,helvetica' color='#555453' size='2'>\n
		  <a href=\"" . $item['link'] . "\"><b>" . $item['title'] . "</b></a><br>" . $item['pubdate'] . " - " . 
	      $item['description'] . "</font></td></tr>\n";
    $i = $i + 1;
	if ($i > 20) break;  // Show 20 most recent feeds
	}
  echo "</table>\n";
?>
