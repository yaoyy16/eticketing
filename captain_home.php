<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

	if(isset($_POST["action"]) && ($_POST["action"] == "save"))
	{
		if( ($_POST["date"]=="") || ($_POST["time"]=="") || ($_POST["gender"]=="") || ($_POST["place"]==""))
			header("Location: captain_home.php?errMsg=1"); 
		else
		{
			$query_insert = "INSERT INTO `practice_date`(`Date`, `Time`, `Gender`,`Place`) VALUES (";
			$query_insert .= "'".$_POST["date"]."',";
			$query_insert .= "'".$_POST["time"]."',";
			$query_insert .= "'".$_POST["gender"]."',";
			$query_insert .= "'".$_POST["place"]."')";
			mysqli_query($connect, $query_insert);
			header("Location: captain_attendance.php");
		}		
	}
?>

<!DOCTYPE HTML>
	<html lang = "zh-TW">
	<head>
		<meta charest = "utf-8">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.7.3/semantic.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/components/dropdown.js">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="//cdnjs.com/libraries/jquery-timepicker"></script>
  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 		<script>
  		$(function() {
    		$( "#datepicker" ).datepicker({
  				dateFormat: "yy-mm-dd",
			});			
		});	
		$('.ui.dropdown')
  			.dropdown()
		;	
		</script>
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
 			<a class='item' href='editProfile.php'><i class='large write square icon'></i></a>
    	</div>
		<div class="ui divider"></div>
		<div class="ui secondary pointing teal menu">
		  <div class="left menu">
		  	<a class="active item"><i class="plus icon"></i>Add Practice Date</a>
		  	<a class="item" href="captain_attendance.php"><i class="check circle icon"></i> Attendance</a>
		  	<a class="item" href="memberlist.php"><i class="users icon"></i> Team Members</a>
		  	<a class="item" href="competition.php"><i class="trophy icon"></i> Competition Records</a>
		  </div>
		  <div class="right menu">
            <a class="item" href="logout.php"><i class="sign out icon"></i> Log out</a>
		  </div>
		</div>
		<div class="ui one column relaxed fitted stackable grid center aligned" style="margin-top: 1cm;margin-bottom: 2cm; text-align: left" >
		  <div class="six wide column" >
<?php 	if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
		{  ?>
		    <div class="ui warning message" style="text-align: left">
			    <div class="header">Please check something!</div>
				    <ul class="list">
				    <li>You might forget to enter some fields.</li>
				    <li>Please enter again.</li>
				    </ul>
		    </div>  <?php 
		} 
?>
		    <form class="ui form segment" name="practiceAdd" method="post" action="">
		      <div class="grouped inline fields">
        		  <div class="field">	
        			<input type="radio" name="gender" value="M" ><label><i class="big male icon"></i></label>
        		  </div>
        		  <div class="field">
        			<input type="radio" name="gender" value="F"><label><i class="big female icon"></i></label>
        		  </div>
    		  </div>
		      <div class="field"><label style="text-align: left">Date</label>
		        <div class="ui left icon input"><input name="date" type="text" id="datepicker" placeholder="Date"><i class="calendar icon"></i>
		        </div>
		      </div>
		      <div class="field"><label style="text-align: left">Time</label>
		        <select name="time">
		        	<option value="08:00 am">08:00 am</option>
		        	<option value="08:30 am">08:30 am</option>
		        	<option value="09:00 am">09:00 am</option>
		        	<option value="06:00 pm">06:00 pm</option>
		        	<option value="06:30 pm">06:30 pm</option>
		        	<option value="07:00 pm">07:00 pm</option>
		        </select>
		       </div>
		      <div class="field"><label style="text-align: left">Place</label>
		        <div class="ui left icon input"><input type="text" name="place" placeholder="where..."><i class="marker icon"></i>
		        </div>
		      </div>
		      <input name="action" type="hidden" id="action" value="save">
			  <input type="submit" class="ui teal basic button" name="submit" value="Save">
		    </form>
		  </div>
		</div>
	</div>
	</div>
    </div>
</body>
</html>