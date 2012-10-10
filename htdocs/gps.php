<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&hl=ja"></script>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

<script type="text/javascript">
var lat=0;
var lng=0;
	
	navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
	
	function successCallback(position){
		//phpに値送信
		window.location.href="map.php?lat="+position.coords.latitude+"&lon="+position.coords.longitude;
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
	      //document.getElementById("show_result").innerHTML = err_msg;
	      //デバッグ用→　document.getElementById("show_result").innerHTML = error.message;
	}
</script>
