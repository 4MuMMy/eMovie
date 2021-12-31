<?php
session_start();

if ($_SERVER["REQUEST_URI"]=="/ajax.php"){header("Location:/");die();}
else{
include("settings.php");

$_state = (isset($_GET['d']) ? $_GET['d'] : null);
$_f_id = (isset($_GET['p']) ? $_GET['p'] : null);
$ajxID = (isset($_GET['ajx']) ? $_GET['ajx'] : null);
$_em_id="";
$ret=0;

if (strpos($_f_id, "_")!==false){
	$bx=explode("_", $_f_id);
	$_f_id=$bx[0];
	$_em_id=$bx[1];
	
	if (!is_numeric($_em_id)) {header("Location:/");die();}
}

if (!is_numeric($_f_id)) {header("Location:/");die();}

if ($_SESSION["ajaxControl"]!=$ajxID) {echo("redirect.".$_state);die();}

if ($_state=="watched"){
	if (isset($_COOKIE['watchedMovies'])) {
		foreach ($_COOKIE['watchedMovies'] as $name => $value) {
			$xa=str_replace("]","",str_replace("watchedMovies[","",$name));
			if ($xa==$_f_id){
				$ret=1;
				break;
			}
		}
	}
	
	if ($ret==0){
		$movieName="";
		$xssz=$conn->prepare("select movie_name from movies where id=?");
		$xssz->bind_param("s",$_f_id);
		$xssz->execute();
		$ressz = $xssz->get_result();
		if($_xssz = mysqli_fetch_assoc($ressz)){
			$movieName=$_xssz["movie_name"];
		}
		$xssz->close();
		setcookie("watchedMovies[".$_f_id."]", $movieName."/".date("d.m.Y H:i:s"), time()+(2592000*60),"/");//5 years
	}
	
	if ($ret==0) echo("The movie has been added to your watch history.");
	else echo("This movie is already in your watch history.");
}
else if ($_state=="watchLater"){
	if (isset($_COOKIE['moviesToWatch'])) {
		foreach ($_COOKIE['moviesToWatch'] as $name => $value) {
			$xa=str_replace("]","",str_replace("moviesToWatch[","",$name));
			if ($xa==$_f_id){
				$ret=1;
				break;
			}
		}
	}
	
	if ($ret==0){
		$movieName="";
		$xssz=$conn->prepare("select movie_name from movies where id=?");
		$xssz->bind_param("s",$_f_id);
		$xssz->execute();
		$ressz = $xssz->get_result();
		if($_xssz = mysqli_fetch_assoc($ressz)){
			$movieName=$_xssz["movie_name"];
		}
		$xssz->close();
		setcookie("moviesToWatch[".$_f_id."]", $movieName."/".date("d.m.Y H:i:s"), time()+(2592000*60),"/");//5 years
	}
	
	if ($ret==0) echo("The movie has been added to your watch list.");
	else echo("This movie is already in your watch list.");
}
else if ($_state=="star_1" || $_state=="star_2" || $_state=="star_3" || $_state=="star_4" || $_state=="star_5"){
	if (isset($_COOKIE['stars'])) {
		foreach ($_COOKIE['stars'] as $name => $value) {
			$xa=str_replace("]","",str_replace("stars[","",$name));
			if ($xa==$_f_id){
				$ret=1;
				break;
			}
		}
	}
	
	if ($_SESSION["ajaxControl_temp"]!=null) $ret=1;
	
	if ($ret==0){
		$realID="";
		$xssz=$conn->prepare("select id from movies where id=?");
		$xssz->bind_param("s",$_f_id);
		$xssz->execute();
		$ressz = $xssz->get_result();
		if($_xssz = mysqli_fetch_assoc($ressz)){
			$realID=$_xssz["id"];
		}
		$xssz->close();
		
		$star=explode('_',$_state)[1];
		
		if ($addVote = $conn->prepare("insert into scores(fid,star_score) values(?,?)")){
			$addVote->bind_param("ss", $realID, $star);
			$addVote->execute();
			$addVote->close();
		}
		
		$pointRatio=round(oneReg("avg(star_score)","scores where fid=".$realID,$conn),1);
		$totalVotes=oneReg("count(*)","scores where fid=".$realID,$conn);
		
		echo($pointRatio."^");
		echo($totalVotes."^");
		
		setcookie("stars[".$_f_id."]", $star."/".date("d.m.Y H:i:s"), time()+(2592000*60),"/");//5 years
		
		$_SESSION["ajaxControl_temp"]=$_SESSION["ajaxControl"];
		//with the temp session, we prevent re-voting by deleting the cookie.
	}
	
	if ($ret==0) echo("Your star rating has been given for this movie.");
	else echo("You've already given your star rating for this movie.");
}
else if ($_state=="broken"){
	$realEM="";
	
	$xssz=$conn->prepare("select fOptionsID from broken_links where fOptionsID=?");
	$xssz->bind_param("s",$_em_id);
	$xssz->execute();
	$ressz = $xssz->get_result();
	if($_xssz = mysqli_fetch_assoc($ressz)){
		$realEM=$_xssz["fOptionsID"];
	}
	$xssz->close();
	
	//if this movie has already been reported, we don't add it again
	if ($realEM==""){
		$datex=date("Y-m-d H:i:s");
		$IP=get_client_ip();
		$browserx=$_SERVER['HTTP_USER_AGENT'];
		
		if ($movieBroken = $conn->prepare("insert into broken_links(fid,fOptionsID,date,IP,browser) values(?,?,?,?,?)")){
			$movieBroken->bind_param("sssss", $_f_id, $_em_id, $datex, $IP,$browserx);
			$movieBroken->execute();
			$movieBroken->close();
		}
	
		setcookie("brokenLinks[".$_f_id."]", date("d.m.Y H:i:s"), time()+(2592000*60),"/");//5 years
		echo("Thanks, your broken link notification received. The movie will be edited as soon as possible.");
	}
	else echo("Thanks for your report, but it has already been reported that there is a broken link in this movie.<skipLine>The movie will be edited as soon as possible.");
}

$conn->close();
}
?>