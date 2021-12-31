<?php
error_reporting(1);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$siteUrl="http://".str_replace("www.","",$_SERVER['HTTP_HOST']);

ini_set('session.cookie_domain', '.'.$siteUrl );

header('cache-control: no-cache,no-store,must-revalidate'); // HTTP 1.1.
header('pragma: no-cache'); // HTTP 1.0.
header('expires: 0'); // Proxies.

if (count(get_included_files()) == 1) {header("Location:/");die();}
else{
	//______________CHANGE HERE >
	date_default_timezone_set('Europe/London');
	header('Content-Type: text/html; charset=utf-8');
	
	//DB SETTINGS >> 'DB IP','DB ID','DB PW', 'DB NAME'
	$conn = new mysqli('localhost', 'root', '', 'emovie');
	$conn->set_charset("utf8");
	if ($conn->connect_error) {
		die("Database connection error: " . $conn->connect_error);
	}


	$_version="2.0.0";
	
	$_g_siteName="eMovie";
	
	$_g_moviePerPage=21;
	$_g_slideMovieCount=30;
	$_g_rightMenuMovieCount=8;
	$_g_searchAutoCompleteMovieCount=10;
	$_g_mostPopularMoviesPageCount=50;
	$_g_topRatedMoviesPageCount=50;
	$_g_latestMoviesPageCount=50;
	$_g_RSSMovieCount=30;
	$_g_searchPageMinSearchLength=2;
	$_g_searchBoxMinAutoCompleteLength=2;
	
	$_g_ADMIN_ID="admin";
	$_g_ADMIN_PW="admin";
	//______________CHANGE HERE <
}

function alert($t){echo("<script>alert(\"$t\");</script>");}
function redirect($url){echo("<script>window.location=\"$url\";</script>");}

function uniqueID(){return md5(uniqid(mt_rand(),true));};

