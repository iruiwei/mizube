<?php
session_start();
require('dbconnect.php');
/*
if(!isset($_SESSION['a_result'])){
	header('location:search_ship.php');
	exit();
}
*/
if(!isset($_POST)){
	header('location:search_ship.php');
	exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>area_result</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-09-24 -->
</head>
<body>
	<?php
	$lev=$_POST['a_leave'];
	$arv=$_POST['a_arrive'];
	$sel=$_POST['lORa'];
	$h=$_POST['hh'];
	$m=$_POST['mm'];
	$s=$_POST['ss'];
	$t=mktime("$h","$m","$s");
	$sql1=sprintf('select count(*) as cnt from mb_shiptime where departureID="%d" and arrivalID="%d"',mysql_real_escape_string($lev),mysql_real_escape_string($arv));
	$recordset1=mysql_query($sql1)or die(mysql_error());
	$data1=mysql_fetch_assoc($recordset1);
	if($data1['cnt']>0){
		$sql=sprintf('select * from mb_shiptime where departureID="%d" and arrivalID="%d"',mysql_real_escape_string($lev),mysql_real_escape_string($arv));
		$table=mysql_query($sql)or die(mysql_error());
		while($data=mysql_fetch_assoc($table)){
			echo $data['departureID']." ";
			echo $data['arrivalID']." ";
			echo '<br />';
		}
	}
	else{
		$sql2=sprintf('select count(*) as cnt from mb_shiptime as t1 right join mb_shiptime as t2 on t1.arrivalID=t2.departureID where t1.departureID="%d" and t2.arrivalID="%d" and t1.departureID<>t2.arrivalID',mysql_real_escape_string($lev),mysql_real_escape_string($arv));
		$recordset2=mysql_query($sql2)or die(mysql_error());
		$data2=mysql_fetch_assoc($recordset2);
		if($data2['cnt']>0){
			$sql=sprintf('select t1.departureID as lev,t1.arrivalID as arv1,t2.arrivalID as arv2 from mb_shiptime as t1 right join mb_shiptime as t2 on t1.arrivalID=t2.departureID where t1.departureID="%d" and t2.arrivalID="%d" and t1.departureID<>t2.arrivalID' , mysql_real_escape_string($lev), mysql_real_escape_string($arv));
			$table=mysql_query($sql)or die(mysql_error());
			while($data=mysql_fetch_assoc($table)){
				echo $data['lev']." ";
				echo $data['arv1']." ";
				echo $data['arv2']." ";
				echo '<br />';
			}
		}
		else{
			$sql3=sprintf('select count(*) as cnt from (select r1.departureID c1,r1.arrivalID c2,r2.arrivalID c3 from mb_shiptime r1 inner join mb_shiptime r2 on r1.arrivalID=r2.departureID where r1.departureID="%d") r3 inner join mb_shiptime r4 on r3.c3=r4.departureID where r4.arrivalID="%d"',mysql_real_escape_string($lev),mysql_real_escape_string($arv));
			$recordset3=mysql_query($sql3)or die(mysql_error());
			$data3=mysql_fetch_assoc($recordset3);
			if($data3['cnt']>0){
				$sql=sprintf('select r3.c1,r3.c2,r3.c3,r4.arrivalID c4 from (select r1.departureID c1,r1.arrivalID c2,r2.arrivalID c3 from mb_shiptime r1 inner join mb_shiptime r2 on r1.arrivalID=r2.departureID where r1.departureID="%d") r3 inner join mb_shiptime r4 on r3.c3=r4.departureID where r4.arrivalID="%d"' , mysql_real_escape_string($lev), mysql_real_escape_string($arv));
				$table=mysql_query($sql)or die(mysql_error());
				while($data=mysql_fetch_assoc($table)){
					echo $data['c1']." ";
					echo $data['c2']." ";
					echo $data['c3']." ";
					echo $data['c4']." ";
					echo '<br />';
				}
			}
			else{
				echo "No Result!";
			}
		}
	}
	//echo $lev.$arv.$sel.$h.$m.$s.$t;
	?>

</body>
</html>
