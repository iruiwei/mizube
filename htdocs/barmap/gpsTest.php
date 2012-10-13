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
	
</head>
<body>
	<!--<div id="show_result"></div>-->
	<form method="post" action="test_post.php">
	
	
	
	<script>
	//gps
	navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

	function successCallback(position){
		//phpに値送信
		//window.location.href="map.php?lat="+position.coords.latitude+"&lon="+position.coords.longitude;
		
		var lat = position.coords.latitude;
		var lon= position.coords.longitude;
		var tlat = document.getElementById("tlat");
		var tlon = document.getElementById("tlon");
		tlat.value = position.coords.latitude;
		tlon.value = position.coords.longitude;
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
	}
	</script>
	
	<input type="hidden" name="tlat" >
	<input type="hidden" name="tlon" >
	<input type="submit" value="ok">
	
	</form>
	
	

</body>
</html>
