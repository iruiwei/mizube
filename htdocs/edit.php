<?php
session_start();
require('dbconnect.php');
if(!isset($_SESSION['area'])||!empty($_REQUEST['area'])){
	$area=$_REQUEST['area'];
	$_SESSION['area']=$area;
}

else{
	$area=$_SESSION['area'];
}
$d=2;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>edit</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<meta name="author" content="SHEN RUIWEI">
	<link rel="stylesheet" href="style.css">
	<!-- Date: 2012-10-09 -->
</head>
<body>
	<a href="admin.php">エリア選択に戻る</a><br>
	<form action="done.php" method="post">
	
	<?php
		
		$nt=0;
		$marks = array("◎","10","5","0");
		$st=0;
		$A_st;
		$at=0;
		$A_at;
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
				$sql2n=sprintf('select t1.area_name as c1,t2.area_name as c2,comText,id from mb_shipcomments,mb_port as t1,mb_port as t2 where departureID="%d" and arrivalID="%d" and t1.aid="%d" and t2.aid="%d"',mysql_real_escape_string($data1[0]),mysql_real_escape_string($data2[0]),mysql_real_escape_string($data1[0]),mysql_real_escape_string($data2[0]));
				$recordset2n=mysql_query($sql2n)or die(mysql_error());
				$data2n=mysql_fetch_assoc($recordset2n);
	?>
	 <div class="ship_to"><?php echo $data2n['c1'];?> →　<?php echo $data2n['c2'];?>	</div>
<!----><input type="text" name="<?php echo $data2n['id'];?>" value="<?php echo $data2n['comText'];?>">
		<?php
			$A_at[$at]=$data2n['id'];
			$at++;
		?>
	 	<div class="ship_info">
		
	</div>
	<?php
	
	$sql3=sprintf('select sid, depTime, currentTicket1, falg from mb_shiptime where arrivalID="%d" and departureID="%d" and falg<>"%d"  order by depTime asc',mysql_real_escape_string($data2[0]),mysql_real_escape_string($data1[0]),mysql_real_escape_string($d));
	$recordset3=mysql_query($sql3)or die(mysql_error());
	$count=0;
	?>
	<table>
	<?php
	while($data3=mysql_fetch_assoc($recordset3)){
		$t=strtotime($data3['depTime']);
		$A_st[$st]=$data3['sid'];
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
				<td>
					<?php echo idate('i',$t)." ";?>
					<select name="<?php echo $data3['sid']?>" >
					<?php
					if($data3['currentTicket1']>=10){
						?><option value="0"><?php echo "◎";$nt=0;?></option><?php
					}
					else if($data3['currentTicket1']<10&&$data3['currentTicket1']>=5){
						?><option value="1"><?php echo "10";$nt=1;?></option><?php
					}
					else if($data3['currentTicket1']<5&&$data3['currentTicket1']>0){
						?><option value="2"><?php echo "5";$nt=2;?></option><?php
					}
					else {
						?><option value="3"><?php echo "0";$nt=3;?></option><?php
					}
					for($n=0;$n<4;$n++){
						if($n!=$nt){
							?><option value="<?php echo $n;?>"><?php echo $marks[$n];?></option><?php 
						}
					}
					?>
					</select>
					</td>
			
		<?php
		}
		else{?>
			<td>
				<?php echo idate('i',$t)." ";?>
				<select name="<?php echo $data3['sid']?>" >
				<?php
				if($data3['currentTicket1']>=10){
					?><option value="0"><?php echo "◎";$nt=0;?></option><?php
				}
				else if($data3['currentTicket1']<10&&$data3['currentTicket1']>=5){
					?><option value="1"><?php echo "10";$nt=1;?></option><?php
				}
				else if($data3['currentTicket1']<5&&$data3['currentTicket1']>0){
					?><option value="2"><?php echo "5";$nt=2;?></option><?php
				}
				else {
					?><option value="3"><?php echo "0";$nt=3;?></option><?php
				}
				for($n=0;$n<4;$n++){
					if($n!=$nt){
						?><option value="<?php echo $n;?>"><?php echo $marks[$n];?></option><?php
					}
				}
				?>
				</select>
				</td>
				
		<?php
		}
		$i++;
		$st++;
	}
	?>
	</table>
	<?php
}
}
	?>
	 </div>
	<?php
	$_SESSION['sid']=$A_st;
	$_SESSION['aid']=$A_at;
	?>
	<br>
	<input type="submit" value="OK"/>
	
</form>
</body>
</html>
