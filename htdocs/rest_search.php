<?php
require('dbconnect.php');
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

</script>
</head>
<body>
<header>
		<div id= "page_top">
		<a href="index.html"><img src= "img/logo.png" style="width:100%"></a>
		<img src= "img/line.png" style="width:100%">
		</div>
		<div id="info_top">お店情報をさがす！</div>
	</header>
	目的の店が決まっている人は
	<div class="search_rest">
		<div class= "rest_text">
			店番号からさがす
			<form method= "GET" action="">
			<input type= "text" name="" size="3" style="font-size:1.3em;" ></input>
		</div>
		<div class= "rest_submit">
			<input type="image" src="img/arrow.png" name="" width= "45"></input>
		</div>
	</form>
	</div>
	<div class="search_rest">
		<div class= "rest_text">
			店の名前からさがす
			<form method= "GET" action="">
			<input type= "text" name="" size="20"style="font-size:1.3em;" ></input>
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
