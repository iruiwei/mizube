<?php
session_start();
require('dbconnect.php');

if(isset($_POST['id'])){
	$rid=$_POST['id'];
}
else if(isset($_REQUEST['rid'])){
	$rid=$_REQUEST['rid'];
}
else{
	header('location:rest_search.php');
	exit();
}
  $empty = 0;
	//$rid=$_POST['id'];
	$sql0=sprintf('select count(*) as cnt from mb_restaurant where rid="%d"',mysql_real_escape_string($rid));
	$record0=mysql_query($sql0)or die(mysql_error());
	$table0=mysql_fetch_assoc($record0);
	if($table0['cnt']==0){
		echo '見つかりません!';
    $empty=1;
	}
	else{
		$sql1=sprintf('select mb_area.name as aname, mb_restaurant.lon as rlon,mb_restaurant.lat as rlat,mb_restaurant.name as rname,view,uniqueuser,area_id,menu,opentime,closetime,opentime2,closetime2,photo,phone,introduction from mb_restaurant,mb_area where rid="%d" and area_id=id',mysql_real_escape_string($rid));
		$record1=mysql_query($sql1)or die(mysql_error());
		$data=mysql_fetch_assoc($record1);
		
		$sql2=sprintf('select comText from mb_comments where rid="%d"',mysql_real_escape_string($rid));
		$record2=mysql_query($sql2)or die(mysql_error());
		
		
	}


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
    var initPos = new google.maps.LatLng(<?php echo $data['rlat']?>, <?php echo $data['rlon']?>); 

      <?php
      $sql1=sprintf('select name,lat,lon from mb_restaurant where rid = "%d"',mysql_real_escape_string($rid));
    $recordset1=mysql_query($sql1)or die(mysql_error()); 
    $areaLat=34.690632;
    $areaLon= 135.516083;
    $restName = "";
      while($data1=mysql_fetch_assoc($recordset1)){
        $areaLat = $data1['lat']; 
        $areaLon = $data1['lon'];
        $restName =$data1['name'];
        }
  ?>

    var initPos = new google.maps.LatLng(<?php echo $areaLat ?>, <?php echo $areaLon ?>); 
    var myOptions = {
    	noClear : true,
    	center : initPos,
    	zoom : 17,
    	mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    var map_canvas = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
     
		

         //店マーカーの生成
      var nowlatlng = new google.maps.LatLng(<?php echo $areaLat ?>, <?php echo $areaLon ?>);
　　　var marker = new google.maps.Marker({
       position: nowlatlng,
       map: map_canvas
      });
      //情報ウィンドウの追加
　　　var info = new google.maps.InfoWindow({content: '<p><? echo $restName ?></p>'});
      //クリックしたら情報提示
　　　google.maps.event.addListener(marker, 'click', function(){
       info.open(map_canvas, marker);
      });
      
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


	<div class="rest_title"><?php echo $data['rname']?></div>
	  <img src="<?php echo $data['photo']?>" style= "width:100%;" >
	<div class="rest_menu">
	バルメニュー：<br>

	<?php echo $data['menu']?>
	</div>

	<div class="rest_menu">
	<?php echo $data['introduction']?>
	</div>
	
	<div class="rest_menu">
	電話番号：<?php echo $data['phone']?>
	</div>

  <div id="map_canvas" style="width:100%; height:150px;margin:10px 0;"></div>
  <div class="rest_route">
  <a href="rest_route.php?rid=<? echo $rid ?> ">ここへのルート表示</a>
  </div>  
	<div class="rest_menu">
	エリア：<a href="rest_area.php?area=<?php echo $data['area_id'];?>" ><?php echo $data['aname'];?> </a>
	</div>

	<div class="rest_menu">
	<a href= "ship.php?area=<?php echo $data['area_id'];?>">舟の情報をみる</a>
	</div>	

	<div class="rest_menu">
	<?php
  if($empty ==0){
	while($data2=mysql_fetch_assoc($record2)){
		echo $data2['comText'].'<br>';
	}
}
	?>
	</div>	
	口コミを書く
	<form method= "post" action="commentdone.php">
			<textarea name="com" rows="3" cols="50"></textarea>
	<input type="hidden" name="rid" value="<?php echo $rid?>">
	 <input type="submit" value="送信" id= "submit_botton">
		</div>
	<footer>
	</footer>	
</body>


