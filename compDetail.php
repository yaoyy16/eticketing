<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();
?>
<!DOCTYPE HTML>
	<html lang = "zh-TW">
	<head>
		<meta charest = "utf-8">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.7.3/semantic.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="//cdnjs.com/libraries/jquery-timepicker">
  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
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
    	<div class="ui small header" style="text-align: right">Hi, <?php echo "&nbsp".$_SESSION['account']."!"."&nbsp"."&nbsp"."&nbsp"; ?> How's your day today? <?php echo "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"; ?>
    	 	<a class="item" href="editProfile.php"><i class="large write square icon"></i></a>
    	</div>
		<div class="ui divider"></div>
		<div class="ui secondary pointing teal menu">
		  <div class="left menu">
		  	<?php if($_SESSION["memberType"] == "0") {?>
		  			<a class="item" href="captain_home.php"><i class="plus icon"></i>Add Practice Date</a>
		  			<a class="item" href="captain_attendance.php"><i class="check circle icon"></i> Attendance</a>		  			
		  	<?php }elseif($_SESSION["memberType"] == "1") {?>
		  			<a class="item" href="manager_home.php"><i class="plus icon"></i>Add Competition Record</a>
		  	<?php }elseif($_SESSION["memberType"] == "2") {?>
		  			<a class="item" href="member_home.php"><i class="check circle icon"></i> Attendance</a>
		  	<?php }?>
		  	<a class="item" href="memberlist.php"><i class="users icon"></i> Team Members</a>
		  	<a class="active item"><i class="trophy icon"></i> Competition Records</a>
		  </div>
		  <div class="right menu">
            <a class="item" href="logout.php"><i class="sign out icon"></i> Log out</a>
		  </div>
		</div>
		<div class="ui one column relaxed fitted stackable grid center aligned" style="margin-top: 1cm; margin-bottom: 2cm;">

		<div class="fourteen wide column">
		<table class="ui table">
  		  <thead >
  		    <tr>		    
		      <th class="center aligned" rowspan="2">背號</th>
		      <th class="center aligned" rowspan="2">名字</th>
		      <th class="center aligned" rowspan="2">接失</th>
		      <th class="center aligned" rowspan="2">舉失</th>
		      <th class="center aligned" colspan="3">發球</th>
		      <th class="center aligned" colspan="3">攻擊</th>
		      <th class="center aligned" colspan="3">攔網</th>
		    </tr>
		    <tr>
		      <th class="center aligned">#</th><th class="center aligned">得</th><th class="center aligned">失</th>
		      <th class="center aligned">#</th><th class="center aligned">得</th><th class="center aligned">失</th>
		      <th class="center aligned">#</th><th class="center aligned">得</th><th class="center aligned">失</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php 
		  	$query_com_set = "SELECT `competition`.`Com_set_code`, `player`.`Number`, `player`.`Name`, `pass_fail`.`loss`,`set_fail`.`loss`,  `serve`.`times`, `serve`.`gain`, `serve`.`loss`, `attack`.`times`, `attack`.`gain`, `attack`.`loss`, `block`.`times`, `block`.`gain`, `block`.`loss` 
		  	FROM `player`, `serve`, `pass_fail`, `set_fail`, `attack`, `block`, `competition` WHERE (`competition`.`Com_set_code` = '".$_GET["comSetCode"]."') AND ((`competition`.`Com_set_code` = `serve`.`Com_set_code`) AND (`competition`.`Com_set_code` = `pass_fail`.`Com_set_code`) AND (`competition`.`Com_set_code` = `set_fail`.`Com_set_code`) AND (`competition`.`Com_set_code` = `attack`.`Com_set_code`) AND (`competition`.`Com_set_code` = `block`.`Com_set_code`) AND (`player`.`Account` = `serve`.`Account`) AND (`player`.`Account` = `pass_fail`.`Account`) AND (`player`.`Account` = `set_fail`.`Account`) AND (`player`.`Account` = `attack`.`Account`) AND (`player`.`Account` = `block`.`Account`)) ORDER BY `player`.`Number` ASC";
			$Com_set = mysqli_query($connect, $query_com_set);
			while($row_Com_set = mysqli_fetch_row($Com_set))
			{
				echo "<tr>";
				for($i = 1; $i < 14; $i++)
					echo "<td class='center aligned'>".$row_Com_set[$i]."</td>";
				echo "</tr>";
			}
		  ?>			
		  </tbody>
		</table>
		<div class="ui tiny basic button" onclick="window.history.back()">
  			<i class="arrow circle left icon"></i>Back
		</div>
		</div>
		</div>
	</div>
	</div>
    </div>
</body>
</html>