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
  		  <thead ><tr>		    
		      <th class="center aligned">Date</th>
		      <th class="center aligned">Type</th>
		      <th class="center aligned">Competitor</th>
		      <th class="center aligned">Set</th>
		      <th class="center aligned">Gain</th>
		      <th class="center aligned">Loss</th>
		      <th class="center aligned">Win</th>
		      <th class="center aligned">Details</th>
		  </tr></thead>
		  <tbody >
			<?php
				$query_competition= "SELECT `Com_set_code`, `Date`, `competion_type`.`Type_name`, `Competitor`, `Set_num`, `My_point`, `Opn_point`, `Win` FROM `competition`, `competion_type` WHERE`competion_type`.`Type_code` = `competition`.`Type_code` ORDER BY `Date` DESC, `Set_num` ASC";
				$Competition = mysqli_query($connect, $query_competition);
				while($row_Competition = mysqli_fetch_row($Competition))
				{
					echo "<tr>";
					for($i = 1; $i < 8; $i++)
					{
						if($i == 7)
						{
							if($row_Competition[$i] == '1'){
							?>  <td class="center aligned">win</td>		<?php
							}if($row_Competition[$i] == '0'){
							?>  <td class="center aligned">loss</td>	<?php
							}
							continue;
						}
						echo "<td class='center aligned'>".$row_Competition[$i]."</td>";
					}
				    echo "<td class='center aligned'><a class='item' href='compDetail.php?comSetCode=".$row_Competition[0]."'><i class='content icon'></i></a></td>";	
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
</html>