<?php
session_start();ob_start();
$loadingTimeStarts = (double)microtime(1);
if ($_SERVER["REQUEST_URI"]=="/index.php" || $_SERVER["REQUEST_URI"]=="/index") {header("Location:/");die();}
else {
include("settings.php");

$s = (isset($_GET['s']) ? $_GET['s'] : null);

if ($s=="_random") {header("Location:".$siteUrl.createMovieLink(oneReg("id","movies order by rand() limit 1",$conn),$conn));die();}
	
$contentPage = "_home.php";
$_pageName_ = "4K Movie Trailer Watching Site - ";
$_pageDescription_ = $_g_siteName." is a movie trailer website that offers thousands of movies with unique features.";
$_ogImg=$siteUrl."/core/images/og.jpg";

$cateID = (isset($_GET['kid']) ? $_GET['kid'] : null);

if ($s=="_xaxmin"){
$contentPage = "admin.php";
$_pageName_="Admin - ";
}
else if ($s=="_movie"){

$_movieID = (isset($_GET['fid']) ? $_GET['fid'] : null);

$contentPage = "_movie.php";
$cateID=oneReg("movie_category","movies where id=".$conn->real_escape_string($_GET['fid']),$conn);
$_pageName_= isset($_GET['fid']) ? oneReg("movie_name","movies where id=".$conn->real_escape_string($_GET['fid']),$conn)." Movie (".oneReg("movieYear","movies where id=".$conn->real_escape_string($_GET['fid']),$conn).") - " : "";
$_pageDescription_ = isset($_GET['fid']) ? oneReg("short_desc","movies where id=".$conn->real_escape_string($_GET['fid']),$conn) : "";
$_ogImg=$siteUrl."/".oneReg("movie_cover","movies where id=".$conn->real_escape_string($_GET['fid']),$conn);
}
else if ($s=="movies"){
$contentPage = "movies.php";
if ($cateID!=""){
$cateName=oneReg("cateName","categories where id=".$conn->real_escape_string($cateID),$conn);
$_pageName_ = $cateName." - ";
$_pageDescription_="Watch 4K ".strtolower($cateName.", one part trailers.");
}
}
else if ($s=="watchHistory"){
$contentPage = "watchHistory.php";
$_pageName_="Watch History - ";
}
else if ($s=="watchList"){
$contentPage = "watchList.php";
$_pageName_="Watch List - ";
}
else if ($s=="detailed_search"){
$contentPage = "_detailed_search.php";
$_pageName_ = "Detailed Movie Search Results - ";
}
else if ($s=="search"){
$contentPage = "search.php";
$___searched=(isset($_GET['_searched']) ? $_GET['_searched'] : null);
if ($___searched!=""){
$_pageName_ = ucfirst($___searched)." - Movie Search Results - ";
$_pageDescription_="Watch 4K ".strtolower($___searched.", one part trailers.");
}
}
else if ($s=="_contact"){
$contentPage = "_contact.php";
$_pageName_="Contact - ";
}
else if ($s=="404"){
$contentPage = "404.php";
$_pageName_="404 Page Not Found - ";
}
else if ($s=="_categories"){
$contentPage = "_categories.php";
$_pageName_="All Movies - ";
$_pageDescription_="Watch 4K movies, one part trailers.";
}
else if ($s=="most"){
$contentPage = "most.php";
$_which = (isset($_GET['which']) ? $_GET['which'] : null);
if ($_which=="1"){
$_pageName_="Most Popular Movies - ";
$_pageDescription_="The 30 most popular movies are shown on ".$_g_siteName.". The popularity rate of the movies found here is determined by the total number of star scores they have received.";
}
if ($_which=="2"){
$_pageName_="Top Rated Movies - ";
$_pageDescription_="The top 30 movies are shown on ".$_g_siteName.". The rating of these movies is determined by the star scores they have received (down from 5 stars).";
}
if ($_which=="3"){
$_pageName_="Latest Movies - ";
$_pageDescription_="Shows the latest movies available on ".$_g_siteName.". The latest movies from the last year; 30 movies that met the audience in ".date("Y")." and received the most views on our site.";
}
}

$_cssAct="class=\"active\"";
 

$pgTitle = (isset($_GET['page']) ? $_GET['page'] : null);
$pg2Title = (isset($_GET['pg']) ? $_GET['pg'] : null);

if ($pgTitle!=""){
	$_pageName_ = $_pageName_."Page ".$pgTitle." - ";
}
else if ($pg2Title!=""){
	$_pageName_ = $_pageName_."Page ".$pg2Title." - ";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo($_pageName_.$_g_siteName); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo($_pageDescription_); ?>" />
<meta property="og:title" content="<?php echo($_pageName_.$_g_siteName); ?>" />
<meta property="og:description" content="<?php echo($_pageDescription_); ?>" />
<meta property="og:type" content="website" />
<meta property="og:image" content="<?php echo($_ogImg);?>" />
<meta property="og:locale" content="en_GB" />
<meta property="og:site_name" content="<?php echo($_g_siteName);?>" />
<meta property="og:url" content="<?php echo($siteUrl.$lastURL); ?>" />
<?php if ($s=="404"){?>
<meta name="robots" content="noindex,nofollow" />
<?php }?>
<link rel="canonical" href="<?php echo($siteUrl.$lastURL); ?>" />
<!--<link rel="icon" type="image/x-icon" href="/favicon.ico" />-->
<link href="/core/css/jquery-ui.css" rel="stylesheet"/>
<link href="/core/css/menu.css" rel="stylesheet" />
<link href="/core/css/lightslider.css" rel="stylesheet" />
<link href="/core/css/core.css" rel="stylesheet" />
<script src="/core/js/jquery.min.js"></script>
<script src="/core/js/jquery-ui.js"></script>
<script src="/core/js/lightslider.js"></script>
<script src="/core/js/core.js"></script>
</head>
<body>
	<div class="load"><img src="/core/css/images/loading.svg" alt="Loading" /><img src="/core/css/images/menu.svg" alt="Menu" /></div>
	<div class="emx"><div class="emxfl"></div><div class="emxfr"></div><div class="clr"></div></div>
	<div class="logoBack">
		<div id="header">
			<div class="hdL">
				<a href="/"><img src="/core/images/logo.png" width="125" alt="Watch movie" title="Watch movie" /></a>
			</div>
			<div class="hdR">
				<?php $tpAranan = (isset($_GET['_searched']) ? $_GET['_searched'] : null); ?>
				<input type="text" class="searchBx" title="Search movie" placeholder="Search Movie... 🎬" <?php if ($tpAranan!="") echo('value="'.$tpAranan.'"');?>/>
				<input type="hidden" class="minLg" value="<?php echo($_g_searchBoxMinAutoCompleteLength);?>" style="display:none;" />
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
	<div id="aX">
	<div class="tmOut"><div class="autoComplete"></div></div>
	<div id="ac">
		<div class="rspsvMenu"></div>
		<script>
		$menuNm=0;
		$(".rspsvMenu").click(function(){
			$menuNm++;
			if ($menuNm==1) $("#cssmenu").addClass("menuShw");
			else {
				$("#cssmenu").removeClass("menuShw");
				$menuNm=0;
			}
		});
		</script>
		<div class="menuSp"></div>
		<div id="cssmenu">
			<ul>
				<li <?php echo($s=="watch-movie" || $s==""?$_cssAct:"");?> title="Watch Movie"><a href="/">Watch Movie</a></li>
				<li <?php echo(($s=="movies"||$s=="movie"||$s=="_categories")?$_cssAct:"");?>><a href="/categories/movies">All Movies</a><ul><?php $allMovies_=$conn->query("select * from categories order by id desc"); while($eci = $allMovies_->fetch_assoc()){ ?><li <?php echo(($s=="movies" || $s=="movie") && $eci["id"]==$cateID?$_cssAct:"")?>><a href="/all-movies/<?php echo(createPageName($eci["cateName"]));?>/<?php echo($eci["id"]);?>/"><?php echo($eci["cateName"]);?></a></li><?php } ?></ul></li>
				<li <?php echo($s=="watchHistory"?$_cssAct:"");?>><a href="/watch-history">Watch History</a></li>
				<li <?php echo($s=="watchList"?$_cssAct:"");?>><a href="/watch-list">Watch List</a></li>
				<li><a href="/random">Random Movie</a></li>
				<li <?php echo($s=="_contact"?$_cssAct:"");?>><a href="/contact">Contact</a></li>
			</ul>
		</div>
		<div class="clr"></div>
		<?php if ($s!="_xaxmin" && ($s=="" || $s=="watch-movie")){?>
		<div class="paint">
			<h2 class="ttl">Most Watched Movies</h2>
			<ul id="content-slider" class="content-slider"><?php $sy=0; $MostWatchedMovies=$conn->query("select id,movie_cover,movie_name from movies order by hit desc limit ".$_g_slideMovieCount); while($eci = $MostWatchedMovies->fetch_assoc()){ ?><li data-thumb="/<?php echo($eci["movie_cover"]);?>" title="<?php echo($eci["movie_name"]);?> watch"><div class="cvru"><a href="<?php echo(createMovieLink($eci["id"],$conn)); ?>"><?php $sy++; if ($sy<=3){?><div class="cover_kc" title="Most Watched Movies"><?php echo($sy);?></div><?php }?><img src="/<?php echo($eci["movie_cover"]);?>" alt="<?php echo($eci["movie_name"]);?>" /></a></div></li><?php } ?></ul><?php if($MostWatchedMovies->num_rows <= 0){?>No movie found to view.<?php }?>
		</div>
		<div class="clr"></div>
		<?php }?>
		<div id="<?php echo($_g_siteName);?>" class="contentLeft <?php echo($s=="_xaxmin"?"contentWide":"");?>"><?php include("./".$contentPage); ?>
		</div>
		<?php if ($s!="_xaxmin"){
		
		$yearRanges=array("2021-".date("Y"),"2018-2021","2014-2018","2010-2014","2005-2010","2000-2005","1995-2000","1990-1995","1985-1990","1980-1985","1975-1980","1970-1975","1965-1970","1960-1965","1955-1960","1950-1955","1900-1950");
		
		$movieTimes=array(
		array("1a","Less than 1 hour"),
		array("6","1 hour"),
		array("1","Between 1 hour and 1,5 hours"),
		array("2","Between 1,5 hours and 2 hours"),
		array("7","2 hours"),
		array("3","Between 2 hours and 2,5 hours"),
		array("4","Between 2,5 hours and 3 hours"),
		array("8","3 hours"),
		array("5","More than 3 hours"));
		
		$imdbScores=array(
		array("10","10 points"),
		array("9","9 points"),
		array("9u","9 points and above"),
		array("8","8 points"),
		array("8u","8 points and above"),
		array("7","7 points"),
		array("7u","7 points and above"),
		array("6","6 points"),
		array("6u","6 points and above"),
		array("5","5 points"),
		array("5u","5 points and above"),
		array("4","4 points"),
		array("4u","4 points and above"),
		array("4a","4 points and below"));
		
		$starScores=array(
		array("5","5 stars"),
		array("4","4 stars"),
		array("4u","4 stars and above"),
		array("3","3 stars"),
		array("3u","3 stars and above"),
		array("2","2 stars"),
		array("2u","2 stars and above"),
		array("1","1 star"),
		array("0","No stars"),
		);
		
		if (($s=="" || $s=="watch-movie" || $s=="detailed_search" || $s=="search") && $contentPage!="_movie.php"){?>
		<div class="rightMenu">
			<a href="/#<?php echo($_g_siteName);?>" title="Detailed Movie Search"><h5 class="ttl">Detailed Movie Search</h5></a>
			<div class="pdLR20 fSz14">You can use the detailed movie search section to find the movie you are looking for by selecting as many criteria as you want.</div><br />
			<div class="rbt">
				<select class="movieSettCho" id="movWatchType">
				<option value="" selected="selected">Movie Watching Type</option>
				<?php $rbt_movWatchType=$conn->query("select distinct watching_type from options"); while($eci = $rbt_movWatchType->fetch_assoc()){ ?>
				<option value="<?php echo(urlencode($eci["watching_type"]));?>"><?php echo($eci["watching_type"]);?></option>
				<?php $watchingTypes[]=$eci["watching_type"];}?>
				</select>
				<select class="movieSettCho" id="movSourceName">
				<option value="" selected="selected">Movie Source</option>
				<?php $rbt_movSourceName=$conn->query("select distinct source_name from options"); while($eci = $rbt_movSourceName->fetch_assoc()){ ?>
				<option value="<?php echo(urlencode($eci["source_name"]));?>"><?php echo($eci["source_name"]);?></option>
				<?php $sourceNames[]=$eci["source_name"];}?>
				</select>
				<select class="movieSettCho" id="movLang">
				<option value="" selected="selected">Movie Language</option>
				<?php $rbt_movLang=$conn->query("select distinct lang_setting from options"); while($eci = $rbt_movLang->fetch_assoc()){ ?>
				<option value="<?php echo(urlencode($eci["lang_setting"]));?>"><?php echo($eci["lang_setting"]);?></option>
				<?php $movLangs[]=$eci["lang_setting"];}?>
				</select>
				<select class="movieSettCho" id="movCateg">
				<option value="" selected="selected">Movie Category</option>
				<?php $rbt_movCateg=$conn->query("select distinct cateName from categories"); while($eci = $rbt_movCateg->fetch_assoc()){ ?>
				<option value="<?php echo(urlencode($eci["cateName"]));?>"><?php echo($eci["cateName"]);?></option>
				<?php $movCategs[]=$eci["cateName"];}?>
				</select>
				<select class="movieSettCho" id="movieYear">
				<option value="" selected="selected">Movie Year</option>
				<optgroup label="Year Range"><?php foreach($yearRanges as $yl){?><option value="<?php echo($yl);?>"><?php echo($yl);?></option><?php }?></optgroup>
				<optgroup label="Years">
				<?php $rbt_movieYear=$conn->query("select distinct movieYear from movies order by movieYear desc"); while($eci = $rbt_movieYear->fetch_assoc()){ 
				
				if ($eci["movieYear"]!="0"){ 
				?><option value="<?php echo(urlencode($eci["movieYear"]));?>"><?php echo($eci["movieYear"]);?></option><?php $yearsx[]=$eci["movieYear"]; } }?>
				</optgroup>
				</select>
				<select class="movieSettCho" id="movTime">
				<option value="" selected="selected">Movie Time</option>
				<?php foreach($movieTimes as $em){?><option value="<?php echo($em[0]);?>"><?php echo($em[1]);?></option><?php }?>
				</select>
				<select class="movieSettCho" id="movImdbSc">
				<option value="" selected="selected">IMDB Score</option>
				<?php foreach($imdbScores as $em){?><option value="<?php echo($em[0]);?>"><?php echo($em[1]);?></option><?php }?>
				</select>
				<select class="movieSettCho" id="movStarSc">
				<option value="" selected="selected">Star Score</option>
				<?php foreach($starScores as $em){?><option value="<?php echo($em[0]);?>"><?php echo($em[1]);?></option><?php }?>
				</select>
				<div class="movieSett" id="eMFilter">Filter Movies</div>
			</div>
			<script>
			$(function(){
				$("#eMFilter").click(function(){
					s1=($("#movTime").val()==""?"n":$("#movTime").val());s2=$("#movWatchType").val();s3=$("#movSourceName").val();s4=$("#movLang").val();s5=$("#movCateg").val();s6=$("#movieYear").val();s7=$("#movImdbSc").val();s8=$("#movStarSc").val();
					s1=s1==""?"n":s1;s2=s2==""?"n":s2;s3=s3==""?"n":s3;s4=s4==""?"n":s4;s5=s5==""?"n":s5;s6=s6==""?"n":s6;s7=s7==""?"n":s7;s8=s8==""?"n":s8;
					s1=encodeURIComponent(s1);s2=encodeURIComponent(s2);s3=encodeURIComponent(s3);s4=encodeURIComponent(s4);s5=encodeURIComponent(s5);s6=encodeURIComponent(s6);s7=encodeURIComponent(s7);s8=encodeURIComponent(s8);
					window.location="<?php echo($siteUrl);?>/detailed-search/"+s1+"/"+s2+"/"+s3+"/"+s4+"/"+s5+"/"+s6+"/"+s7+"/"+s8+"#<?php echo($_g_siteName);?>";
				});
				$("#movWatchType").val("<?php echo($_s2=="n"?"":urlencode($_s2));?>").selectmenu('refresh');
				$("#movSourceName").val("<?php echo($_s3=="n"?"":urlencode($_s3));?>").selectmenu('refresh');
				$("#movLang").val("<?php echo($_s4=="n"?"":urlencode($_s4));?>").selectmenu('refresh');
				$("#movCateg").val("<?php echo($_s5=="n"?"":urlencode($_s5));?>").selectmenu('refresh');
				$("#movieYear").val("<?php echo($_s6=="n"?"":urlencode($_s6));?>").selectmenu('refresh');
				$("#movImdbSc").val("<?php echo($_s7=="n"?"":urlencode($_s7));?>").selectmenu('refresh');
				$("#movStarSc").val("<?php echo($_s8=="n"?"":urlencode($_s8));?>").selectmenu('refresh');
				$("#movTime").val("<?php echo($_s9=="n"?"":urlencode($_s9));?>").selectmenu('refresh');
				var styl={"background":"#07bcff","color":"#eee"};
				<?php
				if ($_s2!="n" && $_s2!="") {?>$("#movWatchType-button").css(styl);<?php }
				if ($_s3!="n" && $_s3!="") {?>$("#movSourceName-button").css(styl);<?php }
				if ($_s4!="n" && $_s4!="") {?>$("#movLang-button").css(styl);<?php }
				if ($_s5!="n" && $_s5!="") {?>$("#movCateg-button").css(styl);<?php }
				if ($_s6!="n" && $_s6!="") {?>$("#movieYear-button").css(styl);<?php }
				if ($_s7!="n" && $_s7!="") {?>$("#movImdbSc-button").css(styl);<?php }
				if ($_s8!="n" && $_s8!="") {?>$("#movStarSc-button").css(styl);<?php }
				if ($_s9!="n" && $_s9!="") {?>$("#movTime-button").css(styl);<?php }
				?>
			} );
			</script>
		</div>
		<?php }
		if ($s=="detailed_search"){?>
		<div class="rightMenu">
			<h5 class="ttl">Search Movies with One Option</h5>
			<div class="blx">Watching Types of Movies</div>
			<div class="lnk dty">
			<?php foreach($watchingTypes as $ks){?><a href="/detailed-search/n/<?php echo(urlencode($ks));?>/n/n/n/n/n/n#<?php echo($_g_siteName);?>"><div><?php echo($ks);?></div></a><?php }?>
			</div>
			<div class="blx">Movie Sources</div>
			<div class="lnk dty">
			<?php foreach($sourceNames as $ks){?><a href="/detailed-search/n/n/<?php echo(urlencode($ks));?>/n/n/n/n/n#<?php echo($_g_siteName);?>"><div><?php echo($ks);?></div></a><?php }?>
			</div>
			<div class="blx">Languages of Movies</div>
			<div class="lnk dty">
			<?php foreach($movLangs as $ks){?><a href="/detailed-search/n/n/n/<?php echo(urlencode($ks));?>/n/n/n/n#<?php echo($_g_siteName);?>"><div><?php echo($ks);?></div></a><?php }?>
			</div>
			<div class="blx">Categories of Movies</div>
			<div class="lnk dty">
			<?php foreach($movCategs as $ks){?><a href="/detailed-search/n/n/n/n/<?php echo(urlencode($ks));?>/n/n/n#<?php echo($_g_siteName);?>"><div><?php echo($ks);?></div></a><?php }?>
			</div>
			<div class="blx">Years of Movies</div>
			<div class="lnk dty">
			<?php foreach($yearsx as $ks){?><a href="/detailed-search/n/n/n/n/n/<?php echo(urlencode($ks));?>/n/n#<?php echo($_g_siteName);?>"><div><?php echo($ks);?></div></a><?php }?>
			</div>
			<div class="blx">Year Ranges of Movies</div>
			<div class="lnk dty">
			<?php foreach($yearRanges as $ks){?><a href="/detailed-search/n/n/n/n/n/<?php echo(urlencode($ks));?>/n/n#<?php echo($_g_siteName);?>"><div><?php echo($ks);?></div></a><?php }?>
			</div>
			<div class="blx">Times of Movies</div>
			<div class="lnk dty">
			<?php foreach($movieTimes as $em){?><a href="/detailed-search/n-<?php echo(urlencode($em[0]));?>/n/n/n/n/n/n/n#<?php echo($_g_siteName);?>"><div><?php echo($em[1]);?></div></a><?php }?>
			</div>
			<div class="blx">IMDB Scores of Movies</div>
			<div class="lnk dty">
			<?php foreach($imdbScores as $em){?><a href="/detailed-search/n/n/n/n/n/n/<?php echo(urlencode($em[0]));?>/n#<?php echo($_g_siteName);?>"><div><?php echo($em[1]);?></div></a><?php }?>
			</div>
			<div class="blx">Star Scores of Movies</div>
			<div class="lnk dty">
			<?php foreach($starScores as $em){?><a href="/detailed-search/n/n/n/n/n/n/n/<?php echo(urlencode($em[0]));?>#<?php echo($_g_siteName);?>"><div><?php echo($em[1]);?></div></a><?php }?>
			</div>
			<div class="pdB20"></div>
		</div>
		<?php }?>
		<div class="rightMenu">
			<h5 class="ttl">Recently Added IMDB 7+ Movies</h5>
			<div class="lnk"><?php
			$imdb7id=$conn->query("select id,imdbID,movie_name,imdbScore from movies where imdbScore>=7 order by id desc limit ".$_g_rightMenuMovieCount);
			while($_7 = $imdb7id->fetch_assoc()){
				echo("<a href=\"".createMovieLink($_7["id"],$conn)."\"><div title=\"Watch ".$_7["movie_name"]." movie\">".$_7["movie_name"]." (IMDB: <b>".$_7["imdbScore"]."</b>)</div></a>");
			}
			?></div>
		</div>
		<div class="rightMenu">
			<h5 class="ttl">Recently Added 4+ Star Movies</h5>
			<div class="lnk"><?php
			$imdb4id=$conn->query("select movies.id,movies.imdbID,movies.movie_name,scores.star_score from movies inner join scores on scores.fid=movies.id where scores.star_score>=4 order by movies.id,scores.star_score desc limit ".$_g_rightMenuMovieCount);
			while($_4 = $imdb4id->fetch_assoc()){
				echo("<a href=\"".createMovieLink($_4["id"],$conn)."\"><div title=\"Watch ".$_4["movie_name"]." movie\">".$_4["movie_name"]." (<img src=\"/core/images/star_h.png\" width=\"12px\" /><b>".$_4["star_score"]."</b>)</div></a>");
			}
			?></div>
		</div>
		<div class="rightMenu">
			<h5 class="ttl">Recently Added <?php echo(date("Y")); ?> Movies</h5>
			<div id="soneklenenler" class="lnk"><?php
			$buYilki=$conn->query("select id,imdbID,movie_name,imdbScore from movies where movieYear=".date("Y")." order by id desc limit ".$_g_rightMenuMovieCount);
			while($_7 = $buYilki->fetch_assoc()){
				echo("<a href=\"".createMovieLink($_7["id"],$conn)."\"><div title=\"Watch ".$_7["movie_name"]." movie\">".$_7["movie_name"]." (IMDB: <b>".$_7["imdbScore"]."</b>)</div></a>");
			}
			?></div>
		</div>
		<div class="rightMenu">
			<h5 class="ttl">Recently Added <?php echo((date("Y")-1)); ?> Movies</h5>
			<div id="soneklenenler" class="lnk"><?php
			$buYilki=$conn->query("select id,imdbID,movie_name,imdbScore from movies where movieYear=".(date("Y")-1)." order by id desc limit ".$_g_rightMenuMovieCount);
			while($_7 = $buYilki->fetch_assoc()){
				echo("<a href=\"".createMovieLink($_7["id"],$conn)."\"><div title=\"Watch ".$_7["movie_name"]." movie\">".$_7["movie_name"]." (IMDB: <b>".$_7["imdbScore"]."</b>)</div></a>");
			}
			?></div>
		</div>
		<?php }?>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
	<?php
	$conn->close();
	}
	ob_end_flush();
	
	$loadingTimeStops = (double)microtime(1);
	$loadingTime = $loadingTimeStops - $loadingTimeStarts;
	?>
	<div id="footer">
		<div class="sect">
			<div class="sects">
				<div class="fbs">Follow us</div>
				<div><a href="https://www.facebook.com/" title="Like <?php echo($_g_siteName);?> Facebook Page" target="_blank" rel="nofollow">Facebook</a></div>
				<div><a href="https://plus.google.com/" title="Follow <?php echo($_g_siteName);?> Twitter Page" target="_blank" rel="nofollow">Twitter</a></div>
				<div><a href="/rss" title="Subscribe to <?php echo($_g_siteName);?> RSS Feed">RSS Feed</a></div>
			</div>
			<div class="sects">
				<div class="fbs"><?php echo($_g_siteName);?> Tops</div>
				<div><a href="/most-popular-movies" title="Watch the most popular movies">Most Popular Movies</a></div>
				<div><a href="/top-rated-movies" title="Watch top rated movies">Top Rated Movies</a></div>
				<div><a href="/latest-movies" title="See the latest movies">Latest Movies</a></div>
			</div>
			<div class="sects">
				<div class="fbs">Movies by Year</div>
				<?php
				for ($_dt=0;$_dt<3;$_dt++){
					$dt=(date("Y")-$_dt);
					echo('<div><a href="/detailed-search/n/n/n/n/n/'.$dt.'/n/n" title="Watch '.$dt.' movies">Watch '.$dt.' Movies</a></div>');
				}
				?>
			</div>
			<div class="sects">
				<div class="fbs">Movies by Star Score</div>
				<div><a href="/detailed-search/n/n/n/n/n/n/n/5" title="Watch 5 star movies">5 star movies</a></div>
				<div><a href="/detailed-search/n/n/n/n/n/n/n/4" title="Watch 4 star movies">4 star movies</a></div>
				<div><a href="/detailed-search/n/n/n/n/n/n/n/3u" title="Watch above 3 star movies">Above 3 star movies</a></div>
			</div>
			<div class="sects">
				<div class="fbs">Movies by Language</div>
				<div><a href="/detailed-search/n/n/n/English/n/n/n/n" title="Watch English dubbed movies">English movies</a></div>
				<div><a href="/detailed-search/n/n/n/English/n/n/n/n" title="Watch English subtitled movies">English subtitled movies</a></div>
				<div><a href="/detailed-search/n/Trailer/n/English/n/n/n/n" title="Watch English trailers">English trailers</a></div>
			</div>
			<div class="clr"></div>
		</div>
		<?php if ($contentPage=="_home.php"){?><div class="fotLnks"></div><?php }?>
		<div class="copy">&copy; <?php echo(date("Y"));?> <?php echo($_g_siteName);?> v<?php echo($_version);?> (<?php echo(number_format($loadingTime, 4, ",", "."));?> sec)</div>
		<div class="clr"></div>
	</div>
	<div id="lightsOff_"></div>
	</div>
</body>
</html>