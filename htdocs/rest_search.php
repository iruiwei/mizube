<?php
require('dbconnect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
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
		<h2>レストラン情報をさがす</h2>
		<img src= "img/line.png" style="width:100%">
	</header>
	目的の店が決まっている人は
	<div class="search_rest">
		<div class= "rest_text">
			店番号からさがす
			<form method= "GET" action="">
			<input type= "text" name="" size="3"></input>
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
			<input type= "text" name="" size="20"></input>
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
			<form method= "GET" action="">
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
	<div class="search_rest">
		<div class= "rest_text">
			ジャンルからさがす
			<form method= "GET" action="">
				<?php
				$sql1=sprintf('select tag_id,tag_name from mb_tag');
				$recordset1=mysql_query($sql1)or die(mysql_error());
				?>
				<select name='tag'>
					<?php
					while($data1=mysql_fetch_assoc($recordset1)){	
					?>	
						<option value=<?php echo $data1['tag_id'];?>><?php echo $data1['tag_name'];?></option>
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
		<div class="search_rest">
		<div class= "rest_text">
			全エリアからのランキング！
		</div>
		<div class= "rest_submit">
			<input type="image" src="img/arrow.png" name="" width= "45"></input>
		</div>
	</form>
	</div>

</body>
</html>
