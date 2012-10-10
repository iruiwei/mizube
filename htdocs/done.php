<?php
session_start();
require('dbconnect.php');
if(isset($_SESSION['sid'])){
	$A_st=$_SESSION['sid'];
	//print_r($_SESSION);
	$sql="";
	$ch=0;
	foreach($A_st as $sid){
		if($_POST[$sid]==0) $ch=20;
		else if($_POST[$sid]==1) $ch=9;
		else if($_POST[$sid]==2) $ch=4;
		else $ch=0;
		$sql=$sql."update mb_shiptime2 set currentTicket1='".mysql_real_escape_string($ch)."' where sid='".mysql_real_escape_string($sid)."';";
	}
	echo '<br>';
	echo $sql;
	echo '<br>';
	mysqli_multi_query($sql)or die(mysql_error());
	echo "done!";
	
}
print_r($_POST);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>done</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-10 -->
</head>
<body>

</body>
</html>
