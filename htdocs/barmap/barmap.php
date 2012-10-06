<?php
	require('../../dbconnect.php');
?>
<html>
<head>
<meta charset=shift_jis>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&hl=ja"></script>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">
	var lat=0;
	var lng=0;
  function initialize() {
    var initPos = new google.maps.LatLng(34.682177, 135.497303);
    var myOptions = {
      noClear : true,
      center : initPos,
      zoom : 13,
      mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    var map_canvas = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
     
    
    //kml読み込み部分
    
    //var kmlUrl = "http://192.168.11.25/barMap.kml";
    //var kmlUrl = "http://googlemaps.googlermania.com/uploads/kmlsample3.kml";
    //var kmlLayer = new google.maps.KmlLayer(kmlUrl);
    //kmlLayer.setMap(map_canvas);
    

    //ユーザの位置情報取得
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    //位置情報取得成功時
　　function successCallback(position){
    　var gl_text = "緯度：" + position.coords.latitude + "<br>";
　　　gl_text += "経度：" + position.coords.longitude + "<br>";
　　　document.getElementById("show_result").innerHTML = gl_text;

      //phpに値送信
　　　lat = position.coords.latitude;
      	 lng = position.coords.longitude;
　　　$(function(){
  $('#sw').click(
   function(){
    $.post(
     "test_post.php",                      // リクエストURL
     {"key1": lat, "key2": lng}, // データ	//ここに緯度経度
     function(data, status) {
      // 通信成功時にデータを表示
      $("#test_result")
      .append("status:").append(status).append("<br/>")
      .append("data:").append(data).append("<br/>");
     },
     "html"                                 // 応答データ形式
    );
   }
  );
 });

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
      var To = new google.maps.LatLng(34.702643,135.497131);	//目的地
　　　new google.maps.DirectionsService().route({
       origin: From,
       destination: To,
       travelMode: google.maps.DirectionsTravelMode.WALKING
      }, function(result, status){
       if (status == google.maps.DirectionsStatus.OK){
        new google.maps.DirectionsRenderer({map: map_canvas}).setDirections(result);
        SetDistance(result);
	var duration = result.routes[0].legs[0].duration.text; /*更新箇所*/
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
        
      //phpに値受け渡し
　　　

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

  }

</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:100%; height:70%"></div>
　<div id="show_result"></div>
  
  
  <a href="javascript: void(0)" id="sw">switch</a><br />
  <div id = "test_result"></div>
  <br>
</body>

</html>