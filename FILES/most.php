<?php
if (count(get_included_files()) == 1 || $_SERVER["REQUEST_URI"]=="/en.php") {header("Location:/");die();}
else{

$_which = (isset($_GET['which']) ? $_GET['which'] : null);

$_titl="";
$_query="";
$_description=$_pageDescription_;

if ($_which=="1"){
$_titl="Most Popular Movies";
$_query="select movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from movies inner join categories on movies.movie_category=categories.id inner join scores on scores.fid=movies.id group by scores.fid order by count(scores.fid) desc limit ".$_g_mostPopularMoviesPageCount;
}
else if ($_which=="2"){
$_titl="Top Rated Movies";
$_query="select movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from movies inner join categories on movies.movie_category=categories.id inner join scores on scores.fid=movies.id group by scores.fid order by avg(scores.star_score) desc limit ".$_g_topRatedMoviesPageCount;
}
else if ($_which=="3"){
$_titl="Latest Movies";
$_query="select movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from movies inner join categories on movies.movie_category=categories.id inner join options on options.fid=movies.id where movies.movieYear=".date("Y")." group by movies.id order by movies.hit desc limit ".$_g_latestMoviesPageCount;
}
?>
<h1 class="ttl"><?php echo($_titl);?></h1>
<div class="description">
<?php echo($_description);?>
</div>
<div class="moviesMainTable">
	<?php
    $whichMovies=$conn->query($_query);
	while($sef = $whichMovies->fetch_assoc()){?>
	<a href="<?php echo(createMovieLink($sef["id"],$conn)); ?>">
		<div class="movieNode" title="<?php echo($sef["movie_name"]);?> movie">
			<img src="/<?php echo($sef["movie_cover"]);?>" alt="<?php echo($sef["movie_name"]);?> movie" />
			<div class="movieName"><?php echo($sef["movie_name"]);?></div>
			<div class="movieInfo"><?php echo($sef["cateName"]);?></div>
			<div class="movieInfo">Year: <?php echo($sef["movieYear"]);?> | IMDB: <?php echo($sef["imdbScore"]);?> | Time: <?php echo($sef["movieTime"]);?></div>
		</div>
	</a>
	<?php }?>
</div>
<div class="clr"></div>
<?php }?>