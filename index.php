<?php
 require('dbconnect.php');
 $sql1=sprintf('select count(*) as cnt from mb_restaurant');
 $record=mysql_query($sql1)or die(mysql_error());
 $table=mysql_fetch_assoc($record);
 if($table['cnt']==0){
		echo '0!!';
	}
	else{
		echo 'Welcome!!';
	}
	
	echo '<br>';
	echo $showtime=date("d");
?>
<form action="test.php" method="post">
	<?php
		for ($i=0;$i<4;$i++){
			?><select name="<?php echo $i?>"><option value="1">1</option></select><?php
		}
	?>
	<input type="submit" value="ok"/>
</form>