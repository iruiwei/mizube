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

//$visit++; // カウント値+1

setcookie('visitcount', $visit); // 有効期限なしのクッキーを設定

echo $_REQUEST['lat'];
echo '<br>';
echo $_REQUEST['lon'];
$lat=$_REQUEST['lat'];
$lon=$_REQUEST['lon'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>MAP</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-11 -->
</head>
<body>
	<?php
	
	if($visit == 1) {
		$_Id = mt_rand();
		setcookie('IDcookie', $_Id); // 有効期限なしのクッキーを設定
		$sql0=sprintf('select count(*) as cnt from mb_guest where id="%d"',mysql_real_escape_string($_Id));
		$rec=mysql_query($sql0)or die(mysql_error());
		$table=mysql_fetch_assoc($rec);
		if($table['cnt']==0){
			$sql1=sprintf('insert into mb_guest(id,views,lat,lon) values("%d","%d","%d","%d")',mysql_real_escape_string($_Id),mysql_real_escape_string($visit),mysql_real_escape_string($lat),mysql_real_escape_string($lon));
			$record=mysql_query($sql1)or die(mysql_error());
			//echo "初めての訪問ありがとうございます.<br />あなたのIDは".$_Id."です．";
		}
		else{
			echo "Error!";
		}
	}
	else 
	{
		$_Id = $_COOKIE['IDcookie'];
		$sql1=sprintf('update mb_guest set lat="%d",lon="%d",views="%d" where id="%d"',mysql_real_escape_string($lat),mysql_real_escape_string($lon),mysql_real_escape_string($visit),mysql_real_escape_string($_Id));
		$record=mysql_query($sql1)or die(mysql_error());
	 	//$table=mysql_fetch_assoc($record);

		//echo "ID:".$_Id."さん.<br />
		//今回で".$visit."回目の訪問になります";
	}
	
	if($_Id%2==0){
		$sql0="select (('".$lat."'-lat)*('".$lat."'-lat)+('".$lon."'-lon)*('".$lon."'-lon)) dis, name from mb_restaurant order by dis asc limit 0,5";

		$table=mysql_query($sql0)or die(mysql_error());
		while($data=mysql_fetch_assoc($table)){
			echo $data['name']."  ".$data['dis'];
			echo '<br/>';
		}
	}
	else{
		$sql0="select (('".$lat."'-lat)*('".$lat."'-lat)+('".$lon."'-lon)*('".$lon."'-lon)) dis,name,mb_fake_rest.id from mb_restaurant,mb_fake_rest where mb_fake_rest.rid=mb_restaurant.rid order by mb_fake_rest.id asc limit 0,5";
		$table=mysql_query($sql0)or die(mysql_error());
		while($data=mysql_fetch_assoc($table)){
			echo $data['name']."  ".$data['dis'];
			echo '<br/>';
		}
	}
	
	
	//data
	


	?>

</body>
</html>
