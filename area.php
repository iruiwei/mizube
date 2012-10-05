<?php
session_start();
require('dbconnect.php');
$area=$_REQUEST['area'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>area</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-05 -->
</head>
<body>
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
		echo"areaid=";
		echo $area;
		echo "　　内の船場が";
		echo '<br/>';
		echo $data0['cnt']."  　箇所がある";
		echo '<br/>';
		$sql1=sprintf('select distinct departureID as did from mb_shiptime where areaId="%d"',mysql_real_escape_string($area));
		$recordset1=mysql_query($sql1)or die(mysql_error());
		while($data1=mysql_fetch_row($recordset1)){
			$sql2=sprintf('select distinct arrivalID as aid from mb_shiptime where departureID="%d"',mysql_real_escape_string($data1[0]));
			$recordset2=mysql_query($sql2)or die(mysql_error());
			while($data2=mysql_fetch_row($recordset2)){
				$sql2n=sprintf('select t1.area_name c1,t2.area_name c2 from mb_port as t1,mb_port as t2 where t1.aid="%d" and t2.aid="%d"',mysql_real_escape_string($data1[0]),mysql_real_escape_string($data2[0]));
				$recordset2n=mysql_query($sql2n)or die(mysql_error());
				$data2n=mysql_fetch_assoc($recordset2n);
				echo '<br/>';
				echo $data2n['c1']."  "."TO"."  ".$data2n['c2'];
				$sql3=sprintf('select depTime, currentTicket1 from mb_shiptime where arrivalID="%d" and departureID="%d"',mysql_real_escape_string($data2[0]),mysql_real_escape_string($data1[0]));
				$recordset3=mysql_query($sql3)or die(mysql_error());
				$count=0;
				while($data3=mysql_fetch_assoc($recordset3)){
					$t=strtotime($data3['depTime']);
					
					if($count==0||$count!=idate('H',$t)){
						$count=idate('H',$t);
						echo '<br/>';
						echo idate('H',$t)."時"."  ";
						echo "  ".idate('i',$t)."分"."  ";
						echo " ".$data3['currentTicket1']."枚"."  ";
					}
					else{
						echo "  ".idate('i',$t)."分"."  ";
						echo " ".$data3['currentTicket1']."枚"."  ";
					}
					//$count++;
					//echo '<br/>';
				}
				echo '<br/>';
			}
		}
	?>

</body>
</html>
