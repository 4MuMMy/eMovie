<?php 
if (count(get_included_files()) == 1 || $_SERVER["REQUEST_URI"]=="/_categories.php") {header("Location:/");die();}
else{
	
	$cat1="All Movies";
	$cate1link="/categories/movies";
	
?>
<h1 class="ttl">Movie Categories &gt; <?php echo("<a href=\"".$cate1link."\" title=\"watch movie\">".$cat1."</a>"); ?></h1>
<?php 
$movies=$conn->query("select * from categories order by id desc");?>
<ul class="moviesShrt"><?php while($eci = $movies->fetch_assoc()){ $cat_name=$eci["cateName"];
?><li><a href="/all-movies/<?php echo(createPageName($eci["cateName"]));?>/<?php echo($eci["id"]);?>/" title="Watch <?php echo($cat_name);?>"><?php echo($cat_name);?></a></li><?php } ?></ul>
<div class="clr"></div>
<h2 class="ttl">Last Movies</h2>
<div class="moviesMainTable">
	<?php 
	$_pager=doPage("/categories/movies","movies order by id desc","page",$conn, $_g_moviePerPage);
	$sBol=explode("~", $_pager);

	$catMovies=$conn->prepare("select movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from movies inner join categories on movies.movie_category=categories.id order by movies.id desc limit ".$sBol[0]);
	$catMovies->execute();
	$__ktg=$catMovies->get_result();

	while($ksef = mysqli_fetch_assoc($__ktg)){ ?>
	<a href="<?php echo(createMovieLink($ksef["id"],$conn)); ?>">
		<div class="movieNode" title="Watch <?php echo($ksef["movie_name"]);?> movie">
			<img src="/<?php echo($ksef["movie_cover"]);?>" alt="Watch <?php echo($ksef["movie_name"]);?> movie" />
			<div class="movieName"><?php echo($ksef["movie_name"]);?></div>
			<div class="movieInfo"><?php echo($ksef["cateName"]);?></div>
			<div class="movieInfo">Year: <?php echo($ksef["movieYear"]);?> | IMDB: <?php echo($ksef["imdbScore"]);?> | Time: <?php echo($ksef["movieTime"]);?></div>
		</div>
	</a>
	<?php } if($__ktg->num_rows <= 0){?>There are no movies to view.<?php }?>
	<div class="clr"></div>
</div>
<div class="clr"></div>
<?php
$movieCount=oneReg("count(*)","movies",$conn);

if($movieCount > 5){?><div class="result"><?php echo("We currently have <b>".$movieCount."</b> movies in our movie space.");?></div><?php }?>
<div class="page_"><?php echo($sBol[1]);?></div>
<div class="emmicroData">
	<ol itemscope itemtype="http://schema.org/BreadcrumbList">
		<li itemprop="itemlistlement" itemscope itemtype="http://schema.org/ListItem">
			<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo($siteUrl.$cate1link); ?>">
				<span itemprop="name"><?php echo($cat1);?></span>
			</a>
			<span itemprop="position" content="1"></span>
		</li>
	</ol>
</div>
<?php }?>