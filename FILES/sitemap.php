<?php
include("settings.php");

header("Content-type: text/xml");

$XML_Content = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

$XML_Content .= "<url><loc>".$siteUrl."/</loc></url>".
"<url><loc>".$siteUrl."/categories/movies/</loc></url>".
"<url><loc>".$siteUrl."/most-popular-movies</loc></url>".
"<url><loc>".$siteUrl."/top-rated-movies</loc></url>".
"<url><loc>".$siteUrl."/latest-movies</loc></url>";

$imdb7id=$conn->query("select * from categories order by id desc");
while($_7 = $imdb7id->fetch_assoc()){
	$u=createPageName($_7["cateName"])."/".$_7["id"]."/";
	$XML_Content .= "<url><loc>".$siteUrl."/movies/".$u."</loc></url>\n";
}
$imdb7id2=$conn->query("select id from movies order by id desc");
while($_72 = $imdb7id2->fetch_assoc()){
	$XML_Content .= "<url><loc>".$siteUrl.createMovieLink($_72["id"],$conn)."/</loc></url>\n";
}

$conn->close();
$XML_Content .= "</urlset>";
$XML_Content=str_replace("<url><loc></loc></url>","",$XML_Content);

echo($XML_Content);
?>