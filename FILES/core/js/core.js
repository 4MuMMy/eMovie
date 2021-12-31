$(function(){
	$( ".movieSettCho" ).selectmenu({width:325});

	$("#lightOff").click(function(){
		if (!$("#lightsOff_").is(":visible")){
		$(".player_AndSett .player_").css({"z-index":"9999999","position":"relative"});
		$(".player_AndSett .player_ iframe").css({"border":"10px dashed #444","margin-left":"-10px","margin-top":"-10px","margin-bottom":"-10px"});
		$("#lightsOff_").fadeIn();
		}
		else{
		$("#lightsOff_").fadeOut("slow",function() {
			$("#lightsOff_").hide();
			$(".player_").css({"z-index":"1"});
		});
		}
	});

	$("#lightsOff_").click(function(){
		$("#lightsOff_").fadeOut("slow",function() {
			$("#lightsOff_").hide();
			$(".player_AndSett .player_").css({"z-index":"1"});
			$(".player_AndSett .player_ iframe").css({"border":"","margin-left":"","margin-top":"","margin-bottom":"0px"});
		});
		
	});

	$nmb=0;$nmb2=0;$nmb3=0;$nmb4=0;

	$("#brightness").click(function(){
		$nmb++;
		multipSett();
	});

	$("#contrast").click(function(){
		$nmb2++;
		multipSett();
	});

	$("#saturation").click(function(){
		$nmb3++;
		multipSett();
	});

	$("#grayscale").click(function(){
		$nmb4++;
		multipSett();
	});

	function multipSett(){
		$n="100";$ne="100";$nee="100";$neee="0";
		$ni="0";$nei="0";$neei="0";$neeei="0";
		
		if ($nmb==1){
			$n="110";$ni="2";
		}
		else if ($nmb==2){
			$n="125";$ni="4";
		}
		else if ($nmb==3){
			$n="150";$ni="6";
		}
		else if ($nmb==4){
			$n="200";$ni="8";
		}
		
		if ($nmb2==1){
			$ne="110";$nei="2";
		}
		else if ($nmb2==2){
			$ne="125";$nei="4";
		}
		else if ($nmb2==3){
			$ne="150";$nei="6";
		}
		else if ($nmb2==4){
			$ne="200";$nei="8";
		}
		
		if ($nmb3==1){
			$nee="200";$neei="2";
		}
		else if ($nmb3==2){
			$nee="300";$neei="4";
		}
		else if ($nmb3==3){
			$nee="400";$neei="6";
		}
		else if ($nmb3==4){
			$nee="500";$neei="8";
		}
		
		if ($nmb4==1){
			$neee="25";$neeei="2";
		}
		else if ($nmb4==2){
			$neee="50";$neeei="4";
		}
		else if ($nmb4==3){
			$neee="75";$neeei="6";
		}
		else if ($nmb4==4){
			$neee="100";$neeei="8";
		}
		
		if ($nmb>4) $nmb=0;
		if ($nmb2>4) $nmb2=0;
		if ($nmb3>4) $nmb3=0;
		if ($nmb4>4) $nmb4=0;
		
		$("#brightness").text("Brightness x"+$ni);
		$("#contrast").text("Contrast x"+$nei);
		$("#saturation").text("Saturation x"+$neei);
		$("#grayscale").text("Grayscale x"+$neeei);
		$(".player_").css({"-webkit-filter":"brightness("+$n+"%) contrast("+$ne+"%) saturate("+$nee+"%) grayscale("+$neee+"%)","filter":"brightness("+$n+"%) contrast("+$ne+"%) saturate("+$nee+"%) grayscale("+$neee+"%)"});
	};

	$("#others").click(function(){
		if ($("#others").text()=="Show Color Settings"){
			$("#brightness").css({"clear":"both"});
			$("#brightness").show();
			$("#contrast").show();
			$("#saturation").show();
			$("#grayscale").show();
			$("#others").text("Hide Color Settings");
		}
		else{
			$("#brightness").css({"float":"right","clear":""});
			$("#brightness").hide();
			$("#contrast").hide();
			$("#saturation").hide();
			$("#grayscale").hide();
			$("#others").text("Show Color Settings");
		}
		
	});
		
	$ksy=0;
	$("#fullscreen").click(function(){
		$ksy++;
		if ($ksy==1){
			$(".player_AndSett .movieSLg").css({"margin":"3px 10px"});
			$(".player_AndSett").css({"width":"100%","height":"100%","position":"fixed","left":"0","top":"0","background":"#444","z-index":"9999999"});
			$(".player_AndSett .player_").css({"width":"100%","height":"92%","margin-bottom":"10px","background":"#ccc"});
			$(".player_AndSett .source").css({"width":"100%","height":"100%"});
			$(".player_AndSett #fullscreen").css({"margin-right":"10px"});
			$(".player_AndSett .player_ iframe").css({"width":"100%","height":"100%"});
			$("#lightOff").hide();
			$("#brokenLink").hide();
			$("#others").hide();
			$("#others").text("Show Color Settings");
			$("#brightness").css({"float":"right","clear":""});
			$("#brightness").show();
			$("#contrast").show();
			$("#saturation").show();
			$("#grayscale").show();
			$("#fullscreen").text("Exit FullScreen");
			if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
				if (document.body.requestFullScreen) {
					document.body.requestFullScreen();
				} else if (document.body.mozRequestFullScreen) {
					document.body.mozRequestFullScreen();
				} else if (document.body.webkitRequestFullScreen) {
					document.body.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
				} else if (document.body.msRequestFullscreen) {
					document.body.msRequestFullscreen();
				}
			}
		}
		else {
			$(".player_AndSett .movieSLg").css({"margin":"3px 0px"});
			$(".player_AndSett").css({"width":"","height":"","position":"","left":"","top":"","background":"","z-index":""});
			$(".player_AndSett .player_").css({"width":"","height":"","margin-bottom":"","background":""});
			$(".player_AndSett .source").css({"width":"","height":""});
			$(".player_AndSett #fullscreen").css({"margin-right":""});
			$(".player_AndSett .player_ iframe").css({"width":"","height":""});
			$("#lightOff").show();
			$("#brokenLink").show();
			$("#others").show();
			if ($nmb!=0 || $nmb2!=0 || $nmb3!=0 || $nmb4!=0){
				$("#brightness").css({"clear":"both"});
				$("#others").text("Hide Color Settings");
			}
			else{
				$("#brightness").hide();
				$("#contrast").hide();
				$("#saturation").hide();
				$("#grayscale").hide();
			}
			$("#fullscreen").text("FullScreen");
			if (document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			} else if (document.mozCancelFullscreen) {
				document.mozCancelFullscreen();
			} else if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.exitFullscreen) {
				document.exitFullscreen();
			}
			$ksy=0;
		}
	});
	
	$(".player_AndSett .player_").mouseleave(function(){
		$(".player_AndSett .player_").css({"height":"92%"});
	});
	
	$(".player_AndSett .player_").mouseenter(function(){
		$(".player_AndSett .player_").css({"height":"99.8%"});
	});
	
	$(document).keyup(function(e) {
		 if (e.keyCode == 27) {
			if ($ksy==1){
				$("#fullscreen").click();
			}
		}
	});

	jQuery.event.add(window, "resize", FullscrenONOFF);

	function FullscrenONOFF()
	{
		var checkFullscreen = ((typeof document.webkitIsFullScreen) !== 'undefined') ? document.webkitIsFullScreen : document.mozFullScreen;
		if (!checkFullscreen) {
			if ($ksy==1){
				$("#fullscreen").click();
			}
		}
	}
	
	$(".searchBx").keydown(function(e) {
	if (e.keyCode == 13) {
		$aaa=$('.searchBx').val();
		if ($aaa.length>2){
		  window.location="/movie-search/"+$aaa;
		}
	}
	});
	
	$(".button").click(function(){
		
		if (!$("#cssmenu ul").is(":visible")){
			$("#cssmenu ul").show();
		}
		else{
			$("#cssmenu ul").hide();
		}
		
	});
	

	$yClass="starActive";
	
	$("#star1").hover(function(){
		clearStar();
		$("#star1").addClass($yClass);
	},
	function(){
		defaultStar();
	});
	
	$("#star2").hover(function(){
		clearStar();
		$("#star1").addClass($yClass);
		$("#star2").addClass($yClass);
	},
	function(){
		defaultStar();
	});
	
	$("#star3").hover(function(){
		clearStar();
		$("#star1").addClass($yClass);
		$("#star2").addClass($yClass);
		$("#star3").addClass($yClass);
	},
	function(){
		defaultStar();
	});
	
	$("#star4").hover(function(){
		clearStar();
		$("#star1").addClass($yClass);
		$("#star2").addClass($yClass);
		$("#star3").addClass($yClass);
		$("#star4").addClass($yClass);
	},
	function(){
		defaultStar();
	});
	
	$("#star5").hover(function(){
		clearStar();
		$("#star1").addClass($yClass);
		$("#star2").addClass($yClass);
		$("#star3").addClass($yClass);
		$("#star4").addClass($yClass);
		$("#star5").addClass($yClass);
	},
	function(){
		defaultStar();
	});
	
	
	function clearStar(){
		$("#star1").removeClass($yClass);
		$("#star2").removeClass($yClass);
		$("#star3").removeClass($yClass);
		$("#star4").removeClass($yClass);
		$("#star5").removeClass($yClass);
	}
	
	function defaultStar(){
		
		clearStar();
		
		$yl=Math.round($("#grdRate").text().split("/")[0]);
		
		if ($yl==1) {
			$("#star1").addClass($yClass);
		}
		else if ($yl==2) {
			$("#star1").addClass($yClass);
			$("#star2").addClass($yClass);
		}
		else if ($yl==3) {
			$("#star1").addClass($yClass);
			$("#star2").addClass($yClass);
			$("#star3").addClass($yClass);
		}
		else if ($yl==4) {
			$("#star1").addClass($yClass);
			$("#star2").addClass($yClass);
			$("#star3").addClass($yClass);
			$("#star4").addClass($yClass);
		}
		else if ($yl==5) {
			$("#star1").addClass($yClass);
			$("#star2").addClass($yClass);
			$("#star3").addClass($yClass);
			$("#star4").addClass($yClass);
			$("#star5").addClass($yClass);
		}
	}
	
	defaultStar();
	
	$('#grdRate').bind('DOMNodeInserted DOMNodeRemoved', function() {
		defaultStar();
	});
	
	$otoOkIncr=0;
	$(".searchBx").keyup(function(e) {
		if (e.keyCode==13){//enter
			$(".tmXfc").mousedown();
		}
		else if(e.keyCode==40){//down
			if ($otoOkIncr==$(".autoComplete").children().length) $otoOkIncr=0;
			$otoOkIncr++;
			$(".autoComplete div:nth-child("+$(".autoComplete").children().length+")").removeClass("tmXfc");
			$(".autoComplete div:nth-child("+($otoOkIncr-1)+")").removeClass("tmXfc");
			$(".autoComplete div:nth-child("+$otoOkIncr+")").addClass("tmXfc");
		}
		else if(e.keyCode==38){//up
			if ($otoOkIncr==1) $otoOkIncr=$(".autoComplete").children().length+1;
			$otoOkIncr--;
			$(".autoComplete div:nth-child(1)").removeClass("tmXfc");
			$(".autoComplete div:nth-child("+($otoOkIncr+1)+")").removeClass("tmXfc");
			$(".autoComplete div:nth-child("+$otoOkIncr+")").addClass("tmXfc");
		}
		else{
			if ($(".searchBx").val().length>=$(".minLg").val()){
				if (window.XMLHttpRequest) {
					xmlhttpx = new XMLHttpRequest();
				} else {
					xmlhttpx = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttpx.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200 && this.responseText.indexOf("Maximum execution time of")==-1) {
						$(".autoComplete").html("<div onmousedown=\"$('.searchBx').val($(this).text());window.location='/movie-search/'+$(this).text();\">"+$(".searchBx").val()+"</div>"+this.responseText);
						$(".autoComplete").show();
						$otoOkIncr=0;
					}
				};
				xmlhttpx.open("GET","/autoComplete?sr="+$(".searchBx").val(),true);
				xmlhttpx.send();
			}
			else{
				$(".autoComplete").html("");
				$(".autoComplete").hide();
			}
		}
	});

	$(".searchBx").blur(function() {
		$(".autoComplete").hide();
	});

	$(document).on("mouseover", ".autoComplete div", function(event) {
		$(".autoComplete").children("div").each(function () {
			$(this).removeClass("tmXfc");
		});
		$otoOkIncr=($(this).index()+1);
		$(this).addClass("tmXfc");
	});

	
});


