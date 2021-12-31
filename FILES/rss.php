<?php
include("settings.php");

header("Content-type: text/xml");

$XML_Content = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"><channel><title>Recently Added Movies (RSS) - '.$_g_siteName.'</title><link>/rss</link><description>You are seeing the last 30 movies added.</description>';

//movies
$rssf=$conn->query("select id,movie_name,short_desc from movies order by id desc limit ".$_g_RSSMovieCount);
while($_72 = $rssf->fetch_assoc()){
	$XML_Content .= "<item><title>".$_72["movie_name"]."</title><description>".$_72["short_desc"]."</description><link>".$siteUrl.createMovieLink($_72["id"],$conn)."/</link></item>\n";
}

$conn->close();
$XML_Content .= "</channel></rss>";

echo($XML_Content);
?>