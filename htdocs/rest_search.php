<?php
require('dbconnect.php');

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>水辺バル</title>
	<meta name="author" content="SHEN RUIWEI">
	<meta name="description" content="水辺バル" />
	<meta name="keywords" content="水辺バル" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&hl=ja"></script>
	<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
	<!-- Date: 2012-10-08 -->
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35428958-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


}




</script>
</head>
<body>
	<?php
	
	if($visit == 1) {
		$_Id = mt_rand();
		setcookie('IDcookie', $_Id); // 有効期限なしのクッキーを設定
		//$sql0=sprintf('select count(*) as cnt from mb_guest where id="%d"',mysql_real_escape_string($_Id));
		//$rec=mysql_query($sql0)or die(mysql_error());
		//$table=mysql_fetch_assoc($rec);
		//if($table['cnt']==0){
			$sql1="insert into mb_guest (id,views,lat,lon,page) values(".mysql_real_escape_string($_Id).",".mysql_real_escape_string($visit).",".$lat.",".$lon.",2)";
		
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
		$sql1="insert into mb_guest (id,views,lat,lon,page) values(".mysql_real_escape_string($_Id).",".mysql_real_escape_string($visit).",".$lat.",".$lon.",2)";
		//$sql1=sprintf('update mb_guest set lat="%d",lon="%d",views="%d" where id="%d"',mysql_real_escape_string($lat),mysql_real_escape_string($lon),mysql_real_escape_string($visit),mysql_real_escape_string($_Id));
	
		$record1=mysql_query($sql1)or die(mysql_error());
	 	//$table=mysql_fetch_assoc($record);

		//echo "ID:".$_Id."さん".'<br />';
		//echo "今回で".$visit."回目の訪問になります";
	}
	?>
	
	
<header>
		<div id= "page_top">
		<a href="./"><img src= "img/logo.png" style="width:100%"></a>
		<img src= "img/line.png" style="width:100%">
		</div>
		<div id="info_top">お店情報をさがす！</div>
		お店の口コミ情報の入力にもご協力お願いします！	<br><br>	
	</header>
	目的の店が決まっている人は
	<div class="search_rest">
		<div class= "rest_text">
			店番号からさがす
			<form method= "post" action="rest_info.php">
			<input type="text" name="id" size="3" style="font-size:1.3em;" value="<?php echo htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8')?>"/>
		</div>
		<div class= "rest_submit">
			<input type="image" src="img/arrow.png" name="" width= "45"></input>
		</div>
	</form>
	</div>
	<div class="search_rest">
		<div class= "rest_text">
			店の名前からさがす
			<form method= "post" action="rest_name.php">
				<input type="hidden" id="tlat" name="tlat" />
				<input type="hidden" id="tlon" name="tlon" />
			<input type="text" name="name" size="10" maxlength="50" style="font-size:1.3em;" value="<?php echo htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8')?>"/>
		</div>
		<div class= "rest_submit">
			<input type="image" src="img/arrow.png" name="" width= "45"></input>
		</div>
	</form>
	</div>
いろんなお店をさがしてみよう
	<div class="search_rest">
		<div class= "rest_text">
			エリアからさがす
			<form method= "GET" action="rest_area.php">
			<?php
			$sql0=sprintf('select mb_area.id,mb_area.name from mb_area');
			$recordset0=mysql_query($sql0)or die(mysql_error());
			?>
			<select name='area'>
				<?php
				while($data0=mysql_fetch_assoc($recordset0)){	
				?>	
					<option value=<?php echo $data0['id'];?>><?php echo $data0['name'];?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div class= "rest_submit">
			<input type="image" src="img/arrow.png" name="" width= "45"></input>
		</div>
	</form>
	</div>

 <div class="twitter">
	 <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
version: 2,
type: 'profile',
rpp: 4,
interval: 10000,
title: '',
subject: '水辺バル2012',
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
}).render().setUser('mizube_barOSAKA').start();
</script>

</div>

</body>
</html>
