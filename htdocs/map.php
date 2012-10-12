<?php
require('dbconnect.php');
// 訪問回数カウント用の変数$visitにカウント値を格納
if( isset($_COOKIE['visitcount']) )
{ // クッキーがあればその値がカウント値
  $visit = $_COOKIE['visitcount'];
} 
else{ // クッキーがなければ初回訪問としてカウント値は0
  $visit = 0;
}

$visit++; // カウント値+1

setcookie('visitcount', $visit); // 有効期限なしのクッキーを設定

//echo $_REQUEST['lat'];
//echo '<br>';
//echo $_REQUEST['lon'];
$lat=$_REQUEST['lat'];
$lon=$_REQUEST['lon'];

$A_rid;
$i=0;
$sql00="select (('".$lat."'-lat)*('".$lat."'-lat)+('".$lon."'-lon)*('".$lon."'-lon)) dis,lat,lon,menu,introduction, photo,rid,name from mb_restaurant order by dis asc limit 0,3";

$table00=mysql_query($sql00)or die(mysql_error());
while($data00=mysql_fetch_assoc($table00)){
	$A_rid[$i]=$data00['rid'];
	$i++;
}
//----------array test-------------
echo $A_rid[0]."  ".$A_rid[1]."  ".$A_rid[2];
echo '<br>';
//---------------------------------
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>MAP</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&hl=ja"></script>
<script type="text/javascript">
	var lat=0;
	var lng=0;
function initialize() {
    var initPos = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lon ?>); 
	var myOptions = {
    	noClear : true,
    	center : initPos,
    	zoom : 17,
    	mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    var map_canvas = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		
//ユーザの位置情報取得
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    //位置情報取得成功時
　　	function successCallback(position){
　　　		lat = position.coords.latitude;
    	lng = position.coords.longitude;
   

         //現在位置マーカーの生成
      var nowlatlng = new google.maps.LatLng(lat, lng);
　　　var marker = new google.maps.Marker({
       position: nowlatlng,
       map: map_canvas,
      });

	var info = new google.maps.InfoWindow({content: '<p>現在位置</p>'});

	　google.maps.event.addListener(marker, 'click', function(){
       info.open(map_canvas, marker);
      });

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

	<header>
		<a href="./"><img src= "img/logo.png" style="width:100%"></a>
		<img src= "img/line.png" style="width:100%">
	
	</header>




	<div id="rest_area">
	<?php
	
	if($visit == 1) {
		$_Id = mt_rand();
		setcookie('IDcookie', $_Id); // 有効期限なしのクッキーを設定
		//$sql0=sprintf('select count(*) as cnt from mb_guest where id="%d"',mysql_real_escape_string($_Id));
		//$rec=mysql_query($sql0)or die(mysql_error());
		//$table=mysql_fetch_assoc($rec);
		//if($table['cnt']==0){
			$sql1=sprintf('insert into mb_guest (id,views,lat,lon) values("%d","%d","%d","%d")',mysql_real_escape_string($_Id),mysql_real_escape_string($visit),mysql_real_escape_string($lat),mysql_real_escape_string($lon));
			$record=mysql_query($sql1)or die(mysql_error());
			//echo "初めての訪問ありがとうございます.<br />あなたのIDは".$_Id."です．";
		//}
		//else{
		//	echo "Error!";
		//}
	}
	else 
	{
		$_Id = $_COOKIE['IDcookie'];
		$sql1=sprintf('insert into mb_guest (id,views,lat,lon) values("%d","%d","%d","%d")',mysql_real_escape_string($_Id),mysql_real_escape_string($visit),mysql_real_escape_string($lat),mysql_real_escape_string($lon));
		//$sql1=sprintf('update mb_guest set lat="%d",lon="%d",views="%d" where id="%d"',mysql_real_escape_string($lat),mysql_real_escape_string($lon),mysql_real_escape_string($visit),mysql_real_escape_string($_Id));
		$record1=mysql_query($sql1)or die(mysql_error());
	 	//$table=mysql_fetch_assoc($record);

		//echo "ID:".$_Id."さん".'<br />';
		//echo "今回で".$visit."回目の訪問になります";
	}
	
	echo '<br>';
	
	if($_Id%3==0){
		$sql0="select (('".$lat."'-lat)*('".$lat."'-lat)+('".$lon."'-lon)*('".$lon."'-lon)) dis,lat,lon,menu,introduction, photo,rid,name from mb_restaurant order by dis asc limit 0,3";

		$table=mysql_query($sql0)or die(mysql_error());
		
		?>
		
		<div id="info">一番近いお店</div>

			<?php
			while($data=mysql_fetch_assoc($table)){
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

			?>

			</div>
		
		<?php
		
		//while($data=mysql_fetch_assoc($table)){
		//	echo $data['name']."  ".$data['dis'];
		//	echo '<br/>';
		//}
	}
	else if($_Id%3==1){
		$sql0="select (('".$lat."'-lat)*('".$lat."'-lat)+('".$lon."'-lon)*('".$lon."'-lon)) dis,lat,lon,photo,introduction,name,mb_restaurant.rid as rrid,mb_fake_rest.id from mb_restaurant,mb_fake_rest where mb_fake_rest.rid=mb_restaurant.rid order by mb_fake_rest.id asc limit 0,3";
		$table=mysql_query($sql0)or die(mysql_error());
		?>
		<div id="info">一番近いお店</div>

			<?php
			while($data=mysql_fetch_assoc($table)){
				?>

				<a href= "rest_info.php?rid=<?php echo $data['rrid']?>"><div class= "restaurant">
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

			?>

			</div>
			<?php
		
		//while($data=mysql_fetch_assoc($table)){
		//	echo $data['name']."  ".$data['dis'];
		//	echo '<br/>';
		//}
	}
	else{
		
	}
	?>


	  <div id="map_canvas" style="width:100%; height:200px;margin:10px 0;"></div>


	



</div>
</body>
</html>
