<?php
session_start();
require('dbconnect.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>search_area</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="SHEN RUIWEI">
	<!-- Date: 2012-10-05 -->
</head>
<body>
	<?php
		echo "エリア";
		echo '<br/>';
		$sql0=sprintf('select mb_area.id,mb_area.name from mb_area');
		$recordset0=mysql_query($sql0)or die(mysql_error());
		?>
		<table border="1">
		<?php
		while($data0=mysql_fetch_assoc($recordset0)){
		?>
		<tr>
			<td><a href="area.php?area=<?php echo $data0['id'];?>"><?php echo $data0['name'];?></a></td>
		</tr>
		<?php
		}
		?>
		</table>

</body>
</html>
