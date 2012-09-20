<?php
session_start();
require('dbconnect.php');
if(!isset($_SESSION['result'])){
	header('location:search_store.php');
	exit();
}
if(!empty($_post)){
	echo "done!";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>result</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-09-20 -->
</head>
<body>
	

</body>
</html>
