<?php
	require('../../dbconnect.php');
	//$lat=$_POST['key1'];
	//$lon=$_POST['key2'];
	//$area=$_REQUEST['lat'];
	$lat=$_POST['tlat'];
	$lon=$_POST['tlon'];
	echo "GO!";
	echo $lat;
	echo '<br>';
	echo $lon;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<p>このデータは、サーバ上にあります。</p>
<ul>
    <li>key1： <?= htmlspecialchars($_POST['tlat'], ENT_QUOTES, 'UTF-8'); ?></li>
    <li>key2： <?= htmlspecialchars($_POST['tlon'], ENT_QUOTES, 'UTF-8'); ?></li>
</ul>

<?php
/*
	$sql0="select (('".$lat."'-lat)*('".$lat."'-lat)+('".$lon."'-lon)*('".$lon."'-lon)) dis, name from mb_restaurant order by dis asc";

	//$sql=sprintf('select ((34.71512535741886-lat)*(34.71512535741886-lat)+(135.2286013970435-lon)*(135.2286013970435-lon)) dis, name from mb_restaurant order by dis desc');
	//mysql_real_escape_string($lat),mysql_real_escape_string($lat),mysql_real_escape_string($lon),mysql_real_escape_string($lon)
	$table=mysql_query($sql0)or die(mysql_error());
	while($data=mysql_fetch_assoc($table)){
		echo $data['name']."  ".$data['dis'];
		echo '<br/>';
	}
	//echo mysql_real_escape_string($_POST['key1']);
	//echo '<br>';
	//echo $t;
	*/
?>
