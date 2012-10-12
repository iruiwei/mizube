<?php
	require('dbconnect.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>rank</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<!-- Date: 2012-10-12 -->
</head>
<body>
	<?php
	if(isset($_POST[s])){
		$sql=sprintf('insert into mb_state (sid) values ("%d")',mysql_real_escape_string($_POST[s]));
		mysql_query($sql)or die(mysql_error());
		echo "State_Now:"."  ".$_POST[s];
	}
	else{
		//if(!isset($_POST[s0])&&!isset($_POST[s1])){
			$sql=sprintf('select sid from mb_state where id=(select max(id) from mb_state)');
			$recordset=mysql_query($sql)or die(mysql_error());
			$data=mysql_fetch_assoc($recordset);
			echo "State_Now:"."  ".$data['sid'];
		//}
	}
	?>
	<form action="switch.php" method="post">
		<input type="radio" name="s" value="0">NO<br>
		<input type="radio" name="s" value="1">YES<br>
		<input type="submit" value="OK">
	</form>

</body>
</html>
