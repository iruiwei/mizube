<?php
session_start();

if(empty($_REQUEST['rid'])){
  $rid=1;
}
else
  $rid=$_REQUEST['rid'];

require('dbconnect.php');
?>

<html xmlns="http://www.w3.org/1999/xhml">
<head>
	<meta charset="utf-8" />
	<title>水辺バル</title>
	<meta name="description" content="水辺バル" />
	<meta name="keywords" content="水辺バル" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<link rel="stylesheet" href="style.css">
	<style></style>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&hl=ja"></script>
	<script type="text/javascript">
	var lat=0;
	var lng=0;
  	function initialize() {
    var initPos = new google.maps.LatLng(34.682177, 135.497303); //->場所によって変える
    var myOptions = {
    	noClear : true,
    	center : initPos,
    	zoom : 14,
    	mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    var map_canvas = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
     
    
    //kml読み込み部分
    
   // var kmlUrl = "https://maps.google.com/maps/ms?ie=UTF8&authuser=0&msa=0&output=kml&msid=214267887168441249308.0004c7e4364594a9c6c1e";
  //  var kmlLayer = new google.maps.KmlLayer(kmlUrl);
  //  kmlLayer.setMap(map_canvas);
    

    //ユーザの位置情報取得
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    //位置情報取得成功時
　//　	function successCallback(position){
    　// 	var gl_text = "緯度：" + position.coords.latitude + "<br>";
　　　// 	gl_text += "経度：" + position.coords.longitude + "<br>";
　　　//		document.getElementById("show_result").innerHTML = gl_text;

      	//phpに値送信
　　　		lat = position.coords.latitude;
    	lng = position.coords.longitude;
      	       	 

		

         //現在位置マーカーの生成
      var nowlatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
　　　var marker = new google.maps.Marker({
       position: nowlatlng,
       map: map_canvas,
       title: "CurrentPosition"
      });
      //情報ウィンドウの追加
　　　var info = new google.maps.InfoWindow({content: '<p>You are here!</p>'});
      //クリックしたら情報提示
　　　google.maps.event.addListener(marker, 'click', function(){
       info.open(map_canvas, marker);
      });
      
      //ルート表示
      var From = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);	//現在地
      var To = new google.maps.LatLng(<?= htmlspecialchars($_POST['key1'], ENT_QUOTES, 'UTF-8'); ?>34.702643,135.497131);	//目的地
　　　new google.maps.DirectionsService().route({
       origin: From,
       destination: To,
       travelMode: google.maps.DirectionsTravelMode.WALKING
      }, function(result, status){
       if (status == google.maps.DirectionsStatus.OK){
        new google.maps.DirectionsRenderer({map: map_canvas}).setDirections(result);
        SetDistance(result);
	var duration = result.routes[0].legs[0].duration.text; //更新箇所
	gl_text += "所要時間：" + duration + "<br>"; 	//
	document.getElementById("show_result").innerHTML = gl_text;
       }
      });

      //移動距離計算
      function SetDistance(routeData)
      {
	　　　var distance = GetDistanceKm(routeData.routes[0].legs); 
	      if (distance > 100) 
	      { 
	       distance = distance.toFixed(0); 
	      } 
	      else if (distance > 10) 
	      { 
	       distance = distance.toFixed(1); 
	      } 
	      gl_text += "移動距離："+ distance + "km" +"<br>";
	      document.getElementById("show_result").innerHTML = gl_text;
	      }
      function GetDistanceKm(legs)
      {
       var journey = 0;
       for(var i in legs)
       {
         journey += legs[i].distance.value;
       }
       return journey / 1000;
      }
　　　

    }

　　//位置情報取得ができない場合
　　function errorCallback(error) {
     var err_msg = "";
     switch(error.code){
      case 1:
       err_msg = "位置情報の利用が許可されていません";
       break;
      case 2:
       err_msg = "デバイスの位置が判定できません";
       break;
      case 3:
       err_msg = "タイムアウトしました";
       break;
     }
      document.getElementById("show_result").innerHTML = err_msg;
      //デバッグ用→　document.getElementById("show_result").innerHTML = error.message;
    }

  

</script>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35428958-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body onload="initialize()">
	<header>
		<a href="./"><img src= "img/logo.png" style="width:100%"></a>
		<img src= "img/line.png" style="width:100%">
	
	</header>


	<div class="rest_title">カツカレーの店</div>

  <div id="map_canvas" style="width:100%; height:500px;margin:10px 0;"></div>
  <div class="rest_route">
  </div>  
	<div class="rest_menu">
	エリア：<a href="" >天満橋エリア </a>
	</div>

	<div class="rest_menu">
	<a href= "ship.html">舟の情報をみる</a>
	</div>	


	<footer>
	</footer>	
</body>


