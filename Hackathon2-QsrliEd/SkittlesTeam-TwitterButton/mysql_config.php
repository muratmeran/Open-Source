<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'skittles';
	
	$connect = mysql_connect($dbhost, $dbuser, $dbpass);
	$select = mysql_select_db($dbname, $connect);

?>