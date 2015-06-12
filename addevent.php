<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

	$holder = mysqli_escape_string($connect, $_SESSION["userName"]);

/*	if($_FILES["pic"]["temp_name"]!="")
	{
		if(move_uploaded_file($_FILES["fileUpload"]["temp_name"], "./".$_FILES["fileUpload"]["name"]))
		{

		}
		else
			echo "<a href='javascript:window.history.back();'>回到上一頁</a>";
	}
*/
	if(isset($_POST["action"]) && ($_POST["action"] == "save"))
	{
		if( ($_POST["conname"]=="") ||($_POST["conid"]=="") ||($_POST["descp"]=="") ||($_POST["date"]=="") || ($_POST["time"]=="") || ($_POST["place"]=="") || ($_POST["seat"]==""))
			header("Location: addevent.php?errMsg=1"); 
		else
		{
			$query_insert = "INSERT INTO `concert`(`Concert_name`,`Concert_id`,`Name`,`Description`,`Date`,`Time`,`Place`) VALUES (";
			$query_insert .= "'".$_POST["conname"]."',";
			$query_insert .= "'".$_POST["conid"]."',";
			$query_insert .= "'".$holder."',";
			$query_insert .= "'".$_POST["descp"]."',";
			$query_insert .= "'".$_POST["date"]."',";
			$query_insert .= "'".$_POST["time"]."',";
			$query_insert .= "'".$_POST["place"]."')";
			mysqli_query($connect, $query_insert);
			header("Location: manage_activity.php");
		}		
	}


?>


