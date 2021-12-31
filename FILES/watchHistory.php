<?php
if (count(get_included_files()) == 1) {header("Location:/");die();}
else{

$_remove = (isset($_GET['remove']) ? $_GET['remove'] : null);

if ($_remove!=""){
if (isset($_COOKIE["watchedMovies"])) {
    unset($_COOKIE["watchedMovies[".$_remove."]"]);
    setcookie("watchedMovies[".$_remove."]", "", time() - 3600, '/');
	header("Location:/watch-history");
	die();
}
}
?>
<h1 class="ttl">Watch History</h1>
<table class="list">
<tr><td>Movie name</td><td>Date Added</td><td></td></tr>
<?php 

if (isset($_COOKIE['watchedMovies'])) {
    foreach ($_COOKIE['watchedMovies'] as $name => $value) {
	$bol=explode("/",$value);
	$id=str_replace("]","",str_replace("moviesToWatch[","",$name));
?>
<tr><td><a href="<?php echo(createMovieLink($id,$conn));?>"><?php echo($bol[0]);?></a></td><td><?php echo($bol[1]);?></td><td align="center"><a href="/watch-history/remove/<?php echo($id);?>" onclick="return confirm('Are you sure you want to remove the movie from your watch history?');" class="kldr">Remove</a></td></tr>
<?php } }else{?>
<tr><td colspan="3">Nothing has been added in your watch history yet.</td>
<?php }?>
</table>
<br />
<div class="pd">
Note: Your watch history is special to you and is stored with cookie technology. If you do not want to lose this list, please backup your browser's cookies.
</div>
<div class="clr"></div>
<?php }?>