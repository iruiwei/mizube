<?php
session_start();
require('dbconnect.php');
//if(!empty($_POST)){
	//$_SESSION['a_result']=$_POST;
	//header('location:area_result.php');
	//exit();
//}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>search_ship</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-09-24 -->
</head>
<body>
	<form action="area_result.php" method="post">
		
		
		leave for
		<?php
		$sql=sprintf('select aid,area_name from mb_area');
		$record=mysql_query($sql)or die(mysql_error());
		?>
		<select name="a_leave">
		<?php
		while($table=mysql_fetch_assoc($record)){
		?>
			<option value="<?php echo $table['aid']?>"><?php echo $table['area_name']?></option>
		<?php
		;	
		}
		?>
		</select>
		<br>
		
		
		to
		<?php
		$sql=sprintf('select aid,area_name from mb_area');
		$record=mysql_query($sql)or die(mysql_error());
		?>
		<select name="a_arrive">
		<?php
		while($table=mysql_fetch_assoc($record)){
		?>
			<option value="<?php echo $table['aid']?>"><?php echo $table['area_name']?></option>
		<?php
		;	
		}
		?>
		</select>
		<br>
		
		
		<select name="lORa">
			<option value="leave">time for leave</option>
			<option value="arrive">time for arrive</option>
		</select>
		<br>
		
		
		hour
		<select name="hh">
		<?php
			$h=1;
			do{
				?>
				<option value="<?php echo $h?>"><?php echo $h?></option>
				<?php
				;
				$h++;
			}while($h<22);
		?>
		</select>
		
		
		minute
		<select name="mm">
		<?php
			$h=0;
			do{
				?>
				<option value="<?php echo $h?>"><?php echo $h?></option>
				<?php
				;
				$h++;
			}while($h<60);
		?>
		</select>
		
		<br>
		<input type="submit" value="ok"/>
		<br>
	</form>
</body>
</html>
