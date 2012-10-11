<?php
session_start();
require('dbconnect.php');
if(!isset($_POST['name'])){
	header('location:rest_search.php');
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
	//$rId=$_SESSION['result']['id'];
	$rName=$_POST['name'];
	if ($rName!=''){
		$sql0=sprintf('select count(*) as cnt from mb_restaurant where name like "%s"',"%".mysql_real_escape_string($rName)."%");
		$record0=mysql_query($sql0)or die(mysql_error());
 		$table0=mysql_fetch_assoc($record0);
 		if($table0['cnt']==0){
			echo 'No result!';
		}
		else{
			echo $table0['cnt'] ." results";
			echo '<br />';
			
			$sql2=sprintf('select * from mb_restaurant where name like "%s"',"%".mysql_real_escape_string($rName)."%");
			$recordset=mysql_query($sql2)or die(mysql_error());
			while($data=mysql_fetch_assoc($recordset)){
				echo $data['rid'];
				echo " ";
				echo $data['name'];
				echo " ";
				echo $data['lon'];
				echo " ";
				echo $data['lat'];
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
	}
	else{
		echo "No result";
	}
?>

</body>
</html>
