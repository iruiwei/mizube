<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>gpsTest</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&hl=ja"></script>
	<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
	<!-- Date: 2012-10-07 -->
	
	<script type="text/javascript">
	var lat=0;
	var lng=0;
	
	function initialize(){
		
		navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
		
		function successCallback(position){
			var gl_text = "緯度：" + position.coords.latitude + "<br>";
			gl_text += "経度：" + position.coords.longitude + "<br>";
			document.getElementById("show_result").innerHTML = gl_text;

			//phpに値送信
			lat = position.coords.latitude;
			lng = position.coords.longitude;
			
			document.write(lat);
			document.write('/n');
			document.write(lng);
			

			$(function(){
				$('#sw').click(
					function(){
						$.post("test_post.php",  // リクエストURL
							   {"key1": lat, "key2": lng}, // データ	//ここに緯度経度
								"html" // 応答データ形式
						);
					}
				);
			}
			);
		}
		
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
	<!--<div id="show_result"></div>-->
	<br>
	
	<a href="javascript: void(0)" id="sw">switch</a><br/>
	<br>
	

</body>
</html>
