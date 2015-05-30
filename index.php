<!DOCTYPE HTML>
	<html lang = "zh-TW">
	<head>
		<meta charest = "utf-8">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.7.3/semantic.css">
		<title>IM Volleyball Team System</title>
	</head>
	<body style="background-image: url('rockywall.png');">
	<div class="ui one column stackable page grid center aligned">
    <div class="column sixteen wide">
    <div class="ui segment" style=" margin-top: 2cm;"> 
		<h1 class="ui left aligned teal header" >
  			<div class="content">
    			IM Volleyball Team System
    		<div class="sub header">Play volleyball until the end of the world</div>
  			</div>
		</h1>
		<div class="ui section divider"></div>
		<div class="ui one column relaxed fitted stackable grid center aligned" style="margin-bottom: 2cm;" >
		  <div class="six wide column" >
<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

	// 1. check have login or not
	if(isset($_SESSION["account"]) && ($_SESSION["account"] != ""))
	{
		if($_SESSION["memberType"] == "0") //captain & vise captain
			header("Location: captain_home.php");
		elseif($_SESSION["memberType"] == "1") //mamager
			header("Location: manager_home.php");
		else
			header("Location: member_home.php");
	}

	// 2. execute member login
	if(isset($_POST["account"]) && isset($_POST["passwd"]) && $_POST["account"] != "")
	{
		//connecting member data
		$query_RecLogin = "SELECT * FROM `player` WHERE `Account` = '".$_POST["account"]."'";
		$RecLogin = mysqli_query($connect, $query_RecLogin);

		//retrieve account & passwd value
		$row_RecLogin = mysqli_fetch_assoc($RecLogin);
		$acc = $row_RecLogin["Account"];
		$pwd = $row_RecLogin["Password"];
		$type = $row_RecLogin["Type"];
		$gender = $row_RecLogin["Gender"];
		//compare password, if login successfully then to login state
		if($_POST["passwd"] == $pwd)
		{
			//setting username and type
			$_SESSION["account"] = $acc;
			$_SESSION["memberType"] = $type;
			$_SESSION["memberGender"] = $gender;

			if($_SESSION["memberType"] == "0") //captain & vise captain
				header("Location: captain_home.php");

			elseif($_SESSION["memberType"] == "1") //mamager
				header("Location: manager_home.php");
			else
				header("Location: member_home.php");
		}
		else
			header("Location: index.php?errMsg=1");
	}
	//not login yet page
		if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
		{  ?>
		    <div class="ui warning message" style="text-align: left">
			    <div class="header">Could you check something!</div>
				    <ul class="list">
				    <li>You might enter the wrong account or password.</li>
				    <li>Please enter again.</li>
				    </ul>
		    </div>
  <?php } ?>
		    <form class="ui form segment" name="loginForm" method="post" action="">
		      <div class="field">
		        <label style="text-align: left">Account</label>
		        <div class="ui left icon input"><input name="account" type="text" placeholder="account"><i class="user icon"></i>
		        </div>
		      </div>
		      <div class="field">
		        <label style="text-align: left">Password</label>
		        <div class="ui left icon input"><input name="passwd" type="password" placeholder="password"><i class="lock icon"></i>
		        </div>
		      </div>
		      <div class="ui buttons">
			    <input type="submit" name="submit" class="ui blue basic button" value="Login">
			    <div class="or"></div>
			    <a href="register.php" class="ui yellow basic button">Sign up</a>
			  </div>
		    </form>
		  </div>
	</div>
	</div>
    </div>
	</body>
	</html>
