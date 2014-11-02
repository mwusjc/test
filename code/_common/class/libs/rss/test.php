<?php

require_once("rss_fetch.inc");
	$url = "http://www.sustainability.com/rss/latestresources.xml";
	$rss = fetch_rss( $url );

	echo "Channel Title: " . $rss->channel['title'] . "<p>";
	echo "<ul>";
	foreach ($rss->items as $item) {
		$href = $item['link'];
		$title = $item['title'];
		echo "<li><a href=$href>$title</a></li>";
	}
	echo "</ul>";

?>>