<?php
if (count(get_included_files()) == 1) {header("Location:/");die();}
else{
	
	if ($_movieID!=""){
	
	$movSource="";

	$orderBy="order by case when source_name LIKE '%Youtube%' and watching_type like '%Trailer%' then 1 when watching_type LIKE '%Trailer%' then 2 else 3 end";
	
	$xssz=$conn->prepare("select * from options where fid=? ".$orderBy);
	$xssz->bind_param("s",$_movieID);
	$xssz->execute();
	$ressz = $xssz->get_result();
	if($_xssz = mysqli_fetch_assoc($ressz)){
		$movSource=$_xssz["source_code"];
	}
	$xssz->close();

	if ($movSource==""){header("Location:/");die();}

	$movName="";
	$movCat="";
	$movCov="";
	$shortDesc="";
	$descr="";
	$hit="";
	$imdbID="";
	$addedDate="";
	$lastEditDate="";
	$categID="";
	$mmovieYear="";
	$mmovieTime="";
	$movieIMDBscore="";

	$_movie=$conn->prepare("select * from movies inner join categories on movies.movie_category=categories.id where movies.id=?");
	$_movie->bind_param("s",$_movieID);
	$_movie->execute();
	$_fl=$_movie->get_result();
	if($_ = mysqli_fetch_assoc($_fl)){
	$movName=$_["movie_name"];
	$movCat=$_["cateName"];
	$movCov=$_["movie_cover"];
	$shortDesc=$_["short_desc"];
	$descr=$_["description"];
	$hit=$_["hit"];
	$imdbID=$_["imdbID"];
	$addedDate=$_["addedDate"];
	$lastEditDate=$_["lastEditDate"];
	$categID=$_["movie_category"];
	$mmovieYear=$_["movieYear"];
	$mmovieTime=$_["movieTime"];
	$movieIMDBscore=$_["imdbScore"];
	}
	$_movie->close();


	try{
	if (!isset($_COOKIE["_sy".$_movieID])) {
		
		$hit=0;
		
		$_sc9=$conn->prepare("select hit from movies where id=?");
		$_sc9->bind_param("s",$_movieID);
		$_sc9->execute();
		$__sc9=$_sc9->get_result();
		while($sc_9 = mysqli_fetch_assoc($__sc9)){
		$hit=$sc_9["hit"];
		}
		$_sc9->close();
		
		$hit=$hit+1;
		
		if ($hit_increase = $conn->prepare("update movies set hit=? where id=?")){
		$hit_increase->bind_param("ss", $hit, $_movieID);
		$hit_increase->execute();
		$hit_increase->close();
		}
		
		setcookie("_sy".$_movieID,"_", time()+(86400*2),"/");//deleted after 2 days
	}

	}
	catch(Exception $e){}
	
	
	//redirect if url control is different from header
	$mLn=createMovieLink($_movieID,$conn);
	if ($_SERVER["REQUEST_URI"]!=$mLn && strpos($_SERVER["REQUEST_URI"],$mLn."/")===false) {header("Location:".createMovieLink($_movieID,$conn));die();}
	
	?>
	<div class="f_cvr" id="watch-movie">
	<a href="<?php echo(createMovieLink($_movieID,$conn));?>"><h1 class="ttl cvr" title="Watch <?php echo($movName); ?>"><?php echo($movName); ?> movie (<?php echo($mmovieYear); ?>)</h1></a>
	</div>
	<div class="watchMovie">
		<div class="movieSettings">
			<?php
			$xssz=$conn->prepare("select * from options where fid=? ".$orderBy);
			$xssz->bind_param("s",$_movieID);
			$xssz->execute();
			$ressz = $xssz->get_result();
			$say=0;
			while($_xssz = mysqli_fetch_assoc($ressz)){
				$say++;
				$texX="Watch ".$_xssz["lang_setting"]." ".$_xssz["watching_type"]." on ".$_xssz["source_name"];
				$movieOptions[]="<li><div id=\"sourcesc_".$_xssz["id"]."\" onclick=\"change_source(".$_xssz["id"].");\" ".($say==1?"class=\"xdg\"":"")." title=\"".$movName." ".$texX."\">".$texX."</div></li>";
				$selectOptions[]="<option value=\"".$_xssz["id"]."\" ".($say==1?"selected":"").">".$_xssz["lang_setting"]." ".$_xssz["watching_type"]." | ".$_xssz["source_name"]."</option>";
				$optionCodes[]="<div id=\"source_".$_xssz["id"]."\" class=\"source\">".$_xssz["source_code"]."</div>";
				$optionCodeIDs[]=$_xssz["id"];
			}
			$xssz->close();
			?>
			<script>
			function change_source(kynkid){ $(".loadng").css("display","block");<?php 
				foreach ($optionCodeIDs as $em){
					echo('$("#source_'.$em.'").removeClass("source_act");');
					echo('$("#source_'.$em.' iframe").attr("src", $("#source_'.$em.' iframe").attr("src"));');
				}
				?>$("#source_"+kynkid).addClass("source_act");$('.movieSettCho').val(kynkid).selectmenu('refresh');$(".xdg").removeClass('xdg');$("#sourcesc_"+kynkid).addClass('xdg');
				$("#source_"+kynkid+" iframe").load(function(){$(".loadng").css("display","none");});
				}
			$(function(){$(".movieSettCho").selectmenu({change: function( event, data ) {change_source($("#em1").val());}});change_source("<?php echo($optionCodeIDs[0]);?>");});
			</script>
			<select id="em1" class="movieSettCho" title="Movie Sources">
				<?php 
				foreach ($selectOptions as $em){
					echo($em);
				}
				?>
			</select>
			<div class="movieSett _watchLater" onclick="clckd('watchLater');">Watch Later</div>
			<div class="movieSett _watched" onclick="clckd('watched');">Mark as Watched</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		<div class="player_AndSett">
			<div class="player_">
				<div class="loadng"></div>
				<?php 
				foreach ($optionCodes as $kod){
					echo($kod);
				}
				?>
			</div>
			<div class="movieSettings faBott">
				<div class="movieSLg"><img src="/core/images/logo.png" width="80" alt="Watch movie" title="Watch movie" /></div>
				<div class="movieSett" id="fullscreen">Fullscreen</div>
				<div class="movieSett" id="lightOff">Turn Off The Lights</div>
				<div class="movieSett" id="brokenLink" onclick="clckd('broken');">Broken</div>
				<div class="movieSett" id="others">Show Color Settings</div>
				<div class="movieSett" id="brightness">Brightness x0</div>
				<div class="movieSett" id="contrast">Contrast x0</div>
				<div class="movieSett" id="saturation">Saturation x0</div>
				<div class="movieSett" id="grayscale">Grayscale x0</div>
			</div>
		</div>
		<div class="clr"></div>
		<div class="starOutside">
			<div class="starInfo">
				<b>Star Score: </b>
			</div>
			<div class="stars">
				<?php 
					$stScr=round(oneReg("avg(star_score)","scores where fid=".$_movieID,$conn),1);
					$totalVote=oneReg("count(*)","scores where fid=".$_movieID,$conn);
				?>
				<div class="star_i">
				<div id="star1" title="Rate this movie 1 out of 5 points" onclick="clckd('star_1');"></div>
				<div id="star2" title="Rate this movie 2 out of 5 points" onclick="clckd('star_2');"></div>
				<div id="star3" title="Rate this movie 3 out of 5 points" onclick="clckd('star_3');"></div>
				<div id="star4" title="Rate this movie 4 out of 5 points" onclick="clckd('star_4');"></div>
				<div id="star5" title="Rate this movie 5 out of 5 points" onclick="clckd('star_5');"></div>
				</div>
				<div id="grdRate" title="Star Score Average (Total <?php echo($totalVote==0?"0":$totalVote);?> Vote)"><?php echo($stScr);?></div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		<div class="movieU">
		<b>WARNING:</b> If the movie option above does not open, you can browse alternative movie sources below. If you want to watch the trailer of the movie, you can click on a trailer option below.
		</div>
		<div class="moviOk"></div>
		<h2 class="ttl">Movie Sources</h2>
		<ul class="moviesShrt moviesx_">
			<?php
				foreach ($movieOptions as $em){
					echo($em);
				}
			?>
		</ul>
		<div class="clr"></div>
		<h3 class="ttl">Movie Card</h3>
		<div class="movieCard">
			<img id="cower" src="/<?php echo($movCov); ?>" alt="Watch <?php echo($movName); ?> movie" title="Watch <?php echo($movName); ?> movie"/>
			<ul>
				<li><div class="tleft"><b>Movie Name: </b></div><div class="trep etk" title="Watch <?php echo($movName);?>"><strong><?php echo($movName);?></strong></div></li>
				<li><p><b>Short Description: </b><?php echo($shortDesc);?></p></li>
				<li><div class="tleft"><b>Category: </b></div><a href="/movies/<?php echo(createPageName($movCat));?>/<?php echo($categID);?>/" title="Watch <?php echo($movCat);?>"><div class="trep etk"><?php echo($movCat); ?></div></a></li>
				<li><div class="tleft"><b>Year: </b></div><div class="trep etk"><?php echo($mmovieYear);?></div> <b>IMDB: </b><div class="trep etk"><?php echo($movieIMDBscore);?></div> <b>Time: </b><div class="trep etk"><?php echo($mmovieTime);?></div>
				<?php if ($imdbID!="tt" && $imdbID!=""){?><div class="imdbS" title="<?php echo($movName);?> IMDB page"><a href="http://www.imdb.com/title/<?php echo($imdbID); ?>/?ref=<?php echo($_g_siteName);?>" rel="nofollow" target="_blank">Go to <img src="/core/css/images/imdb.png" alt="View IMDB page" /></a></div><?php }?>
				</li>
				<li><p><b>Description: </b><?php echo($descr);?></p></li>
				<li><div class="fSz14">Was added: <?php echo(convertDate($addedDate).".".($lastEditDate!=""?" Was edit: ".convertDate($lastEditDate).".":""));?></div></li>
			</ul>
			<div class="clr"></div>
		</div>
		<div class="emmicroData">
			<ol itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemlistlement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo($siteUrl); ?>/categories/movies/">
						<span itemprop="name">Movies</span>
					</a>
					<span itemprop="position" content="1"></span>
				</li>
				<li itemprop="itemlistlement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo($siteUrl); ?>/movies/<?php echo(createPageName($movCat));?>/<?php echo($categID);?>/">
						<span itemprop="name"><?php echo($movCat); ?></span>
					</a>
					<span itemprop="position" content="2"></span>
				</li>
				<li itemprop="itemlistlement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo($siteUrl); ?><?php echo(createMovieLink($_movieID,$conn));?>">
						<span itemprop="name"><?php echo($movName); ?></span>
					</a>
					<span itemprop="position" content="3"></span>
				</li>
			</ol>
			<div itemscope itemtype="http://schema.org/Movie">
				<h1 itemprop="name"><?php echo($movName);?></h1>
				<span itemprop="description"><?php echo($shortDesc); ?></span>
				<span itemprop="genre"><?php echo($movCat); ?></span>
				<span itemprop="URL"><?php echo($siteUrl.$mLn);?></span>
				<img itemprop="image" src="<?php echo($siteUrl."/".$movCov);?>" alt="<?php echo($movName);?>"/>
				<?php if ($totalVote!=0){ ?>
				<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
					<span itemprop="ratingValue"><?php echo($stScr==0?3:$stScr); ?></span>
					<span itemprop="bestRating">5</span>
					<span itemprop="ratingCount"><?php echo($totalVote==0?1:$totalVote);?></span>
				</div><?php }?>
				<div itemprop="dateCreated"><?php echo($lastEditDate!=""?$lastEditDate:$addedDate);?></div>
				<div itemprop="datePublished"><?php echo($lastEditDate!=""?$lastEditDate:$addedDate);?></div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
	<div class="load">
		<img src="/core/images/star.png" alt="Watch movie" />
		<img src="/core/images/star_h.png" alt="4k movies" />
	</div>
<script>
	function clckd(t){
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200 && this.responseText.indexOf("<?php echo($_g_siteName);?>")==-1 && this.responseText.indexOf("Maximum execution time of")==-1) {
				if (this.responseText.indexOf("redirect")!=-1){
					fas=this.responseText;
					fas=fas.split('.');
					alert("The page will be refreshed because the session has expired, please repeat the process.");
					location.reload();
				}
				else if (this.responseText.indexOf("^")!=-1){
					fas=this.responseText;
					fas=fas.split('^');
					alert(fas[2] + "\n\n");
					$("#grdRate").text(fas[0]);
					$("#grdRate").prop("title", "Star Score Average (Total "+fas[1]+" Vote)");
				}
				else alert(this.responseText.replace("<skipLine>","\n")+"\n\n");
			}
			buttonsWhatDo("ok");
		};
		xmlhttp.open("GET","/setAjax/"+t+"/<?php echo($_movieID);?>"+(t=="broken"?"_"+$("#em1").val():"")+"/<?php $_SESSION["ajaxControl_temp"]=null;$_SESSION["ajaxControl"]=uniqueID();echo($_SESSION["ajaxControl"]);?>",true);
		xmlhttp.send();
		buttonsWhatDo("wait");
	}

	$(function(){$(".starOutside").tooltip();});
</script>
<?php
	}
}
?>