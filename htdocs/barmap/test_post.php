<?php
	require('../../dbconnect.php');
	$lat=$_POST['key1'];
	$lon=$_POST['key2'];
?>
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
	
?>
