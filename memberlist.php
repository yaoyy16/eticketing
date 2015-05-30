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
		  	<a class="active item" href="memberlist.php"><i class="users icon"></i> Team Members</a>
		  	<a class="item" href="competition.php"><i class="trophy icon"></i> Competition Records</a>
		  </div>
		  <div class="right menu">
            <a class="item" href="logout.php"><i class="sign out icon"></i> Log out</a>
		  </div>
		</div>
		<div class="ui one column relaxed fitted stackable grid center aligned" style="margin-top: 1cm; margin-bottom: 2cm;">
		<div class="fourteen wide column">
		<h2 class="ui orange medium header">
		  <i class="female icon"></i><div class="content">女排</div>
		</h2>
		<table class="ui table">
  		  <thead ><tr>		    
		      <th class="center aligned">Number</th>
		      <th class="center aligned">Name</th>
		      <th class="center aligned">Account</th>
		      <th class="center aligned">StudentID</th>
		      <th class="center aligned">Position</th>
		      <th class="center aligned">Attend Count</th>
		      <th class="center aligned">Gender</th>
		  </tr></thead>
		  <tbody >
			<?php
				
				$query_memberList= "SELECT `player`.`Number`, `player`.`Name`,`player`.`Account`,`player`.`Student_id`, `position`.`Position`, SUM(`attend`), `player`.`Gender` FROM player, position, attendance WHERE `player`.`Pos_code` = `position`.`Pos_code` AND `attendance`.`Account` = `player`.`Account` AND `player`.`Gender` = 'F' AND `player`.`Number` < '30' GROUP BY `Account` ORDER BY `player`.`Number` ASC";

				$Memberlist = mysqli_query($connect, $query_memberList);
				while($row_Memberlist= mysqli_fetch_row($Memberlist))
				{
					echo "<tr>";
					for($i = 0; $i < 7; $i++)
						echo "<td class='center aligned'>".$row_Memberlist[$i]."</td>";
					echo "</tr>";
				}
			?>
		  </tbody>
		</table>

		<h2 class="ui blue medium header">
		  <i class="male icon"></i><div class="content">男排</div>
		</h2>
		<table class="ui table">
  		  <thead ><tr>		    
		      <th class="center aligned">Number</th>
		      <th class="center aligned">Name</th>
		      <th class="center aligned">Account</th>
		      <th class="center aligned">StudentID</th>
		      <th class="center aligned">Position</th>
		      <th class="center aligned">Attend Count</th>
		      <th class="center aligned">Gender</th>
		  </tr></thead>
		  <tbody>
			<?php				
				$query_memberList= "SELECT `player`.`Number`, `player`.`Name`,`player`.`Account`,`player`.`Student_id`, `position`.`Position`, SUM(`attend`), `player`.`Gender` FROM player, position, attendance WHERE `player`.`Pos_code` = `position`.`Pos_code` AND `attendance`.`Account` = `player`.`Account` AND `player`.`Gender` = 'M' AND `player`.`Number` < '30' GROUP BY `Account` ORDER BY `player`.`Number` ASC";

				$Memberlist = mysqli_query($connect, $query_memberList);
				while($row_Memberlist= mysqli_fetch_row($Memberlist))
				{
					echo "<tr>";
					for($i = 0; $i < 7; $i++)
						echo "<td class='center aligned'>".$row_Memberlist[$i]."</td>";
					echo "</tr>";
				}
			?>
		  </tbody>
		</table>						  
		</div>
		</div>
	</div>
	</div>
    </div>
</body>
<script src="dropdown.js"></script>
<script src="semantic.min.js"></script>
<script src="semantic.js"></script>
</html>