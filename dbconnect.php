<?php
mysql_connect('localhost','root','root') or die(mysql_error());
mysql_select_db('database_name') or die(mysql_error());
mysql_query('SET NAMES UTF8');
?>