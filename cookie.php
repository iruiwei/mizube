<? ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>cookie</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-04 -->
</head>
<body>
	<?php
	require('dbconnect.php');
	// 訪問回数カウント用の変数$visitにカウント値を格納
	if( isset($_COOKIE['visitcount']) )
	{ // クッキーがあればその値がカウント値
	  $visit = $_COOKIE['visitcount'];
	} 
	else{ // クッキーがなければ初回訪問としてカウント値は0
	  $visit = 0;
	}

	$visit++; // カウント値+1

	setcookie('visitcount', $visit); // 有効期限なしのクッキーを設定

	if($visit == 1) {
		$_Id = mt_rand();
		setcookie('IDcookie', $_Id); // 有効期限なしのクッキーを設定
		$sql0=sprintf('select count(*) as cnt from mb_guest where id="%d"',mysql_real_escape_string($_Id));
		$rec=mysql_query($sql0)or die(mysql_error());
		$table=mysql_fetch_assoc($rec);
		if($table['cnt']==0){
			$sql1=sprintf('insert into mb_guest values("%d","%d",0)',mysql_real_escape_string($_Id),mysql_real_escape_string($visit));
			$record=mysql_query($sql1)or die(mysql_error());
			echo "初めての訪問ありがとうございます.<br />あなたのIDは".$_Id."です．";
		}
		else{
			echo "Error!";
		}
	}
	else 
	{
		$_Id = $_COOKIE['IDcookie'];
		$sql1=sprintf('update mb_guest set views="%d" where id="%d"',mysql_real_escape_string($visit),mysql_real_escape_string($_Id));
		$record=mysql_query($sql1)or die(mysql_error());
	 	//$table=mysql_fetch_assoc($record);

		echo "ID:".$_Id."さん.<br />
		今回で".$visit."回目の訪問になります";}

	?>

</body>
</html>
<? ob_flush(); ?>