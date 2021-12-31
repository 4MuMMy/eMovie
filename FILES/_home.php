<?php 

if (count(get_included_files()) == 1 || $_SERVER["REQUEST_URI"]=="/_home.php") {header("Location:/");die();}
else{
?>
<h1 id="<?php echo($_g_siteName);?>" class="ttl">Recently Added Movies</h1>
<div class="moviesMainTable">
	<?php
	
	$_page=doPage("/watch-movie","movies","page",$conn, $_g_moviePerPage);
	$sBol=explode("~", $_page);
	
    $LatestMovies=$conn->query("select movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from movies inner join categories on movies.movie_category=categories.id order by movies.id desc limit ".$sBol[0]);

	while($sef = $LatestMovies->fetch_assoc()){?>
	<a href="<?php echo(createMovieLink($sef["id"],$conn)); ?>">
		<div class="movieNode" title="Watch <?php echo($sef["movie_name"]);?>">
			<img src="/<?php echo($sef["movie_cover"]);?>" alt="Watch <?php echo($sef["movie_name"]);?>" />
			<div class="movieName"><?php echo($sef["movie_name"]);?></div>
			<div class="movieInfo"><?php echo($sef["cateName"]);?></div>
			<div class="movieInfo">Year: <?php echo($sef["movieYear"]);?> | IMDB: <?php echo($sef["imdbScore"]);?> | Time: <?php echo($sef["movieTime"]);?></div>
		</div>
	</a>
	<?php }?>
</div>
<div class="clr"></div>
<div class="page_"><?php echo($sBol[1]);?></div>
<div class="clr"></div>
<h3 class="ttl">Browse Our Movie Archive</h3>
<ul class="moviesShrt"><?php $allMovies=$conn->query("select * from categories order by id desc"); while($eci = $allMovies->fetch_assoc()){ ?><li <?php echo(($s=="movies" || $s=="movie") && $eci["id"]==$cateID?$_cssAct:"")?>><a href="/all-movies/<?php echo(createPageName($eci["cateName"]));?>/<?php echo($eci["id"]);?>/" title="<?php echo($eci["cateName"]);?> watch"><?php echo($eci["cateName"]);?></a></li><?php } ?>
<li><a href="/categories/movies" class="xdg" title="All Movie Categories">All Movie Genres</a></li>
</ul>
<div class="clr mgB50"></div>
<h4 class="ttl">Find More Movies</h4>
<div class="pdLR">If you want to browse even more movies from among <b><?php echo(oneReg("count(*)","movies",$conn));?></b> different movies in our movie library, you can select the movie genres or movie categories you want from the menu under the <b><?php echo($_g_siteName);?></b> logo. If you prefer to browse through the movies in a mix, you can use the page numbers just above.</div><br />
<div class="clr mgB50"></div>
<?php }?>