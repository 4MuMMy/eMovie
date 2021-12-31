<?php 
if (count(get_included_files()) == 1) {header("Location:/");die();}
else{

$_searched = (isset($_GET['_searched']) ? $_GET['_searched'] : null);
if (strlen($_searched)>$_g_searchMinLength){


$sSt=trim($conn->real_escape_string(urldecode($_searched)));

$sSt=str_replace("+"," ",$sSt);
$sSt=str_replace(" watch ","",$sSt);
$sSt=str_replace(" 2160p ","",$sSt);
$sSt=str_replace(" 4k ","",$sSt);
$sSt=str_replace(" hd ","",$sSt);
$sSt=str_replace(" movie ","",$sSt);
$sSt=str_replace(" watch","",$sSt);
$sSt=str_replace(" 2160p","",$sSt);
$sSt=str_replace(" 4k","",$sSt);
$sSt=str_replace(" hd","",$sSt);
$sSt=str_replace(" movie","",$sSt);
$sSt=str_replace("watch ","",$sSt);
$sSt=str_replace("2160p ","",$sSt);
$sSt=str_replace("4k ","",$sSt);
$sSt=str_replace("hd ","",$sSt);
$sSt=str_replace("movie ","",$sSt);
$sSt=trim($sSt);


$where="where lower(movies.movie_name) like lower('%".$sSt."%')";
$order="order by case when movies.movie_name like '".$sSt."%' then 1 when movies.movie_name like '% ".$sSt." %' then 2 when movies.movie_name like '".$sSt."' then 3 when movies.movie_name like '%".$sSt."%' then 4 else 5 end";

$_pager=doPage("/movie-search/".$_searched,"movies ".$where." ".$order,"pg",$conn,$_g_moviePerPage);
$sBol=explode("~", $_pager);


$jajaja=$conn->prepare("select movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from movies inner join categories on movies.movie_category=categories.id ".$where." ".$order." limit ".$sBol[0]);
$jajaja->execute();
$_ja=$jajaja->get_result();

$totalReg=oneReg("count(*)","movies ".$where." ".$order,$conn);
?>
<h1 class="ttl">Movie search results &gt; <?php echo("<a href=\"/movie-search/".$_searched."\">".ucfirst($_searched)."</a> ");?> <?php if($totalReg > 5){?><div class="searchResult"><?php echo("Total <b>".$totalReg."</b> movie found.");?></div><?php }?></h1>
<div class="moviesMainTable">
	<?php while($jase = mysqli_fetch_assoc($_ja)){ ?>
	<a href="<?php echo(createMovieLink($jase["id"],$conn)); ?>">
		<div class="movieNode" title="<?php echo($jase["movie_name"]);?> movie">
			<img src="/<?php echo($jase["movie_cover"]);?>" alt="<?php echo($jase["movie_name"]);?> movie" />
			<div class="movieName"><?php echo($jase["movie_name"]);?></div>
			<div class="movieInfo"><?php echo($jase["cateName"]);?></div>
			<div class="movieInfo">Year: <?php echo($jase["movieYear"]);?> | IMDB: <?php echo($jase["imdbScore"]);?> | Time: <?php echo($jase["movieTime"]);?></div>
		</div>
	</a>
	<?php } if($_ja->num_rows <= 0){?>No movies found.<?php }?>
</div>
<div class="clr"></div>
<div class="page_"><?php echo($sBol[1]);?></div>
<div class="clr"></div>
<?php }else{header("Location:/");die();} }?>