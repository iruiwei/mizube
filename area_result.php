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
	if($sel=="leave"){
		$sql1=sprintf('select count(*) as cnt from mb_shiptime where departureID="%d" and arrivalID="%d"',mysql_real_escape_string($lev),mysql_real_escape_string($arv));
		$recordset1=mysql_query($sql1)or die(mysql_error());
		$data1=mysql_fetch_assoc($recordset1);
		if($data1['cnt']>0){
			$sql=sprintf('select 
							mba1.area_name a1,
							mba2.area_name a2, 
							depTime, 
							costTime,
							currentTicket1 
						from 
							mb_shiptime,
							mb_area mba1,
							mb_area mba2 
						where 
							departureID="%d" 
						and 
							arrivalID="%d" 
						and 
							mba1.aid="%d" 
						and 
						mba2.aid="%d"',
				mysql_real_escape_string($lev),
				mysql_real_escape_string($arv),
				mysql_real_escape_string($lev),
				mysql_real_escape_string($arv));
			$table=mysql_query($sql)or die(mysql_error());
			echo "出発"."  "."出発時間"."  "."消費時間"."  "."到着"."  "."残りチケット";
			echo '<br />';
			while($data=mysql_fetch_assoc($table)){
				echo $data['a1']." ";
				echo $data['depTime']." ";
				echo $data['costTime']." ";
				echo $data['a2']." ";
				echo $data['currentTicket1']." ";
				echo '<br />';
			}
		}
		else{
			$sql2=sprintf('select count(*) as cnt from mb_shiptime as t1 right join mb_shiptime as t2 on t1.arrivalID=t2.departureID where t1.departureID="%d" and t2.arrivalID="%d" and t1.departureID<>t2.arrivalID',mysql_real_escape_string($lev),mysql_real_escape_string($arv));
			$recordset2=mysql_query($sql2)or die(mysql_error());
			$data2=mysql_fetch_assoc($recordset2);
			if($data2['cnt']>0){
				$sql=sprintf('select 
								mba1.area_name a1,
								mba2.area_name a2,
								mba3.area_name a3,
								t1.depTime dt1, 
								t1.costTime ct1,
								t2.depTime dt2, 
								t2.costTime ct2,
								t1.currentTicket1 cut1,
								t2.currentTicket1 cut2,
								t1.departureID as lev,
								t1.arrivalID as arv1,
								t2.arrivalID as arv2 
							from 
								mb_area as mba1,
								mb_area as mba2,
								mb_area as mba3, 
								mb_shiptime as t1 
							right join 
								mb_shiptime as t2 
							on 
								t1.arrivalID=t2.departureID 
							where 
								t1.departureID=mba1.aid 
							and 
								t1.arrivalID=mba2.aid
							and
								t2.arrivalID=mba3.aid 
							and 
								t1.departureID="%d" 
							and 
								t2.arrivalID="%d" 
							and
								(t1.depTime+t1.costTime)<t2.depTime
							and 
								t1.departureID<>t2.arrivalID' , 
						mysql_real_escape_string($lev), 
						mysql_real_escape_string($arv));
				$table=mysql_query($sql)or die(mysql_error());
				echo "出発"."  "."出発時間"."  "."消費時間"."  "."中継"."  "."残りチケット"."  "."出発"."  "."出発時間"."  "."消費時間"."  "."到着"."  "."残りチケット";
				echo '<br />';
				while($data=mysql_fetch_assoc($table)){
					echo $data['a1']." ";
					echo $data['dt1']." ";
					echo $data['ct1']." ";
					echo $data['a2']." ";
					echo $data['cut1']." ";
					echo $data['a2']." ";
					echo $data['dt2']." ";
					echo $data['ct2']." ";
					echo $data['a3']." ";
					echo $data['cut2']." ";
					echo '<br />';
				}
			}
			else{
				$sql3=sprintf('select count(*) as cnt from (select r1.departureID c1,r1.arrivalID c2,r2.arrivalID c3 from mb_shiptime r1 inner join mb_shiptime r2 on r1.arrivalID=r2.departureID where r1.departureID="%d") r3 inner join mb_shiptime r4 on r3.c3=r4.departureID where r4.arrivalID="%d"',mysql_real_escape_string($lev),mysql_real_escape_string($arv));
				$recordset3=mysql_query($sql3)or die(mysql_error());
				$data3=mysql_fetch_assoc($recordset3);
				if($data3['cnt']>0){
					$sql=sprintf('select 
									r3.c1,
									r3.c2,
									r3.c3,
									r3.a1,
									r3.dt1,
									r3.ct1,
									r3.cut1,
									r3.a2,
									r3.dt2,
									r3.ct2,
									r3.cut2,
									r3.a3,
									r4.depTime dt4,
									r4.costTime ct4,
									r4.currentTicket1 cut4,
									mba4.area_name a4,
									r4.arrivalID c4 
								from 
									mb_area mba4,
									(
									select 
										mba1.area_name a1,
										mba2.area_name a2,
										mba3.area_name a3,
										r1.depTime dt1,
										r1.costTime ct1,
										r1.currentTicket1 cut1,
										r2.depTime dt2,
										r2.costTime ct2,
										r2.currentTicket1 cut2,
										r1.departureID c1,
										r1.arrivalID c2,
										r2.arrivalID c3 
									from 
										mb_area mba1,
										mb_area mba2,
										mb_area mba3,
										mb_shiptime r1 
									inner join 
										mb_shiptime r2 
									on 
										r1.arrivalID=r2.departureID 
									where 
										mba1.aid=r1.departureID
									and
										(r1.depTime+r1.costTime)<r2.depTime
									and
										mba2.aid=r1.arrivalID
									and
										mba3.aid=r2.arrivalID
									and
										r1.departureID="%d") r3 
								inner join 
									mb_shiptime r4 
								on 
									r3.c3=r4.departureID 
								where 
									mba4.aid=r4.arrivalID
								and
									(r3.dt2+r3.ct2)<r4.depTime
								and
									r4.arrivalID="%d"' ,
						mysql_real_escape_string($lev), 
						mysql_real_escape_string($arv));
					$table=mysql_query($sql)or die(mysql_error());
					echo "出発"."  "."出発時間"."  "."消費時間"."  "."中継1"."  "."残りチケット"."  "."出発"."  "."出発時間"."  "."消費時間"."  "."中継2"."  "."残りチケット"."  "."出発"."  "."出発時間"."  "."消費時間"."  "."到着"."  "."残りチケット";
					echo '<br />';
					while($data=mysql_fetch_assoc($table)){
						echo $data['a1']." ";
						echo $data['dt1']." ";
						echo $data['ct1']." ";
						echo $data['cut1']." ";
						echo $data['a2']." ";
						echo $data['a2']." ";
						echo $data['dt2']." ";
						echo $data['ct2']." ";
						echo $data['cut2']." ";
						echo $data['a3']." ";
						echo $data['a3']." ";
						echo $data['dt4']." ";
						echo $data['ct4']." ";
						echo $data['cut4']." ";
						echo $data['a4']." ";
						echo '<br />';
					}
				}
				else{
					echo "No Result!";
				}
			}
		}
		//echo $lev.$arv.$sel.$h.$m.$s.$t;
	}
	else if($sel=="arrive"){
		
	}
	
	?>

</body>
</html>
