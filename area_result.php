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
	echo $lev.$arv.$sel.$h.$m.$s.$t;
	//echo $SESSION['a_result']['a_leave'];
	?>

</body>
</html>
