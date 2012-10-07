<?php
	require('../../dbconnect.php');
	$lat=$_POST['key1'];
	$lon=$_POST['key2'];
	//$area=$_REQUEST['lat'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<p>このデータは、サーバ上にあります。</p>
<ul>
    <li>key1： <?= htmlspecialchars($_POST['key1'], ENT_QUOTES, 'UTF-8'); ?></li>
    <li>key2： <?= htmlspecialchars($_POST['key2'], ENT_QUOTES, 'UTF-8'); ?></li>
</ul>

<?php

	
	$sql=sprintf('select ((%d-lat)*(%d-lat)+(%d-lon)*(%d-lon)) dis, name from mb_restaurant order by dis asc',mysql_real_escape_string($lat),mysql_real_escape_string($lat),mysql_real_escape_string($lon),mysql_real_escape_string($lon));
	$table=mysql_query($sql)or die(mysql_error());
	while($data=mysql_fetch_assoc($table)){
		echo $data['name']."  ".$data['dis'];
		echo '<br/>';
	}
	
	
	echo "data!";
	echo $area;
	
?>
