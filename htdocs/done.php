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
		$case=$case."when ".$sid." then ".$ch." ";
		if($count==0){
			$asid=$sid;
		}
		else{
			$asid=$asid.",".$sid;
		}
		$count++;
	}
	
	$sql="update mb_shiptime2 set currentTicket1=case sid ".mysql_real_escape_string($case)." end where sid in (".mysql_real_escape_string($asid).")";
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
	echo '<br>';
	echo $case;
	echo '<br>';
	echo $asid;
	$sql="update mb_shipcomments set comText=case id ".$case." end where id in (".mysql_real_escape_string($asid).")";
	echo '<br>';
	echo $sql;
	echo '<br>';
	mysql_query($sql)or die(mysql_error());
	echo "done!";
	
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
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-10 -->
</head>
<body>

</body>
</html>
