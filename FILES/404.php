<?php 
if (count(get_included_files()) == 1 || $_SERVER["REQUEST_URI"]=="/404.php") {header("Location:/");die();}
else{
http_response_code(404);
header('HTTP/1.0 404 Not Found', true, 404);
?>
<h1 class="ttl">404 Page Not Found</h1>
<div class="pdLR20" align="center">
<img src="/core/images/404.png" alt="404" /><br />There is no such page on our site.<br /><small>You will be redirected to the homepage soon.</small>
</div>
<div class="clr"></div>
<meta http-equiv="refresh" content="20;URL=/" />
<?php }?>