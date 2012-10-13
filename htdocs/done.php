<?php
session_start();
require('dbconnect.php');
if(isset($_SESSION['sid'])&&isset($_SESSION['aid'])){
	$A_st=$_SESSION['sid'];
	$A_at=$_SESSION['aid'];
	//print_r($_SESSION);
	$sql="";
	$ch=0;
	$case="";
	$asid="";
	$count=0;
	foreach($A_st as $sid){
		if($_POST[$sid]==0) $ch=20;
		else if($_POST[$sid]==1) $ch=9;
		else if($_POST[$sid]==2) $ch=4;
		else $ch=0;
		$case=$case."when ".($sid-100)." then ".$ch." ";
		if($count==0){
			$asid=($sid-100);
		}
		else{
			$asid=$asid.",".($sid-100);
		}
		$count++;
	}
	
	$sql="update mb_shiptime set currentTicket1=case sid ".mysql_real_escape_string($case)." end where sid in (".mysql_real_escape_string($asid).")";
	echo '<br>';
	mysql_query($sql)or die(mysql_error());
	$case="";
	$asid="";
	$sql="";
	$count=0;
	foreach($A_at as $aid){
		$case=$case."when ".$aid." then '".$_POST[$aid]."' ";
		if($count==0){
			$asid=$aid;
		}
		else{
			$asid=$asid.",".$aid;
		}
		$count++;
	}
	//echo '<br>';
	//echo $case;
	//echo '<br>';
	//echo $asid;
	$sql="update mb_shipcomments set comText=case id ".$case." end where id in (".mysql_real_escape_string($asid).")";
	//echo '<br>';
	//echo $sql;
	//echo '<br>';
	mysql_query($sql)or die(mysql_error());
	echo "done!";
	echo '<br>';
}
//print_r($_POST);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>done</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-10 -->
</head>
<body>
	
	<a href="admin.php" >エリア選択に戻る</a><br>
	<br>
	<a href="edit.php">同じエリアに戻る</a>

</body>
</html>
