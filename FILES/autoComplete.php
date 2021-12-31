<?php
session_start();

if ($_SERVER["REQUEST_URI"]=="/autoComplete.php"){header("Location:/");die();}
else{
include("settings.php");

$_searchedx = (isset($_GET['sr']) ? trim($conn->real_escape_string(urldecode($_GET['sr']))) : null);

if (strlen($_searchedx)>=$_g_searchBoxMinAutoCompleteLength){
	$xsszx=$conn->prepare("select movie_name,id from movies where lower(movie_name) like lower('%".$_searchedx."%') order by case when movie_name like lower('".$_searchedx."%') then 1 when movie_name like lower('% ".$_searchedx." %') then 2 when movie_name like lower('".$_searchedx."') then 3 when movie_name like lower('%".$_searchedx."%') then 4 else 5 end limit ".$_g_searchAutoCompleteMovieCount);
	$xsszx->execute();
	$resszx = $xsszx->get_result();
	while($_xsszx = mysqli_fetch_assoc($resszx)){
		echo("<div onmousedown=\"window.location='".createMovieLink($_xsszx["id"],$conn)."';\">".$_xsszx["movie_name"]."</div>");
	}
	$xsszx->close();
}

$conn->close();
}
?>