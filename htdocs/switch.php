<?php
	require('dbconnect.php');
	if(!isset($_POST[r1])||!isset($_POST[r1])||!isset($_POST[r1])){
		$sql=sprintf('select * from mb_fake_rest where id=(select max(id) from mb_fake_rest where rank=1)')
	}

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
	<form action="rank.php" method="post">
		<input type="text" name="r1" value=""/><br>
		<input type="text" name="r2" value=""/><br>
		<input type="text" name="r3" value=""/><br>
		<input type="subbmit" value="OK">
	</form>

</body>
</html>