$(window).load(function(){
	$("#content-slider").lightSlider({
		auto:true,
		loop:true,
		keyPress:true,
		easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
		speed:1000,
		pause:4000,
		autoWidth:true,
		pauseOnHover: true,
		pager:false
	});

	$("#content-slider").css({"display":"block"});
	$(".loadingz").hide();
	$(".paint").css({"background-image":"none"});
	
});

function buttonsWhatDo(wha){
	var clNm="deactButt";
	if (wha=="wait"){
		$("#star1").addClass(clNm);
		$("#star2").addClass(clNm);
		$("#star3").addClass(clNm);
		$("#star4").addClass(clNm);
		$("#star5").addClass(clNm);
		$("#fullscreen").addClass(clNm);
		$("#lightOff").addClass(clNm);
		$("#brightness").addClass(clNm);
		$("#contrast").addClass(clNm);
		$("#saturation").addClass(clNm);
		$("#grayscale").addClass(clNm);
		$("#brokenLink").addClass(clNm);
		$("._watchLater").addClass(clNm);
		$("._watched").addClass(clNm);
		$("html").css({"pointer-events":"none","opacity":"0.4"});
	}
	else{
		$("#star1").removeClass(clNm);
		$("#star2").removeClass(clNm);
		$("#star3").removeClass(clNm);
		$("#star4").removeClass(clNm);
		$("#star5").removeClass(clNm);
		$("#fullscreen").removeClass(clNm);
		$("#lightOff").removeClass(clNm);
		$("#brightness").removeClass(clNm);
		$("#contrast").removeClass(clNm);
		$("#saturation").removeClass(clNm);
		$("#grayscale").removeClass(clNm);
		$("#brokenLink").removeClass(clNm);
		$("._watchLater").removeClass(clNm);
		$("._watched").removeClass(clNm);
		$("html").css({"pointer-events":"","opacity":""});
	}
}