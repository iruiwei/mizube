<?php
session_start();
require('dbconnect.php');

if(!empty($_POST)){
	if($_POST['id']=='')
		$isblank['id']='blank';
	if($_POST['name']=='')
		$isblank['name']='blank';
	$_SESSION['result']=$_POST;
	header('location:result.php');
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>search_store</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-09-20 -->
</head>
<body>
	
	<form action="" method="post" enctype="multipart/form-data">
		ID<input type="text" name="id" size="10" value="<?php echo htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8')?>"/><br>
		Name<input type="text" name="name" size="10" maxlength="50" value="<?php echo htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8')?>"/><br>
		<input type="submit" value="ok"/><br>
	</form>
	<br>
	<?php
	$count=1;
	$sql=sprintf('select * from mb_restaurant order by view desc');
	$record=mysql_query($sql)or die(mysql_error());
	while($data=mysql_fetch_assoc($record)){
		echo "rank". $count;
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
		$count++;
	}
	?>

</body>
</html>
