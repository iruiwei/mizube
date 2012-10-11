<?php
session_start();

if(empty($_REQUEST['area'])){
	$area=1;
}
else
	$area=$_REQUEST['area'];
	
$day=date("d");
if($day=='13'){
	if(date("H")<15)
		$d=1;
	else
		$d=0;
}
else if($day=='14')
	$d=2;
else $d=2;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>水辺バル</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<link rel="stylesheet" href="style.css">
	<!-- Date: 2012-10-08 -->
</head>
<body>
	<header>
		<div id= "page_top">
		<a href="./"><img src= "img/logo.png" style="width:100%"></a>
		<img src= "img/line.png" style="width:100%">
		</div>
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
	</header>
	<div id="info">
		エリアを選んでください。
	</div>
	<form method= "post" action="ship.php">
	<?php
	require('dbconnect.php');
	
	$sql0=sprintf('select mb_area.id,mb_area.name from mb_area');
	$recordset0=mysql_query($sql0)or die(mysql_error());
	?>
	<select name='area'>
		<?php
		
			while($data0=mysql_fetch_assoc($recordset0)){
				echo '<option value="'. $data0['id'] .'"';
				if($_REQUEST['area']==$data0['id']){
					echo ' selected';
				}
				echo '>'. $data0['name']. '</option>';
			}
		
		
	?>
	</select>
	
	 <input type="submit" value="決定" id= "submit_botton">
	 </form>
	
	<div id="ship_info">
	 <h3 class="ship_title">運行情報</h3>
	 <div class="ship_ex">整理券の残り枚数<br>（◎:多数、◯:10枚以下、△：５枚以下、ｘ：なし、運休）<br>乗船の際は必ず各便出発地の船着場で配布される整理券が必要です。また、17時以降の整理券は15時より配布されます。
	 </div>
	<?php
		$sql0=sprintf('select 
							count(t.departureID) cnt 
						from(
							select distinct 
								departureID 
							from 
								mb_shiptime 
							where 
								areaId="%d") as t',
					mysql_real_escape_string($area));
		$recordset0=mysql_query($sql0)or die(mysql_error());
		$data0=mysql_fetch_assoc($recordset0);
		$cnt=$data0['cnt'];
		$sql1=sprintf('select distinct departureID as did from mb_shiptime where areaId="%d"',mysql_real_escape_string($area));
		$recordset1=mysql_query($sql1)or die(mysql_error());
		while($data1=mysql_fetch_row($recordset1)){
			$sql2=sprintf('select distinct arrivalID as aid from mb_shiptime where departureID="%d"',mysql_real_escape_string($data1[0]));
			$recordset2=mysql_query($sql2)or die(mysql_error());
			while($data2=mysql_fetch_row($recordset2)){
				$sql2n=sprintf('select t1.area_name c1,t2.area_name c2 from mb_port as t1,mb_port as t2 where t1.aid="%d" and t2.aid="%d"',mysql_real_escape_string($data1[0]),mysql_real_escape_string($data2[0]));
				$recordset2n=mysql_query($sql2n)or die(mysql_error());
				$data2n=mysql_fetch_assoc($recordset2n);
	?>
	 <div class="ship_to"><?php echo $data2n['c1'];?> →　<?php echo $data2n['c2'];?>	</div>

	 	<div class="ship_info">
		現在、５分遅れで運行しています。
	</div>
	<?php
	
	$sql3=sprintf('select depTime, currentTicket1, falg from mb_shiptime where arrivalID="%d" and departureID="%d" and falg<>"%d"  order by depTime asc',mysql_real_escape_string($data2[0]),mysql_real_escape_string($data1[0]),mysql_real_escape_string($d));
	$recordset3=mysql_query($sql3)or die(mysql_error());
	$count=0;
	?>
	<table>
	<?php
	while($data3=mysql_fetch_assoc($recordset3)){
		$t=strtotime($data3['depTime']);
		if($count!=0&&$i>6&&$count==idate('H',$t)){
			?></tr><?php
		}
		if($count==0||$count!=idate('H',$t)){
			if($count!=0&&$count!=idate('H',$t)&&$i<7){
				?><td colspan="<?php echo (7-$i);?>"><?php echo "  ";?></td></tr><?php  
			}
			$count=idate('H',$t);
			$i=0;
			?>
			<tr>
				<th><?php echo idate('H',$t)?></th>
				<td><?php echo idate('i',$t)." ";
					if($data3['currentTicket1']>=10)
						echo "◎";
					else if($data3['currentTicket1']<10&&$data3['currentTicket1']>=5)
						echo "◯";
					else if($data3['currentTicket1']<5&&$data3['currentTicket1']>0)
						echo "△";
					else echo "ｘ";
					?></td>
			
		<?php
		}
		else{?>
			<td><?php echo idate('i',$t)." ";
				if($data3['currentTicket1']>=10)
					echo "◎";
				else if($data3['currentTicket1']<10&&$data3['currentTicket1']>=5)
					echo "◯";
				else if($data3['currentTicket1']<5&&$data3['currentTicket1']>0)
					echo "△";
				else echo "ｘ";
				?></td>
				
		<?php
		}
		$i++;
	}
	?>
	</table>
	<?php
}
}
	?>
	 </div>

	 	エリア情報
	 	 <div class="twitter">
	 <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
    <?php
	  	$sql1=sprintf('select name,hashtag from mb_area where id = "%d"',mysql_real_escape_string($area));
		$recordset1=mysql_query($sql1)or die(mysql_error()); 
		$hashtag="";
		$name="";
			while($data1=mysql_fetch_assoc($recordset1)){
				$name = $data1['name']; 
				$hashtag = $data1['hashtag']; 
				}
	?>
<script>
new TWTR.Widget({
version: 2,
type: 'search',
search: '<? echo $hashtag ?>',
interval: 30000,
title: '',
subject: '<? echo $name ?>',
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

</body>
</html>
