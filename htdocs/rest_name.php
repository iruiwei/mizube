<?php
session_start();
require('dbconnect.php');
$empty=0;
if(isset($_POST['tlat'])&&isset($_POST['lon'])){
	echo "aaa";
	echo $_POST['tlat'].'<br>';
	echo $_POST['tlon'];
}
if(!isset($_POST['tlat'])&&!isset($_POST['lon'])){
	echo "Nooooo";
}
if(!isset($_POST['name'])){
	header('location:rest_search.php');
	exit();
}
else{
	$rName=$_POST['name'];
	if ($rName!=''){
		$sql0=sprintf('select count(*) as cnt from mb_restaurant where name like "%s"',"%".mysql_real_escape_string($rName)."%");
		$record0=mysql_query($sql0)or die(mysql_error());
 		$table0=mysql_fetch_assoc($record0);
 		if($table0['cnt']==0){
			echo '見つかりません!';
			$empty=1;
		}
		else{
			//echo $table0['cnt'] ." results";
			//echo '<br />';
			
			$sql2=sprintf('select * from mb_restaurant where name like "%s"',"%".mysql_real_escape_string($rName)."%");
			$recordset=mysql_query($sql2)or die(mysql_error());
			//$data=mysql_fetch_assoc($recordset);
		}
	}
	else{
		echo "見つかりません";
		$empty=1;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
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
    //kml読み込み部分

    <?php
	  	$sql1=sprintf('select mb_area.lon,mb_area.lat from mb_area where id = "%d"',mysql_real_escape_string($area));
		$recordset1=mysql_query($sql1)or die(mysql_error()); 
		$areaLat=34.690632;
		$areaLon= 135.516083;
			while($data1=mysql_fetch_assoc($recordset1)){
				$areaLat = $data1['lat']; 
				$areaLon = $data1['lon'];
				}
	?>

    var initPos = new google.maps.LatLng(<?php echo $areaLat ?>, <?php echo $areaLon ?>); 
    var myOptions = {
    	noClear : true,
    	center : initPos,
    	zoom : 15,
    	mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    var map_canvas = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
     
    var kmlOptions = {
          preserveViewport: true
        }
     var kmlUrl = "https://maps.google.com/maps/ms?ie=UTF8&authuser=0&msa=0&output=kml&msid=214267887168441249308.0004c7e4364594a9c6c1e";
    var kmlLayer = new google.maps.KmlLayer(kmlUrl,kmlOptions);
    kmlLayer.setMap(map_canvas); 


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
		<div id= "page_top">
		<a href="./"><img src= "img/logo.png" style="width:100%"></a>
		<img src= "img/line.png" style="width:100%">
		</div>
	</header>
	</header>
	<div id="rest_area">

	 <div id="info_top">エリア情報<?php $_POST['tlat'];?></div>
	  <div id="map_canvas" style="width:100%; height:200px;"></div>

<div id="info">レストラン情報</div>

	<?php
	if($empty==0){
	while($data=mysql_fetch_assoc($recordset)){
		?>
		
		<a href= "rest_info.php?rid=<?php echo $data['rid']?>"><div class= "restaurant">
			<div class="rest_title"><?php echo $data['name']?>	
			</div>
			<div class= "rest_left">
			<img src="<?php echo $data['photo']?>" class= "image_style" >
			</div>
			<div class="rest_right">
			バルメニュー：<?php echo $data['menu']?><br>
			<?php echo $data['introduction']?>

			</div>
			<div class= "rest_arrow">
			</div>
		</div>
		</a>
		
		<?php
	}
}
	
	?>

	</div>

	 <div class="twitter">
	 <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
version: 2,
type: 'search',
search: '#mizubebar',
interval: 20000,
title: '',
subject: '天満橋エリア',
width: 'auto',
height: 400,
theme: {
shell: {
background: '#ffffff33',
color: '#8a8a8a'
},
tweets: {
background: '#ffffff99',
color: '#444444',
links: '#1985b5'
}
},
features: {
scrollbar: false,
loop: true,
live: true,
behavior: 'default'
}
}).render().start();
</script>

</div>



	<footer>
	</footer>	
</body>
</html>