function grandomString($length = 10){return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function createPageName($t){
	$r = mb_strtolower($t,"utf-8");

	$r = str_replace("\"", "",$r); $r = str_replace("/", "",$r);
	$r = str_replace("(", "",$r); $r = str_replace(")", "",$r);
	$r = str_replace("{", "",$r); $r = str_replace("}", "",$r);
	$r = str_replace("%", "",$r); $r = str_replace("&", "",$r);
	$r = str_replace("+", "",$r); $r = str_replace(",", "",$r);
	$r = str_replace("?", "",$r); $r = str_replace("#", "",$r);
	$r = str_replace("-", "",$r); $r = str_replace(" ", "-",$r);
	$r = str_replace("ç", "c",$r); $r = str_replace("ğ", "g",$r);
	$r = str_replace("ı", "i",$r); $r = str_replace("ö", "o",$r);
	$r = str_replace("ş", "s",$r); $r = str_replace("ü", "u",$r);
	$r = str_replace("'", "",$r);
	$r = str_replace(".", "",$r); $r = str_replace(":", "",$r);
	

	$r = str_replace("-", "+",$r);
	$r = trim($r);
	$r = mb_ereg_replace("[^a-zA-Z0-9+]","",$r);
	$r = trim($r);
	$r = str_replace("+", "-",$r);
	
	return $r;
}

function createFileName($yazi){
	$r = createPageName($yazi);
	$r = mb_ereg_replace("/[^a-zA-Z0-9_.-]/","",$r);
	$r = $r."-EM".grandomString(15);
	return $r;
}

function createMovieLink($xid,$conn){
	$movx=$conn->prepare("select movies.id,categories.cateName,movies.movie_name,movies.movieYear from movies inner join categories on movies.movie_category=categories.id where movies.id=?");
	$movx->bind_param("s",$xid);
	$movx->execute();
	$flmm=$movx->get_result();
	if($_movx = mysqli_fetch_assoc($flmm)){
	$_mov_id_=$_movx["id"];
	$_catx=$_movx["cateName"];
	$_movNm=$_movx["movie_name"];
	$_movY=$_movx["movieYear"];
	$r="/movie/".createPageName($_catx)."/watch-".createPageName($_movNm)."-".$_movY."/".$_mov_id_;
	}
	else {
		$r="/?source=error";
	}
	return $r;
}

function doPage($pageUrl,$table, $queryString, $conn, $regPerPage = 1, $totalPagingButton = 11){
	
	global $_g_siteName;
	
	$sorgu="select count(*) as tpReg from ".$table;
	
	if (strpos($pageUrl,"/detailed-search/")!==false) $sorgu="select count(distinct movies.id) as tpReg from ".$table;
	
	$sox=$conn->prepare($sorgu);
	$sox->execute();
	$deget=$sox->get_result();
	if ($ttvt = mysqli_fetch_assoc($deget)){
	$totalReg=$ttvt["tpReg"];
	}
	else $totalReg=0;
	
	$totalPage = ceil($totalReg / $regPerPage);
	
	$_page = isset($_GET[$queryString]) ? (int) $_GET[$queryString] : 1;
	if($_page < 1) $_page = 1;
	if($_page > $totalPage) $_page = $totalPage; 
	
	$limitx = ($_page - 1) * $regPerPage;
	
	$r="0, ".$regPerPage."~";
	
	if ($limitx>=0){
		$r=$limitx.", ".$regPerPage."~";
		
		$min_medium = ceil($totalPagingButton/2);
		$max_medium = ($totalPage+1) - $min_medium;
		
		$page_avg = $_page;
		if($page_avg < $min_medium) $page_avg = $min_medium;
		if($page_avg > $max_medium) $page_avg = $max_medium;
		 
		$left_pages = round($page_avg - (($totalPagingButton-1) / 2));
		$right_pages = round((($totalPagingButton-1) / 2) + $page_avg); 
		 
		if($left_pages < 1) $left_pages = 1;
		if($right_pages > $totalPage) $right_pages = $totalPage;
		 
		if($_page != 1) $r.="<a href=\"".$pageUrl."/1#".$_g_siteName."\"><div class=\"sNode\">&lt;&lt; First</div></a>";
		if($_page != 1) $r.="<a href=\"".$pageUrl."/".($_page-1)."#".$_g_siteName."\"><div class=\"sNode\">&lt; Previous</div></a>";
		 
		for($sx = $left_pages; $sx <= $right_pages; $sx++) {
			if($_page == $sx) {
			  $r.="<a href=\"#".$_g_siteName."\" onclick=\"return false;\"><div class=\"sNode sNodeA\">".$sx."</div></a>"; 
		   } else {
			  $r.="<a href=\"".$pageUrl."/" . $sx . "#".$_g_siteName."\"><div class=\"sNode\">" . $sx . "</div></a>";
			}
		}
		 
		if($_page != $totalPage) $r.="<a href=\"".$pageUrl."/".($_page+1)."#".$_g_siteName."\"><div class=\"sNode\">Next &gt;</div></a>";
		if($_page != $totalPage) $r.="<a href=\"".$pageUrl."/".$totalPage."#".$_g_siteName."\"><div class=\"sNode\">Last &gt;&gt;</div></a>";
	}
	
	return $r;
}

function oneReg($column,$table,$conn){
	$r="";
	$xs=$conn->prepare("select ".$column." from ".$table);
	$xs->execute();
	$res = $xs->get_result();
	if($_xs = mysqli_fetch_assoc($res)){
		$r=$_xs[$column];
	}
	return $r;
}

function convertDate($dt){
	$days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	$months = array('January','February','March','April','May','June','July','August','September','October','November','December');
	return $days[date("N",strtotime($dt))-1].", ".$months[date("m",strtotime($dt))-1]." ".date("j",strtotime($dt)).", ".date("Y",strtotime($dt)).", ".date("h:i A",strtotime($dt));
}

?>