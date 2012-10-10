<? ob_start(); ?>
<html xmlns="http://www.w3.org/1999/xhml">
<head>
	<meta charset="utf-8" />
	<title>水辺バル</title>
	<meta name="description" content="水辺バル" />
	<meta name="keywords" content="水辺バル" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js" charset="utf-8"></script>
	<link rel="stylesheet" href="style.css">
	<style></style>
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

<body>
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

	if($visit == 1) {
		$_Id = mt_rand();
		setcookie('IDcookie', $_Id); // 有効期限なしのクッキーを設定
		$sql0=sprintf('select count(*) as cnt from mb_guest where id="%d"',mysql_real_escape_string($_Id));
		$rec=mysql_query($sql0)or die(mysql_error());
		$table=mysql_fetch_assoc($rec);
		if($table['cnt']==0){
			$sql1=sprintf('insert into mb_guest(id,views) values("%d","%d")',mysql_real_escape_string($_Id),mysql_real_escape_string($visit));
			$record=mysql_query($sql1)or die(mysql_error());
			//echo "初めての訪問ありがとうございます.<br />あなたのIDは".$_Id."です．";
		}
		else{
			echo "Error!";
		}
	}
	else 
	{
		$_Id = $_COOKIE['IDcookie'];
		$sql1=sprintf('update mb_guest set views="%d" where id="%d"',mysql_real_escape_string($visit),mysql_real_escape_string($_Id));
		$record=mysql_query($sql1)or die(mysql_error());
	 	//$table=mysql_fetch_assoc($record);

		//echo "ID:".$_Id."さん.<br />
		//今回で".$visit."回目の訪問になります";
		}

	?>
	
	
	<header>
		<div id= "page_top">
		<img src= "img/logo.png" style="width:100%">
		<img src= "img/line.png" style="width:100%">
		</div>
	</header>
	<div id="info">水辺バルがもっと楽しくなる情報がいっぱいです。<br>
	  ・現在地からおすすめを自動で選択します<br>
	  ・船の整理券の残り枚数をほぼリアルタイムで案内します<br>
	  ・レストランの場所を案内します<br>
	 <small> *GPS情報を使用します。位置が正確ではなかったり、対応していない機種があります。</small>
	</div>
	<div class= "nav">
	<a href="gps.php"><img src="img/osusume.png" style="width:100%"></a>
	</div>
	<div class= "nav">
	<a href="ship_search.html"><img src="img/fune.png" style="width:100%"></a>
	</div>
	<div class= "nav">
	<a href="rest_search.php"><img src="img/resutoran.png" style="width:100%"></a>
	</div>
	 
	 <div id="info">
	 <a href="http://osaka-mizubebar2012.seesaa.net/">水辺バル2012 公式サイト</a><br>
	 開催期間：2012.10.13-14<br>
	 </div>
	 <div class="twitter">
	 <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
version: 2,
type: 'profile',
rpp: 4,
interval: 20000,
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
<? ob_flush(); ?>