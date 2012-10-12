<?php
require('dbconnect.php');
if( isset($_COOKIE['visitcount']) )
{ // クッキーがあればその値がカウント値
  $visit = $_COOKIE['visitcount'];
} 
else{ // クッキーがなければ初回訪問としてカウント値は0
  $visit = 1;
}
setcookie('visitcount', $visit);
//echo $visit;
if(!isset($_POST['com'])||!isset($_POST['rid'])){
	header('location:rest_info.php');
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv='refresh'content=2;URL='http://mizubebar.net/rest_info.php?rid=<?php echo $_POST['rid'];?>'>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>commentdone</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-12 -->
</head>
<body>
	<?php
	if($visit == 1) {
		$_Id = mt_rand();
		setcookie('IDcookie', $_Id);
	}
	else
		$_Id = $_COOKIE['IDcookie'];
	
	$sql=sprintf('insert into mb_comments(rid,comName,comText) values("%d","%d","%s")',mysql_real_escape_string($_POST['rid']),mysql_real_escape_string($_Id),mysql_real_escape_string($_POST['com']));
	mysql_query($sql)or die(mysql_error());
	//echo $_POST['com'];
	echo "Thank You!";
	?>

</body>
</html>
