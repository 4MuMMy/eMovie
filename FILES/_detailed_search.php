<?php 
if (count(get_included_files()) == 1) {header("Location:/");die();}
else{

$_s9 = (isset($_GET['s1']) ? urldecode($_GET['s1']) : null);
$_s2 = (isset($_GET['s2']) ? urldecode($_GET['s2']) : null);
$_s3 = (isset($_GET['s3']) ? urldecode($_GET['s3']) : null);
$_s4 = (isset($_GET['s4']) ? urldecode($_GET['s4']) : null);
$_s5 = (isset($_GET['s5']) ? urldecode($_GET['s5']) : null);
$_s6 = (isset($_GET['s6']) ? urldecode($_GET['s6']) : null);
$_s7 = (isset($_GET['s7']) ? urldecode($_GET['s7']) : null);
$_s8 = (isset($_GET['s8']) ? urldecode($_GET['s8']) : null);


if ($_s2!="" && $_s3!="" && $_s4!="" && $_s5!="" && $_s6!="" && $_s7!="" && $_s8!="" && $_s9!=""){

if ($_s2=="n" && $_s3=="n" && $_s4=="n" && $_s5=="n" && $_s6=="n" && $_s7=="n" && $_s8=="n" && $_s9=="n"){header("Location:/");die();}

$year1=0;
$year2=0;

$where="where ''=''";


if ($_s2!="n") $where.=" and options.watching_type='".$conn->real_escape_string($_s2)."'";
if ($_s3!="n") $where.=" and options.source_name='".$conn->real_escape_string($_s3)."'";
if ($_s4!="n") $where.=" and options.lang_setting='".$conn->real_escape_string($_s4)."'";
if ($_s5!="n") $where.=" and categories.cateName='".$conn->real_escape_string($_s5)."'";
if ($_s6!="n") {
	$years=explode("-",$_s6."-");
	if (strpos($_s6,"-")!==false){
		
		if ($years[0]>date("Y") || $years[0]<1900){header("Location:/");die();}
		if ($years[1]>date("Y") || $years[1]<1950){header("Location:/");die();}
		
		$year1=$years[0];
		$year2=$years[1];
		$where.=" and (movies.movieYear>=".$conn->real_escape_string($year1)." and movies.movieYear<=".$conn->real_escape_string($year2).")";
	}
	else{
		if ($years[0]>date("Y") || $years[0]<1900){header("Location:/");die();}
		
		$year1=$years[0];
		$where.=" and movies.movieYear=".$conn->real_escape_string($year1);
	}
}
if ($_s7!="n") {
	if ($_s7!="4a" && $_s7!="4" && $_s7!="5" && $_s7!="6" && $_s7!="7" && $_s7!="8" && $_s7!="9" && $_s7!="10" && $_s7!="4u" && $_s7!="5u" && $_s7!="6u" && $_s7!="7u" && $_s7!="8u" && $_s7!="9u") {header("Location:/");die();}
	
	if ($_s7=="4a") $where.=" and movies.imdbScore<=4";
	else if (strpos($_s7,"u")===false) $where.=" and movies.imdbScore=".$conn->real_escape_string($_s7);
	else if (strpos($_s7,"u")!==false) $where.=" and movies.movieYear>=".$conn->real_escape_string(str_replace("u","",$_s7));
}
if ($_s8!="n"){
	if ($_s8!="0" && $_s8!="1" && $_s8!="2" && $_s8!="3" && $_s8!="4" && $_s8!="5" && $_s8!="4u" && $_s8!="3u" && $_s8!="2u") {header("Location:/");die();}
	
	if ($_s8=="0") $where.=" and (select avg(scores.star_score) from scores where scores.fid=movies.id) is null";
	else if (strpos($_s8,"u")===false) $where.=" and (select avg(scores.star_score) from scores where scores.fid=movies.id)='".$conn->real_escape_string($_s8)."'";
	else if (strpos($_s8,"u")!==false) $where.=" and (select avg(scores.star_score) from scores where scores.fid=movies.id)>=".$conn->real_escape_string(str_replace("u","",$_s8));
}
if ($_s9!="n") {
	if ($_s9!="1a" && $_s9!="1" && $_s9!="2" && $_s9!="3" && $_s9!="4" && $_s9!="5" && $_s9!="6" && $_s9!="7" && $_s9!="8") {header("Location:/");die();}
	
	if ($_s9=="1a")$where.=" and hour(movies.movieTime)<1";
	else if ($_s9=="1")$where.=" and (hour(movies.movieTime)=1 and minute(movies.movieTime)<=30)";
	else if ($_s9=="2")$where.=" and ((hour(movies.movieTime)=1 and minute(movies.movieTime)>=31) or (hour(movies.movieTime)=2 and minute(movies.movieTime)=0))";
	else if ($_s9=="3")$where.=" and (hour(movies.movieTime)=2 and minute(movies.movieTime)<=30)";
	else if ($_s9=="4")$where.=" and ((hour(movies.movieTime)=2 and minute(movies.movieTime)>=31) or (hour(movies.movieTime)=3 and minute(movies.movieTime)=0))";
	else if ($_s9=="5")$where.=" and hour(movies.movieTime)>3";
	else if ($_s9=="6")$where.=" and (hour(movies.movieTime)=1 and minute(movies.movieTime)=0)";
	else if ($_s9=="7")$where.=" and (hour(movies.movieTime)=2 and minute(movies.movieTime)=0)";
	else if ($_s9=="8")$where.=" and (hour(movies.movieTime)=3 and minute(movies.movieTime)=0)"; 
}

$order="order by movies.id desc";
$query="movies inner join options on options.fid=movies.id inner join categories on categories.id=movies.movie_category ".$where." ".$order;


$pageName="/detailed-search/".$_s9."/".$_s2."/".$_s3."/".$_s4."/".$_s5."/".$_s6."/".$_s7."/".$_s8;


$_pager=doPage($pageName,$query,"pg",$conn,$_g_moviePerPage);
$sBol=explode("~", $_pager);

$jajaja=$conn->prepare("select distinct movies.id, movies.movie_name,movies.movie_cover,movies.movieYear,movies.imdbScore,movies.movieTime,categories.cateName from ".$query." limit ".$sBol[0]);
$jajaja->execute();
$_ja=$jajaja->get_result();

$totalReg=oneReg("count(distinct movies.id)",$query,$conn);
?>
<h1 id="<?php echo($_g_siteName);?>" class="ttl">Detailed movie search results <?php if($totalReg > 5){?><div class="searchResult"><?php echo("Total <b>".$totalReg."</b> movie found.");?></div><?php }?></h1>
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
	<?php } if($_ja->num_rows <= 0){?>No movies found.<div class="mnhee"></div><?php }?>
</div>
<div class="clr"></div>
<div class="page_"><?php echo($sBol[1]);?></div>
<div class="clr"></div>
<div class="mnhe mnhex"></div>
<?php }else{header("Location:/");die();} } ?>