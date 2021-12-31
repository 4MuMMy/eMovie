<?php
if (count(get_included_files()) == 1) {header("Location:/");die();}
else{

$_remove = (isset($_GET['remove']) ? $_GET['remove'] : null);

if ($_remove!=""){
if (isset($_COOKIE["moviesToWatch"])) {
    unset($_COOKIE["moviesToWatch[".$_remove."]"]);
    setcookie("moviesToWatch[".$_remove."]", "", time() - 3600, '/');
	header("Location:/watch-list");
	die();
}
}
?>
<h1 class="ttl">Watch List</h1>
<table class="list">
<tr><td>Movie name</td><td>Date Added</td><td></td></tr>
<?php 

if (isset($_COOKIE['moviesToWatch'])) {
    foreach ($_COOKIE['moviesToWatch'] as $name => $value) {
	$bol=explode("/",$value);
	$id=str_replace("]","",str_replace("moviesToWatch[","",$name));
	$url=createMovieLink($id,$conn);
?>
<tr><td><a href="<?php echo($url);?>"><?php echo($bol[0]);?></a></td><td><?php echo($bol[1]);?></td><td align="center"><a href="/watch-list/remove/<?php echo($id);?>" onclick="return confirm('Are you sure you want to remove the movie from your watch list?');" class="kldr">Kaldır</a></td></tr>
<?php } }else{?>
<tr><td colspan="3">Nothing has been added in your watch list yet.</td>
<?php }?>
</table>
<br />
<div class="pd">
Note: Your watch list is special to you and is stored with cookie technology. If you do not want to lose this list, please backup your browser's cookies.
</div>
<div class="clr"></div>
<?php }?>