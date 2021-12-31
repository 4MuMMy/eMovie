<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors',TRUE);

if (count(get_included_files()) == 1) {header("Location:/");die();}
else{
$k = (isset($_GET['k']) ? $_GET['k'] : null);

if ($k=="exit"){
	session_unset();
	session_destroy();
	header("Location:/");
}

function movCode_replace($fk){
	$fk=str_replace('frameborder="0"',"",$fk);
	$fk=str_replace('scrolling="no"',"",$fk);
	return $fk;
}

if (isset($_SESSION)){

if(empty($_SESSION["admin_"]) && empty($_SESSION["who_"]))
{
	if (isset($_POST)){
		if(isset($_POST['id']) && isset($_POST['pw']))
		{
			$g_id=$_POST['id'];
			$g_pw=$_POST['pw'];
			
			if ($g_id==$_g_ADMIN_ID && $g_pw==$_g_ADMIN_PW){
				$_SESSION["admin_"] = "active";
				$_SESSION["who_"] = $_g_ADMIN_ID;
				header("Location:/_admin_");
			}
		}
	}
	
	?>
	<div class="pd" align="center">
	<form method="post">
	ID: <input type="text" name="id" />
	PW: <input type="password" name="pw" />
	<input type="submit" value="Login" /><br /><br />
	</form>
	</div>
	<?php
}
else{
	if ($_SESSION["admin_"]=="active"){
	//recommended image sizes: width: 260px, height: 360px
	$dateNow=date("Y-m-d H:i:s");

	$_id = (isset($_GET['_id']) ? $_GET['_id'] : null);
	$_sid = (isset($_GET['_sid']) ? $_GET['_sid'] : null);
	$active="class='active'";
	$em_movName="";
?>
<style type="text/css">
.adminPanel{margin-top:20px;}
.adminMenu{list-style:none;margin-left:5px;}
.adminMenu li{float:left;margin-bottom:15px;}
.adminMenu li a, .reBtn{color:#ccc;background:#333;padding:5px 10px 5px 10px;margin-left:5px;text-align:center;border-radius:3px;}
.reBtn{min-width:125px;float:right;font-size:14px;padding:5px 10px 5px 10px;}
.adminMenu li a:hover, .reBtn:hover{background:#666!important;color:#ccc!important;}
.a_act li a{background:#0697cc!important;color:#fff!important;}
.active a{background:#07bcff!important;color:#fff!important;}
.listit{width:100%;}
.listit tr td img{width:100px;}
.listit tr:nth-child(1) td{font-weight:bold;}
.listit tr td{padding:10px;}
.listit tr td:nth-child(even){background:#bbb;}
.listit tr td:nth-child(odd){background:#aaa;}

fieldset{padding:20px;margin:20px;}

.lnks{margin:0px 0px 100px 25px;}

.lnks ul{margin-bottom:25px;}
</style>
<div class="pd pdLR">Welcome <b><?php echo($_SESSION["who_"]);?></b>, how are you today?</div>
<div class="adminPanel">
	<ul class="adminMenu">
	<li <?php echo($k==""?$active:"");?>><a href="/_admin_">Admin Panel Home</a></li>
	<li <?php echo($k=="movies" || $k=="movies_one" || $k=="broken_links" || $k=="no_imdb" || $k=="add_movie" || $k=="edit_movie" || $k=="last_updates" || $k=="same_name_movies"?$active:"");?>><a href="/_admin_/movies">Manage Movies</a></li>
	<li <?php echo($k=="movie_categories" || $k=="add_movCate" || $k=="edit_movCate"?$active:"");?>><a href="/_admin_/movie_categories">Manage Movie Categories</a></li>
	<li><a href="/_admin_/exit" onclick="return confirm('Are you sure you want to logout?');">Logout</a></li>
	</ul>
	<div class="clr"></div>
	<?php
	if ($k==""){
	?>
	<div class="ttl">Useful Links</div>
	<div class="pdLR lnks">
		<ul>
			<li><a href="http://www.imdb.com/movies-in-theaters/" target="_blank">IMDB: Movies currently in theaters and coming soon</a></li>
			<li><a href="http://www.imdb.com/year/<?php echo(date("Y")); ?>" target="_blank">IMDB: The most popular movies of this year (<?php echo(date("Y"));?>)</a></li>
			<li><a href="http://www.imdb.com/year/<?php echo(date("Y")-1); ?>" target="_blank">IMDB: The most popular movies of the past year (<?php echo(date("Y")-1);?>)</a></li>
			<li><a href="http://www.imdb.com/year/<?php echo(date("Y")+1); ?>" target="_blank">IMDB: Movies coming out next year (<?php echo(date("Y")+1);?>)</a></li>
		</ul>
	</div>
	<?php }
	
	if (strrpos($k,"add_movie")!==false || $k=="edit_movie"){
		$fid="";
		$mov_cover="";
		$mov_name = (isset($_POST['_mov_name']) ? $_POST['_mov_name'] : null);
		$mov_cate = (isset($_POST['_mov_cate']) ? $_POST['_mov_cate'] : null);
		$short_desc = (isset($_POST['_short_desc']) ? $_POST['_short_desc'] : null);
		$mov_code = (isset($_POST['_mov_code']) ? $_POST['_mov_code'] : null);
		$descr = (isset($_POST['_descr']) ? $_POST['_descr'] : null);
		$watching_type = (isset($_POST['_watching_type']) ? $_POST['_watching_type'] : null);
		$source_name = (isset($_POST['_source_name']) ? $_POST['_source_name'] : null);
		$lang_setting = (isset($_POST['_lang_setting']) ? $_POST['_lang_setting'] : null);
		$_imdbID = (isset($_POST['_imdbID']) ? $_POST['_imdbID'] : "tt");
		$myear = (isset($_POST['_myear']) ? $_POST['_myear'] : null);
		$mtime = (isset($_POST['_mtime']) ? $_POST['_mtime'] : null);
		$mimdbScore = (isset($_POST['_mimdbScore']) ? $_POST['_mimdbScore'] : null);
		
		$mov_name = str_replace('"',"″",$mov_name);
		$mov_cate = str_replace('"',"″",$mov_cate);
		$short_desc = str_replace('"',"″",$short_desc);
		$watching_type = str_replace('"',"″",$watching_type);
		$source_name = str_replace('"',"″",$source_name);
		$lang_setting = str_replace('"',"″",$lang_setting);
	}
	
	if ($k=="add_movCate" || $k=="edit_movCate"){
		$cateName = (isset($_POST['_cateName']) ? $_POST['_cateName'] : null);
		$cateName = str_replace('"',"″",$cateName);
	}
	
	if ($k=="add_movie_option" || $k=="edit_movie_option"){
		
		$em_watching_type = (isset($_POST['_em_watching_type']) ? $_POST['_em_watching_type'] : null);
		$em_source_name = (isset($_POST['_em_source_name']) ? $_POST['_em_source_name'] : null);
		$em_lang_setting = (isset($_POST['_em_lang_setting']) ? $_POST['_em_lang_setting'] : null);
		$em_mov_code = (isset($_POST['_em_mov_code']) ? $_POST['_em_mov_code'] : null);
		
		$mov_name_sel=$conn->prepare("select movie_name from movies where id=?");
		$mov_name_sel->bind_param("s",$_id);
		$mov_name_sel->execute();
		$fac = $mov_name_sel->get_result();
		if($facx = mysqli_fetch_assoc($fac)){
			$em_movName=$facx["movie_name"];
		}
		
		$em_watching_type = str_replace('"',"″",$em_watching_type);
		$em_source_name = str_replace('"',"″",$em_source_name);
		$em_lang_setting = str_replace('"',"″",$em_lang_setting);
		$em_movName = str_replace('"',"″",$em_movName);
	}
	
	if ($k=="add_movie")
	{
		if (!empty($_POST)){
			
			$mov_cover = !empty($_FILES["_mov_cover"]) ? basename($_FILES["_mov_cover"]["name"]) : "";
		
			$im_tmp = (isset($_POST['imdb_temp']) ? $_POST['imdb_temp'] : null);
			if ($im_tmp=="active") $mov_cover="movie_cover/imdb_temp.jpg";
		
			if ($mov_cover!="" &&$mov_name!="" &&$mov_cate!="" && $short_desc!="" && 
			$mov_code!="" &&$descr!="" &&$watching_type!="" &&$source_name!="" &&
			$lang_setting!="" && $_imdbID!="" && $myear!="" && $mtime!="" && $mimdbScore!="")
			{
				if ($im_tmp=="active"){
				$target_file = $mov_cover;
				$mov_cover_tmp=$mov_cover;
				}
				else{
				$target_file = "movie_cover/$mov_cover";
				$mov_cover_tmp= !empty($_FILES["_mov_cover"]) ? $_FILES["_mov_cover"]["tmp_name"] : "";
				}
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				$imagePath="movie_cover/".createFileName($mov_name).".".$imageFileType;
				
				$check = getimagesize($mov_cover_tmp);
				if($check !== false) $uploadOk = 1;
				else $uploadOk = 0;
				
				if (file_exists($imagePath)) {
					alert("An image with this name already exists on the server.");
					$uploadOk = 0;
				}
				if (!empty($_FILES["_mov_cover"]) ? ($_FILES["_mov_cover"]["size"] > 5000000) : false) {//byte
					alert("Image size can be up to 5 mb.");
					$uploadOk = 0;
				}
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
					alert("Only JPG, JPEG, PNG & GIF formats are supported.");
					$uploadOk = 0;
				}
				
				if ($uploadOk == 0) {
					alert("The movie cover was not loaded because it did not meet the requirements.");
				} else {
					
					$src9x=$mov_cover_tmp;
					if ($imageFileType == "jpg" || $imageFileType == "jpeg") $img9x = imagecreatefromjpeg($src9x);
					else if ($imageFileType == "png") $img9x=imagecreatefrompng($src9x);
					else if ($imageFileType == "gif") $img9x=imagecreatefromgif($src9x);
					list($width9x, $height9x) = getimagesize($src9x);
					$canvas9x=imagecreatetruecolor(260, 360);
					imagefilledrectangle($canvas9x,0,0,260,360,imagecolorallocate($img9x, 206, 206, 206));
					imagecopyresampled($canvas9x, $img9x, 0, 0, 0, 0, 260, 360, $width9x, $height9x);
					imagejpeg($canvas9x,$mov_cover_tmp,100);
						
					if ($im_tmp=="active" || move_uploaded_file($mov_cover_tmp, $imagePath)) {
						
						if ($im_tmp=="active"?copy($mov_cover_tmp,$imagePath):true){
								
						$ok=false;
						try{
							
						if ($add_moviex = $conn->prepare("insert into movies(movie_name,movie_category,movie_cover,short_desc,description,hit,imdbID,addedDate,movieYear,movieTime,imdbScore) values(?,?,?,?,?,'0',?,?,?,?,?)")){
							$add_moviex->bind_param("ssssssssss",$mov_name, $mov_cate, $imagePath, $short_desc, $descr, $_imdbID, $dateNow, $myear, $mtime, $mimdbScore);
							$add_moviex->execute();
							$add_moviex->close();
						}
						
						$lastMovID="";
					
						$emda=$conn->prepare("select id from movies order by id desc");
						$emda->execute();
						$facxe = $emda->get_result();
						if($facxex = mysqli_fetch_assoc($facxe)){
							$lastMovID=$facxex["id"];
						}
						
						$mov_code=movCode_replace($mov_code);
						
						if ($add_movie_option = $conn->prepare("insert into options(watching_type,source_name,lang_setting,source_code,fid) values(?,?,?,?,?)")){
						$add_movie_option->bind_param("sssss", $watching_type, $source_name, $lang_setting, $mov_code, $lastMovID);
						$add_movie_option->execute();
						$add_movie_option->close();
						}
						
						$ok=true;
						}
						catch(Exception $e){
							$ok=false;
						}
						
						if (!$ok){
							alert("There was a problem adding the movie to the database.");
							if (is_file($target_file)) unlink($target_file);
						}
						else {
							alert("Movie successfully added!");
							redirect("/_admin_/movies");
						}
						}
						else alert("An error occurred while loading the movie cover and the movie was not added.");
						
					} else {
						alert("An error occurred while loading the movie cover and the movie was not added!");
					}
				}
			}
			else{alert("The form has several blank fields.");}
			
		}
			
		?>
		<?php $sg=$conn->query("select * from categories order by id desc");?>
		<div class="ttl"><?php echo("Add New Movie");?></div>
		<form method="post" enctype="multipart/form-data" name="movAddFrm">
		<table class="ilTbl">
		<tr><td>Cover Image: </td><td>
		<?php echo("<input type=\"file\" name=\"_mov_cover\" />");?>
		</td></tr>
		<tr><td>Category: </td><td>
		<select name="_mov_cate">
		<?php while($vt_ = $sg->fetch_assoc()){ ?>
		<option <?php echo($mov_cate==$vt_["id"] || strtolower($mov_cate)==strtolower($vt_["cateName"])?"selected=\"selected\"":""); ?> value="<?php echo($vt_["id"]);?>"><?php echo($vt_["cateName"]);?></option>
		<?php }?>
		</select></td></tr>
		<tr><td>Name: </td><td><input type="text" name="_mov_name" value="<?php echo($mov_name);?>" /><br />Number of characters: <span id="chrctr">0</span> (Preferably max. 55 characters)</td></tr>
		<tr><td>Year: </td><td><input type="text" name="_myear" value="<?php echo($myear);?>" /></td></tr>
		<tr><td>Time: </td><td><input type="text" name="_mtime" value="<?php echo($mtime);?>" /><br />in 00:00:00 format</td></tr>
		<tr><td>IMDB ID: </td><td><input type="text" name="_imdbID" value="<?php echo($_imdbID);?>" /></td></tr>
		<tr><td>IMDB Score: </td><td><input type="text" name="_mimdbScore" value="<?php echo($mimdbScore);?>" /><br />in 0.0 format (dotless entry is also possible)</td></tr>
		<tr><td>Short Description: </td><td><input type="text" name="_short_desc" value="<?php echo($short_desc);?>" /><br />Number of characters: <span id="kchrctr">0</span> (Preferably max. 164 characters)</td></tr>
		<tr><td>Description: </td><td><textarea name="_descr"><?php echo($descr);?></textarea></td></tr>
		<tr><td>Watching Type: </td><td><input type="text" name="_watching_type" value="<?php echo($watching_type);?>" /></td></tr>
		<tr><td>Source Name: </td><td><input type="text" name="_source_name" value="<?php echo($source_name);?>" /></td></tr>
		<tr><td>Language: </td><td><input type="text" name="_lang_setting" value="<?php echo($lang_setting);?>" /></td></tr>
		<tr><td>Movie Player Code: </td><td><textarea name="_mov_code"><?php echo($mov_code);?></textarea></td></tr>
		<tr><td colspan="2" align="right"><input type="submit" name="send" value="Add Movie" /></td></tr>
		</table>
		</form>
		<script>
		function kr_sy(){
			$("#chrctr").text($(this).val().length);
		}
		function kr_sy2(){
			$("#kchrctr").text($(this).val().length);
		}
		$('input[name="_mov_name"]').keyup(kr_sy);
		$('input[name="_mov_name"]').change(kr_sy);
		$('input[name="_short_desc"]').keyup(kr_sy2);
		$('input[name="_short_desc"]').change(kr_sy2);
		</script>
		<div class="clr"></div>
		<?php
		}
		else if ($k=="edit_movie" && $_id!="")
		{
			$_hit="";
			if (empty($_POST)){
				$xs=$conn->prepare("select * from movies where id=?");
				$xs->bind_param("s",$_id);
				$xs->execute();
				$res = $xs->get_result();
				while($_xs = mysqli_fetch_assoc($res)){
					$fid=$_xs["id"];
					$mov_cover=$_xs["movie_cover"];
					$mov_name = $_xs["movie_name"];
					$mov_cate = $_xs["movie_category"];
					$short_desc = $_xs["short_desc"];
					$descr = $_xs["description"];
					$_imdbID = $_xs["imdbID"];
					$_hit = $_xs["hit"];
					$myear =  $_xs["movieYear"];
					$mtime = $_xs["movieTime"];
					$mimdbScore = $_xs["imdbScore"];
					$_lastEditDatexx = $_xs["lastEditDate"];
					$_addedDatexx = $_xs["addedDate"];
					
					$mov_name=str_replace('"',"″",$mov_name);
					$mov_cate=str_replace('"',"″",$mov_cate);
					$short_desc=str_replace('"',"″",$short_desc);
				}
			}
			else{
				
				
			$xs2=$conn->prepare("select * from movies where id=?");
			$xs2->bind_param("s",$_id);
			$xs2->execute();
			$res2 = $xs2->get_result();
			while($_xs2 = mysqli_fetch_assoc($res2)){
				$mov_cover=$_xs2["movie_cover"];
			}
				
			$__mov_cover = !empty($_FILES["_mov_cover"]) ? basename($_FILES["_mov_cover"]["name"]) : "";
			
			if ($mov_name!="" &&$mov_cate!="" && $short_desc!="" &&
				$descr!="" && $_imdbID!="" && $myear!="" && $mtime!="" && $mimdbScore!="")
				{
					if ($__mov_cover!=""){
						
						$target_file = "movie_cover/$__mov_cover";
						$mov_cover_tmp= !empty($_FILES["_mov_cover"]) ? $_FILES["_mov_cover"]["tmp_name"] : "";
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						$imagePath="movie_cover/".createFileName($mov_name).".".$imageFileType;
						
						
						$check = getimagesize($mov_cover_tmp);
						if($check !== false) $uploadOk = 1;
						else $uploadOk = 0;
						
						if (!empty($_FILES["_mov_cover"]) ? ($_FILES["_mov_cover"]["size"] > 5000000) : false) {//byte
							alert("An image with this name already exists on the server.");
							$uploadOk = 0;
						}
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
							alert("Only JPG, JPEG, PNG & GIF formats are supported.");
							$uploadOk = 0;
						}
						
						if ($uploadOk == 0) {
							alert("The movie cover was not loaded because it did not meet the requirements.");
						} else {
								$src9x=$mov_cover_tmp;
								if ($imageFileType == "jpg" || $imageFileType == "jpeg") $img9x = imagecreatefromjpeg($src9x);
								else if ($imageFileType == "png") $img9x=imagecreatefrompng($src9x);
								else if ($imageFileType == "gif") $img9x=imagecreatefromgif($src9x);
								list($width9x, $height9x) = getimagesize($src9x);
								$canvas9x=imagecreatetruecolor(260, 360);
								imagefilledrectangle($canvas9x,0,0,260,360,imagecolorallocate($img9x, 206, 206, 206));
								imagecopyresampled($canvas9x, $img9x, 0, 0, 0, 0, 260, 360, $width9x, $height9x);
								imagejpeg($canvas9x,$mov_cover_tmp,100);
								
								if (is_file($mov_cover)) unlink($mov_cover);
								
								if (move_uploaded_file($mov_cover_tmp, $imagePath)) {
									$mov_cover=$imagePath;
							
								} else {
									alert("An error occurred while loading the movie cover and the movie could not be edited!");
									die();
								}
						}
					
					}
					
					$ok=false;
					try{
						if ($edit_movie = $conn->prepare("update movies set movie_name=?,movie_category=?,movie_cover=?,short_desc=?,description=?,imdbID=?,lastEditDate=?,movieYear=?,movieTime=?,imdbScore=? where id=?")){
						$edit_movie->bind_param("sssssssssss",$mov_name, $mov_cate, $mov_cover, $short_desc, $descr, $_imdbID, $dateNow, $myear, $mtime, $mimdbScore, $_id);
						$edit_movie->execute();
						$edit_movie->close();
						}
						$ok=true;
					}
					catch(Exception $e){
						$ok=false;
					}
					
					if (!$ok){
						alert("There was a problem editing the movie.");
					}
					else {
						alert("The movie was successfully edited!");
						redirect("/_admin_/movies");
						
					}
				}
				else{alert("The form has several blank fields.");}
				
			}
		
		?>
		<?php $sg=$conn->query("select * from categories order by id desc");?>
		<div class="ttl">Edit Movie &gt; <?php echo($mov_name);?></div>
		<form method="post" enctype="multipart/form-data" name="editMovieFrm">
		<table class="ilTbl">
		<tr><td>Movie Cover: </td><td><a href="<?php echo(createMovieLink($fid,$conn));?>" target="_blank"><img src="/<?php echo($mov_cover); ?>" /></a><input type="file" name="_mov_cover" /></td></tr>
		<tr><td>Category: </td><td>
		<select name="_mov_cate">
		<?php while($vt_ = $sg->fetch_assoc()){ ?>
		<option <?php echo($mov_cate==$vt_["id"]?"selected=\"selected\"":""); ?> value="<?php echo($vt_["id"]);?>"><?php echo($vt_["cateName"]);?></option>
		<?php }?>
		</select></td></tr>
		<tr><td>Name: </td><td><input type="text" name="_mov_name" value="<?php echo($mov_name);?>" /><br />Number of characters: <span id="chrctr">0</span> (Preferably max. 55 characters)</td></tr>
		<tr><td>Year: </td><td><input type="text" name="_myear" value="<?php echo($myear);?>" /></td></tr>
		<tr><td>Time: </td><td><input type="text" name="_mtime" value="<?php echo($mtime);?>" /><br />in 00:00:00 format</td></tr>
		<tr><td>IMDB ID: </td><td><input type="text" name="_imdbID" value="<?php echo($_imdbID);?>" /></td></tr>
		<tr><td>IMDB Score: </td><td><input type="text" name="_mimdbScore" value="<?php echo($mimdbScore);?>" /><br />in 0.0 format (dotless entry is also possible) - <a href="http://www.imdb.com/title/<?php echo($_imdbID); ?>/?ref=<?php echo($_g_siteName);?>" target="_blank"><b>Go to IMDB</b></a></td></tr>
		<tr><td>Short Description: </td><td><input type="text" name="_short_desc" value="<?php echo($short_desc);?>" /><br />Number of characters: <span id="kchrctr">0</span> (Preferably max. 164 characters)</td></tr>
		<tr><td>Description: </td><td><textarea name="_descr"><?php echo($descr);?></textarea></td></tr>
		<tr><td>Hit: </td><td><input type="text" name="_hit" disabled="disabled" value="<?php echo($_hit);?>" /></td></tr>
		<tr><td>Added Date:</td><td><b><?php echo(convertDate($_addedDatexx));?></b> <?php if ($_lastEditDatexx!=""){?>- Last Edit: <?php echo("<b>".convertDate($_lastEditDatexx)."</b>"); }?></td></tr>
		<tr><td><a href="/_admin_/delete_movie/<?php echo($_id); ?>" onclick="return confirm('Are you sure you want to delete the movie? The movie will be deleted along with all movie options in it.');"><div class="reBtn">Delete Movie</div></a></td><td align="right"><input type="submit" name="send" value="Edit Movie" /></td></tr>
		</table>
		</form>
		<div class="ttl">Edit Movie Options</div>
		<ul class="adminMenu">
		<li><a href="/_admin_/add_movie_option/<?php echo($_id);?>">Add New Movie Option</a></li>
		</ul>
		<?php $options_sel=$conn->prepare("select * from options where fid=? order by id desc");
				$options_sel->bind_param("s",$_id);
				$options_sel->execute();
				$emc2 = $options_sel->get_result();
				?>
		<table class="listit">
			<tr><td>id</td><td>Watching Type</td><td>Source Name</td><td>Language</td><td></td></tr>
			<?php
			if($emc2->num_rows > 0){
				while($emc = mysqli_fetch_assoc($emc2)){ ?>
				<tr><td><?php echo($emc["id"]);?></td>
				<td><?php echo($emc["watching_type"]);?></td>
				<td><?php echo($emc["source_name"]);?></td>
				<td><?php echo($emc["lang_setting"]);?></td>
				<td>
				<a href="/_admin_/edit_movie_option/<?php echo($emc["fid"]); ?>/<?php echo($emc["id"]);?>"><div class="reBtn">Edit</div></a>
				<a href="/_admin_/delete_movOption/<?php echo($emc["fid"]); ?>/<?php echo($emc["id"]);?>" onclick="return confirm('Are you sure you want to delete the movie option?');"><div class="reBtn">Delete</div></a>
				<br /><br />
				</td>
				</tr>
				<tr>
				<td colspan="5" align="center"><?php echo($emc["source_code"]);?></td>
				</tr>
				<?php }
				}else{?>
			<tr><td colspan="5">Table is empty.</td></tr>
			<?php } ?>
		</table>
		<script>
		function kr_sy(){
			$("#chrctr").text($(this).val().length);
		}
		function kr_sy2(){
			$("#kchrctr").text($(this).val().length);
		}
		$('input[name="_mov_name"]').keyup(kr_sy);
		$('input[name="_mov_name"]').change(kr_sy);
		$('input[name="_short_desc"]').keyup(kr_sy2);
		$('input[name="_short_desc"]').change(kr_sy2);
		$('input[name="_mov_name"]').change();
		$('input[name="_short_desc"]').change();
		</script>
		<div class="clr"></div>
		<?php
		}
		else if ($k=="delete_movie" && $_id!="")
		{
			$deletingImg="";
			$xs3=$conn->prepare("select * from movies where id=?");
			$xs3->bind_param("s",$_id);
			$xs3->execute();
			$res3 = $xs3->get_result();
			if($_xs3 = mysqli_fetch_assoc($res3)){
				$deletingImg=$_xs3["movie_cover"];
			}
			$xs3->close();
			
			if ($delete_movOption = $conn->prepare("delete from options where fid=?")){
			$delete_movOption->bind_param("s", $_id);
			$delete_movOption->execute();
			$delete_movOption->close();
			}
			
			if ($delete_movie = $conn->prepare("delete from movies where id=?")){
			$delete_movie->bind_param("s", $_id);
			$delete_movie->execute();
			$delete_movie->close();
			}
			
			if (is_file($deletingImg)) unlink($deletingImg);
			alert("The movie and the movie options in it have been deleted successfully!");
			redirect("/_admin_/movies");
		?>
		<?php
		}
		else if ($k=="add_movCate")
		{
			if (!empty($_POST)){
			
				if ($cateName!="")
				{
					$ok=false;
					try{
					if ($add_movCate = $conn->prepare("insert into categories(cateName) values(?)")){
					$add_movCate->bind_param("s",$cateName);
					$add_movCate->execute();
					$add_movCate->close();
					}
					$ok=true;
					}
					catch(Exception $e){
						$ok=false;
					}
					
					if (!$ok){
						alert("There was a problem adding the movie category to the database.");
					}
					else {
						alert("Movie category added successfully!");
						redirect("/_admin_/movie_categories");
					}
				}
				else{alert("Category name is empty.");}
			}
		?>
		<div class="ttl">Add New Movie Category</div>
		<form method="post" name="addMovCatFrm">
		<table class="ilTbl">
		<tr><td>Category Name: </td><td><input type="text" name="_cateName" value="<?php echo($cateName);?>" /></td></tr>
		<tr><td colspan="2" align="right"><input type="submit" name="send" value="Add Movie Category" /></td></tr>
		</table>
		</form>
		<div class="clr"></div>
		<?php
		}
		else if ($k=="edit_movCate" && $_id!="")
		{
			if (empty($_POST)){
				$xs=$conn->prepare("select * from categories where id=?");
				$xs->bind_param("s",$_id);
				$xs->execute();
				$res = $xs->get_result();
				if($_xs = mysqli_fetch_assoc($res)){
					$cateName=$_xs["cateName"];
				}
			}
			else{
				if ($cateName!="")
				{
					$ok=false;
					try{
					if ($edit_movCate = $conn->prepare("update categories set cateName=? where id=?")){
					$edit_movCate->bind_param("ss",$cateName, $_id);
					$edit_movCate->execute();
					$edit_movCate->close();
					}
					$ok=true;
					}
					catch(Exception $e){
						$ok=false;
					}
					
					if (!$ok){
						alert("There was a problem editing the movie category.");
					}
					else {
						alert("Movie category successfully edited!");
						redirect("/_admin_/movie_categories");
						
					}
				}
				else{alert("Category name is empty.");}
			}
				
		?>
		<div class="ttl">Edit Movie Category</div>
		<form method="post" name="editMovCatFrm">
		<table class="ilTbl">
		<tr><td>Category Name: </td><td><input type="text" name="_cateName" value="<?php echo($cateName);?>" /></td></tr>
		<tr><td colspan="2" align="right"><input type="submit" name="send" value="Edit Movie Category" /></td></tr>
		</table>
		</form>
		<div class="clr"></div>
		<?php
		}
		else if ($k=="movie_category_del" && $_id!="")
		{
			if ($mov_cate_del = $conn->prepare("delete from categories where id=?")){
			$mov_cate_del->bind_param("s", $_id);
			$mov_cate_del->execute();
			$mov_cate_del->close();
			
			alert("Movie category deleted successfully!");
			redirect("/_admin_/movie_categories");
			}
		?>
		<?php
		}
		else if ($k=="add_movie_option" && $_id!=""){
			
			if (!empty($_POST)){
			
				if ($em_watching_type!="" &&$em_source_name!="" &&$em_lang_setting!="" &&$em_mov_code!="")
				{
					$ok=false;
					try{
						$em_mov_code=movCode_replace($em_mov_code);
						
						if ($add_movie_option = $conn->prepare("insert into options(watching_type,source_name,lang_setting,source_code,fid) values(?,?,?,?,?)")){
						$add_movie_option->bind_param("sssss", $em_watching_type, $em_source_name, $em_lang_setting, $em_mov_code, $_id);
						$add_movie_option->execute();
						$add_movie_option->close();
					}
					$ok=true;
					}
					catch(Exception $e){
						$ok=false;
					}
					
					if (!$ok){
						alert("A problem occurred while adding the movie option to the database.");
					}
					else {
						alert("Movie option added successfully!");
						redirect("/_admin_/edit_movie/".$_id);
					}
				}
				else{alert("Form has empty fields.");}
			}
		?>
			<div class="ttl"><?php echo($em_movName);?> > Add New Movie Option</div>
			<form method="post" name="addMovOptFrm">
			<table class="ilTbl">
			<tr><td>Watching Type: </td><td><input type="text" name="_em_watching_type" value="<?php echo($em_watching_type);?>" /></td></tr>
			<tr><td>Source Name: </td><td><input type="text" name="_em_source_name" value="<?php echo($em_source_name);?>" /></td></tr>
			<tr><td>Language: </td><td><input type="text" name="_em_lang_setting" value="<?php echo($em_lang_setting);?>" /></td></tr>
			<tr><td>Source Code: </td><td><textarea name="_em_mov_code"><?php echo($em_mov_code);?></textarea></td></tr>
			<tr><td colspan="2" align="right"><input type="submit" name="send" value="Add Movie Option" /></td></tr>
			</table>
			</form>
			<div class="clr"></div>
		<?php
		}
		else if ($k=="edit_movie_option" && $_id!="" && $_sid!=""){
			
			if (empty($_POST)){
				$xss=$conn->prepare("select * from options where id=?");
				$xss->bind_param("s",$_sid);
				$xss->execute();
				$ress = $xss->get_result();
				if($_xss = mysqli_fetch_assoc($ress)){
					$em_watching_type=$_xss["watching_type"];
					$em_source_name=$_xss["source_name"];
					$em_lang_setting=$_xss["lang_setting"];
					$em_mov_code=$_xss["source_code"];
					
					$em_watching_type=str_replace('"',"″",$em_watching_type);
					$em_source_name=str_replace('"',"″",$em_source_name);
					$em_lang_setting=str_replace('"',"″",$em_lang_setting);
				}
			}
			else{
				if ($em_watching_type!="" &&$em_source_name!="" &&$em_lang_setting!="" &&$em_mov_code!="")
				{
					$ok=false;
					try{
						$em_mov_code=movCode_replace($em_mov_code);
						
						if ($edit_movie_option = $conn->prepare("update options set watching_type=?,source_name=?,lang_setting=?,source_code=? where id=?")){
						$edit_movie_option->bind_param("sssss", $em_watching_type, $em_source_name, $em_lang_setting, $em_mov_code, $_sid);
						$edit_movie_option->execute();
						$edit_movie_option->close();
						}
						
						if ($xupdated = $conn->prepare("update movies set lastEditDate=? where id=?")){
						$xupdated->bind_param("ss", $dateNow, $_id);
						$xupdated->execute();
						$xupdated->close();
						}
						
						$ok=true;
					}
					catch(Exception $e){
						$ok=false;
					}
					
					if (!$ok){
						alert("There was a problem editing the movie option.");
					}
					else {
						alert("Movie option edited successfully!");
						redirect("/_admin_/edit_movie/".$_id);
					}
					
				}
				else{alert("Form has empty fields.");}
			}
		?>
			<div class="ttl"><?php echo($em_movName);?> > Edit Movie Option > <?php echo($_sid); ?></div>
			<form method="post" name="editMovOptFrm">
			<table class="ilTbl">
			<tr><td>Watching Type: </td><td><input type="text" name="_em_watching_type" value="<?php echo($em_watching_type);?>" /></td></tr>
			<tr><td>Source Name: </td><td><input type="text" name="_em_source_name" value="<?php echo($em_source_name);?>" /></td></tr>
			<tr><td>Language: </td><td><input type="text" name="_em_lang_setting" value="<?php echo($em_lang_setting);?>" /></td></tr>
			<tr><td>Source Code: </td><td><textarea name="_em_mov_code"><?php echo($em_mov_code);?></textarea></td></tr>
			<tr><td colspan="2" align="right"><input type="submit" name="send" value="Edit Movie Option" /></td></tr>
			</table>
			</form>
			<div class="clr"></div>
		<?php
		}
		else if ($k=="delete_movOption" && $_id!="" && $_sid!=""){
			
			$_em_howMany="";
			$em_howMany=$conn->prepare("select count(*) as cnt from options where fid=?");
			$em_howMany->bind_param("s",$_id);
			$em_howMany->execute();
			$em_k = $em_howMany->get_result();
			if($em_k_ = mysqli_fetch_assoc($em_k)){
				$_em_howMany=$em_k_["cnt"];
			}
			
			if ($_em_howMany>1){
				if ($delete_movOption = $conn->prepare("delete from options where id=?")){
				$delete_movOption->bind_param("s", $_sid);
				$delete_movOption->execute();
				$delete_movOption->close();
				
				alert("Movie option deleted successfully!");
				redirect("/_admin_/edit_movie/".$_id);
				}
			}
			else {
				alert("Not deleted: At least 1 movie option must be present by default.");
				redirect("/_admin_/edit_movie/".$_id);
			}
		}
		else if ($k=="del_broken_link" && $_id!=""){
			if ($del_broken_link = $conn->prepare("delete from broken_links where id=?")){
			$del_broken_link->bind_param("s", $_id);
			$del_broken_link->execute();
			$del_broken_link->close();
			}
			
			alert("Broken link deleted successfully!");
			redirect("/_admin_/broken_links");
		}
		else if ($k=="delete_cover"){
			
			$db_coverURLs[]="";
			
			$juj=$conn->prepare("select movie_cover from movies order by movie_cover");
			$juj->execute();
			$_ju=$juj->get_result();
			while($jik = mysqli_fetch_assoc($_ju)){
				$db_coverURLs[]=$jik["movie_cover"];
			}
			
			$dir = opendir("movie_cover");
			while (($file = readdir($dir)) !== false)
			{
				if(!is_dir($file)) $fl_coverURLs[]="movie_cover/".$file;
			}
			closedir($dir);
			
			$sy=0;
			for ($ixd=0;$ixd<count($fl_coverURLs);$ixd++){
				$url_index=array_search($fl_coverURLs[$ixd], $db_coverURLs);
				$_url=$fl_coverURLs[$ixd];
				if ($url_index==false && $_url!="movie_cover/imdb_temp.jpg"){
					if ($sy==0) echo("<div class=\"ttl\">The following obsolete images have been completely removed from the <u>movie_cover</u> folder.</div>");
					if (is_file($_url)) unlink($_url);
					echo("no:".($sy+1).", index:".$sy.": <a href=\"/".$_url."\" target=\"_blank\">".$_url."</a><br />");
					$sy++;
				}
			}
			
			if ($sy==0){echo("<div class=\"ttl\">Unavailable image not found, all images in folder are in use.</div><br />");}
		}
	?>
	<?php
		if ($k=="movies" || $k=="movies_one" || $k=="broken_links" || $k=="no_imdb" || $k=="last_updates" || $k=="same_name_movies"){
	?>
	<?php
	$_filter="";
	$exCol="";
	$orderByx="order by id desc";
	$pgxx="movies";
	
	if ($k=="movies_one"){
		$_filter="where (select count(*) from options where options.fid=movies.id)=1";
		$pgxx="movies_one";
	}
	if ($k=="broken_links"){
		$_filter="inner join broken_links on broken_links.fid=movies.id";
		$exCol=",broken_links.id as klid,broken_links.IP,broken_links.date,broken_links.fOptionsID,(select concat(lang_setting,' ',watching_type,' ',source_name) from options where id=broken_links.fOptionsID) as optInf,broken_links.browser";
		$orderByx="order by broken_links.id desc";
		$pgxx="broken_links";
	}
	if ($k=="no_imdb"){
		$_filter="where imdbID='tt' or imdbID=null or imdbID=''";
		$pgxx="no_imdb";
	}
	if ($k=="last_updates"){
		$orderByx="order by movies.lastEditDate desc";
		$exCol=",movies.lastEditDate";
		$pgxx="last_updates";
	}
	if ($k=="same_name_movies"){
		$_filter="where movie_name in (select movie_name from movies group by movie_name having count(movie_name) > 1)";
		$pgxx="same_name_movies";
	}
	
	$_pager=doPage("/_admin_/".$pgxx,"movies ".$_filter,"_id",$conn,50);
	$sBol=explode("~", $_pager);
	
	$lastQuery="select movies.id,movies.movie_name,movies.movie_cover,categories.cateName,movies.hit".$exCol." from movies inner join categories on movies.movie_category=categories.id ".$_filter." ".$orderByx." limit ".$sBol[0];
	
	$query=$conn->prepare($lastQuery);
	$query->execute();
	$sget=$query->get_result();
	?>
	<div class="ttl"><?php if ($k=="movies_one") echo("Movies of Single Option"); else if ($k=="broken_links") echo("Movies of Broken Link"); else if ($k=="no_imdb") echo("Movies Without IMDB ID"); else if ($k=="last_updates") echo("Movies of Recently Updated"); else if ($k=="same_name_movies") echo("Movies of Same Name"); else echo("Movies");?></div>
	<ul class="adminMenu">
		<li <?php echo($k=="movies_one"?$active:"");?>><a href="/_admin_/movies_one">Movies of Single Option</a></li>
		<li <?php echo($k=="broken_links"?$active:"");?>><a href="/_admin_/broken_links">Movies of Broken Link</a></li>
		<li <?php echo($k=="no_imdb"?$active:"");?>><a href="/_admin_/no_imdb">Movies Without IMDB ID</a></li>
		<li <?php echo($k=="last_updates"?$active:"");?>><a href="/_admin_/last_updates">Movies of Recently Updated</a></li>
		<li <?php echo($k=="same_name_movies"?$active:"");?>><a href="/_admin_/same_name_movies">Movies of the Same Name</a></li>
	</ul>
	<div class="clr"></div>
	<ul class="adminMenu a_act">
		<li><a href="/_admin_/add_movie">Add New Movie</a></li>
		<li><a href="#" onclick="var vr=prompt('Movie ID', '');if (vr!=null) window.location='/_admin_/edit_movie/'+vr; else return false;">Find Movies by ID</a></li>
		<li><a href="#" onclick="var vr=prompt('Movie ID', '');if (vr!=null) {if(confirm('This movie will be permanently deleted. Are you sure?')) window.location='/_admin_/delete_movie/'+vr;} else return false;">Delete Movie by ID</a></li>
		<li><a href="/_admin_/delete_cover" onclick="return confirm('These processes can take a few minutes and slow down the site. Are you sure you want to do it now?');">Delete Unused Cover Images</a></li>
	</ul>
	<table class="listit">
		<tr><td>ID</td><td>Movie Cover</td><td>Movie Name</td><td>Movie Category</td><td>Hit</td>
		<?php if ($k=="last_updates"){?>
		<td>Last Edit</td>
		<?php }?>
		</tr>
		<?php while($vt = mysqli_fetch_assoc($sget)) {?>
			<?php
				if ($k=="broken_links"){?>
			<tr><td colspan="6"><b>Movie of Broken Link Option</b></td></tr>
			<?php }?>
			<tr><td><?php echo($vt["id"]);?></td>
			<td><a href="<?php echo(createMovieLink($vt["id"],$conn)); ?>" target="_blank"><img src="/<?php echo($vt["movie_cover"]);?>" /></a></td>
			<td><a href="/_admin_/edit_movie/<?php echo($vt["id"]); ?>"><?php echo($vt["movie_name"]);?></a></td>
			<td><?php echo($vt["cateName"]);?></td>
			<td><?php echo($vt["hit"]);?></td>
			<?php if ($k=="last_updates"){?>
			<td><?php echo(date('d.m.Y H:i:s', strtotime($vt["lastEditDate"])));?></td>
			<?php }?>
			</tr>
			<tr><td colspan="<?php if ($k=="last_updates"){?>7<?php } else{?>6<?php }?>">
			<a href="/_admin_/edit_movie/<?php echo($vt["id"]); ?>"><div class="reBtn">Edit Movie</div></a>
			<a href="/_admin_/delete_movie/<?php echo($vt["id"]); ?>" onclick="return confirm('Are you sure you want to delete the movie? The movie will be deleted along with all movie options in it.');"><div class="reBtn">Delete Movie</div></a>
			<br /><br />
			</td></tr>
			<?php
				if ($k=="broken_links"){?>
			<tr><td colspan="6"><b>Movie Option Information</b></td></tr>
			<tr><td colspan="3">Reported Broken Option ID: <b><?php echo($vt["fOptionsID"]);?></b> Movie Option: <b><?php echo($vt["optInf"]);?></b></td>
			<td colspan="3">
			<a href="/_admin_/edit_movie_option/<?php echo($vt["id"]); ?>/<?php echo($vt["fOptionsID"]);?>"><div class="reBtn">Edit<br />Movie Option</div></a>
			<a href="/_admin_/delete_movOption/<?php echo($vt["id"]); ?>/<?php echo($vt["fOptionsID"]);?>" onclick="return confirm('Are you sure you want to delete the movie option?');"><div class="reBtn">Delete<br />Movie Option</div></a>
			</td></tr>
			<tr><td colspan="6"><b>Notifying Person Information</b></td></tr>
			<?php
				$dtx=$vt["date"];
				$_datex=convertDate($dtx);
			?>
			<tr><td colspan="6">ID: <b><?php echo($vt["klid"]);?></b>, IP: <b><?php echo($vt["IP"]);?></b>, Notification Date: <b><?php echo($_datex);?></b> <a href="/_admin_/del_broken_link/<?php echo($vt["klid"]); ?>" onclick="return confirm('Broken link will be removed permanently, are you sure?');"><div class="reBtn">Delete This Broken Link Notification!</div></a></td>
			</tr>
			<tr><td colspan="6">Browser Information: <b><?php echo($vt["browser"]);?></b></td></tr>
			<tr><td colspan="6"><br /><br /></td></tr>
			<?php }?>
		<?php } ?>
		<?php if($sget->num_rows <= 0){?><tr><td colspan="6">Movie not found.</td></tr><?php }?>
	</table>
	<div class="page_"><?php echo($sBol[1]);?></div>
	<div class="clr"></div>
	<?php } else if ($k=="movie_categories"){ ?>
	<?php $query=$conn->query("select * from categories order by id desc");?>
	<div class="ttl">Movie Categories</div>
	<ul class="adminMenu">
	<li><a href="/_admin_/add_movCate">Add New Movie Category</a></li>
	</ul>
	<table class="listit">
		<tr><td>id</td><td>Category Name</td><td></td></tr>
		<?php
			while($vt = $query->fetch_assoc()) {?>
			<tr><td><?php echo($vt["id"]);?></td>
			<td><?php echo($vt["cateName"]);?></td>
			<td>
			<a href="/_admin_/edit_movCate/<?php echo($vt["id"]); ?>"><div class="reBtn">Edit</div></a>
			<a href="/_admin_/movie_category_del/<?php echo($vt["id"]); ?>" onclick="return confirm('Are you sure you want to delete the movie category?');"><div class="reBtn">Delete</div></a>
			<br /><br />
			</td>
			</tr>
		<?php }?>
	</table>
	<?php }?>
	<div class="clr"></div>
</div>
<?php } } } }?>