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
?>
hello world!!!!!
mogamigawa