<?php
session_start();
require('dbconnect.php');
$tag=$_REQUEST['tag'];
/*
if(!isset($_SESSION['a_result'])){
	header('location:search_ship.php');
	exit();
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>tag_result</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-02 -->
</head>
<body>
	<?php
		
		$sql=sprintf('select 
						mb_tag.tag_name,
						mb_restaurant.name,
						mb_restaurant.lon,
						mb_restaurant.lat,
						mb_restaurant.view,
						mb_restaurant.menu,
						mb_restaurant.comment 
					from 
						mb_tag,
						mb_rest_tag,
						mb_restaurant 
					where 
						mb_restaurant.rid=mb_rest_tag.rid 
					and 
						mb_rest_tag.tid=mb_tag.tag_id 
					and 
						mb_tag.tag_id="%d"',
				mysql_real_escape_string($tag));
		$record=mysql_query($sql)or die(mysql_error());
		while($data=mysql_fetch_assoc($record)){
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
			echo '<br/>';
		}
	?>

</body>
</html>
