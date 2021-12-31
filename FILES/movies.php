<?php 
if (count(get_included_files()) == 1) {header("Location:/");die();}
else{

if ($cateName=="") {header("Location:/");die();}

$rightPgNm="/all-movies/".createPageName($cateName)."/".$cateID;
if ($_SERVER["REQUEST_URI"]!=$rightPgNm && strpos($_SERVER["REQUEST_URI"],$rightPgNm."/")===false) {header("Location:".$rightPgNm);die();}

$catLink="/all-movies/".$cateName."/".$cateID;

?>
<h1 class="ttl"><?php echo("All Movies &gt; <a href=\"".$catLink."\" title=\"Watch ".$cateName."\">".$cateName."</a>"); ?></h1>
<div class="moviesMainTable">
	<?php 
	
	$_pager=doPage($rightPgNm,"movies where movie_category='".$conn->real_escape_string($cateID)."'","page",$conn, $_g_moviePerPage);
	$sBol=explode("~", $_pager);

	$cateMovs=$conn->prepare("select movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from movies inner join categories on movies.movie_category=categories.id where movies.movie_category=".$conn->real_escape_string($cateID)." order by movies.id desc limit ".$sBol[0]);
	$cateMovs->execute();
	$__ktg=$cateMovs->get_result();
	
	while($ksef = mysqli_fetch_assoc($__ktg)){?>
	<a href="<?php echo(createMovieLink($ksef["id"],$conn)); ?>">
		<div class="movieNode" title="Watch <?php echo($ksef["movie_name"]);?> movie">
			<img src="/<?php echo($ksef["movie_cover"]);?>" alt="Watch <?php echo($ksef["movie_name"]);?> movie" />
			<div class="movieName"><?php echo($ksef["movie_name"]);?></div>
			<div class="movieInfo"><?php echo($ksef["cateName"]);?></div>
			<div class="movieInfo">Year: <?php echo($ksef["movieYear"]);?> | IMDB: <?php echo($ksef["imdbScore"]);?> | Time: <?php echo($ksef["movieTime"]);?></div>
		</div>
	</a>
	<?php } if($__ktg->num_rows <= 0){?>There are no movies to view.<?php }?>
</div>
<div class="clr"></div>
<?php $totalReg=oneReg("count(*)","movies where movie_category=".$conn->real_escape_string($cateID),$conn);
if($totalReg > 5){?><div class="result"><?php echo("There are <b>".$totalReg."</b> movies in category <b><a href=\"/categories/movies/".$cateName."/".$cateID."\" title=\"Watch ".$cateName."\">".$cateName."</a></b>.");?></div><?php }?>
<div class="page_"><?php echo($sBol[1]);?></div>
<div class="clr"></div>
<?php 
	$cat1="All Movies";
	$cate1Link="/categories/movies";
?>
<div class="emmicroData">
	<ol itemscope itemtype="http://schema.org/BreadcrumbList">
		<li itemprop="itemlistlement" itemscope itemtype="http://schema.org/ListItem">
			<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo($siteUrl.$cate1Link); ?>">
				<span itemprop="name"><?php echo($cat1);?></span>
			</a>
			<span itemprop="position" content="1"></span>
		</li>
		<li itemprop="itemlistlement" itemscope itemtype="http://schema.org/ListItem">
			<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo($siteUrl.$catLink); ?>">
				<span itemprop="name"><?php echo($cateName);?></span>
			</a>
			<span itemprop="position" content="2"></span>
		</li>
	</ol>
</div>
<?php }?>