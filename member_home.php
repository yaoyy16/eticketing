<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

	$gen = mysqli_escape_string($connect, $_SESSION["memberGender"]);
	$acc = mysqli_escape_string($connect, $_SESSION["account"]);
	
	if( isset($_POST["action"]))// && ( ($_POST["action"]== 'attend') || ($_POST["action"] == 'absent') ) 
	{
		if(($_POST["action"]) == "attend")
		{			
			$query_attend ="INSERT INTO `attendance`(`Account`, `Date_code`, `attend`) VALUES ('".$acc."','".$_POST["dateCode"]."','1')";
			$result = mysqli_query($connect, $query_attend);
			
			//馬上算更新人數總和
			$query_NumOfAttend ="SELECT COUNT(*) FROM `attendance` WHERE `Date_code` = '".$_POST["dateCode"]."' AND `attend` = '1' ";
			$NumOfAttend = mysqli_query($connect, $query_NumOfAttend);
			$row_NumOfAttend = mysql_fetch_array($NumOfAttend);
			echo $row_NumOfAttend[0];

			//更新當天的練球人數
			$query_storeNum = "UPDATE `practice_date` SET `Num_of_people`='$row_NumOfAttend[0]' WHERE `Date_code` = '".$_POST["dateCode"]."'";
			$sotreNum = mysqli_query($connect, $query_storeNum);
		}
		if($_POST["action"] == "absent")
		{
			$query_attend ="INSERT INTO `attendance`(`Account`, `Date_code`, `attend`) VALUES ('".$acc."','".$_POST["dateCode"]."','0')";
			mysqli_query($connect, $query_attend);
		}		
		header("Location: member_home.php");
	}						
?>
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
    	<div class="ui small header" style="text-align: right">Hi, <?php echo "&nbsp".$_SESSION['account']."!"."&nbsp"."&nbsp"."&nbsp"; ?> How's your day today? <?php echo "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"; ?>
    	 	<a class="item" href="editProfile.php"><i class="large write square icon"></i></a>
    	</div>
		<div class="ui divider"></div>
		<div class="ui secondary pointing teal menu">
		  <div class="left menu">
		  	<a class="active item" href="member_home.php"><i class="check circle icon"></i>Attendance</a>
		  	<a class="item" href="memberlist.php"><i class="users icon"></i> Team Members</a>
		  	<a class="item" href="competition.php"><i class="trophy icon"></i> Competition Records</a>
		  </div>
		  <div class="right menu">
           	<a class="item" href="logout.php"><i class="sign out icon"></i> Log out</a>
		  </div>
		</div>
		<div class="ui one column relaxed fitted stackable grid center aligned" style="margin-top: 1cm; margin-bottom: 2cm;">
		<div class="fourteen wide column">
		<table class="ui table">
  		  <thead ><tr>		    
		      <th class="three wide center aligned">Date</th>
		      <th class="two wide center aligned">Time</th>
		      <th class="two wide center aligned">Place</th>
		      <th class="three wide center aligned"># of Attendance</th>
		      <th class="center aligned">Attend</th>
		  </tr></thead>
		  <tbody >
			<?php				
				$query_attendance = "SELECT `Date_code`, `Date`, `Time`, `Place`, `Num_of_people`FROM `practice_date` WHERE `Gender` = '$gen' ORDER BY `Date` DESC";
				$Attendance = mysqli_query($connect, $query_attendance);

				while($row_Attendance = mysqli_fetch_array($Attendance))
				{
					$query_attend ="SELECT `attend` FROM `attendance` WHERE (`Account` = '".$_SESSION["account"]."') AND (`Date_code` = '$row_Attendance[0]')";
					$Attend= mysqli_query($connect, $query_attend);
					$row_Attend = mysqli_fetch_array($Attend);
					$query_NumOfAttend ="SELECT COUNT(*) FROM `attendance` WHERE `Date_code` = '$row_Attendance[0]' AND `attend` = '1' ";
					$NumOfAttend = mysqli_query($connect, $query_NumOfAttend);

					//最新一次還沒推到過
					if(($row_Attend[0] != "0") && ($row_Attend[0] != "1"))
					{
						echo "<tr>";
						for($i = 1; $i < 6; $i++)
						{						
							if($i == 5)
							{	?>
								<td class="center aligned"><form name="attendform" method="post" action="">	
									<div class="ui small buttons">
									  <input name="dateCode" type="hidden" value="<?php echo $row_Attendance[0];?>">
	  								  <input type="submit" name="action" class="ui blue basic button" value="attend">
	  							      <div class="or"></div>
	  								   <input type="submit" name="action" class="ui yellow basic button" value="absent">
									</div>			
								</form></td>				
					<?php		continue;
							}
							if($i ==4)
							{						
								$row_NumOfAttend = mysqli_fetch_array($NumOfAttend);
								echo "<td class='center aligned'>".$row_NumOfAttend[0]."</td>";
								continue;
							}
							else
								echo "<td class='center aligned'>".$row_Attendance[$i]."</td>";
						}
						echo "</tr>";
					}
					else
					{
						echo "<tr>";
						for($i = 1; $i < 6; $i++)
						{
							if($i == 5)
							{
								if($row_Attend[0] == 1)
									echo "<td class='center aligned'>Attend</td>";
								if($row_Attend[0] == 0)
									echo "<td class='center aligned'>Absent</td>";
								continue;
							}
							if($i ==4)
							{											
								$row_NumOfAttend = mysqli_fetch_array($NumOfAttend);
								echo "<td class='center aligned'>".$row_NumOfAttend[0]."</td>";
								continue;
							}
							echo "<td class='center aligned'>".$row_Attendance[$i]."</td>";
						}
						echo "</tr>";
					}					
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