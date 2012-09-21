<?php
session_start();
require('dbconnect.php');
if(!isset($_SESSION['result'])){
	header('location:search_store.php');
	exit();
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
<?php
	$rName=$_SESSION['result']['name'];
	$rId=$_SESSION['result']['id'];
	if($rId!=''){
		$sql1=sprintf('select * from mb_restaurant where rid="%d"',mysql_real_escape_string($rId));
		$recordset=mysql_query($sql1)or die(mysql_error());
		while($data=mysql_fetch_assoc($recordset)){
			echo $data['name'];
			echo " ";
			echo $data['lat'];
			echo " ";
			echo $data['long'];
			echo " ";
			echo $data['view'];
			echo " ";
			echo $data['menu'];
			echo " ";
			echo $data['comment'];
			echo " ";
			echo '<br />';
		}
	}
?>

</body>
</html>
