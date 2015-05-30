<?php
	//database server setting
	$db_host = "localhost";
	$db_name = "im_volleyball_team";
	$db_username = "root";
	$db_password = "1234";

	//setting data connection
	$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if(!$connect) die("data connecting fail!".mysql_error());
	mysqli_query($connect, "SET NAMES 'utf8'");
?>