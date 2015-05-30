<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();
	if(isset($_POST["action"]) && ($_POST["action"] == "save"))
	{
		if( ($_POST["date"] == "") || ($_POST["compType"]=="") || ($_POST["competitor"]=="") || ($_POST["setNum"]==0) || ($_POST["gain"]=="") || ($_POST["loss"]==""))
			header("Location: manager_home.php?errMsg=1"); 
		else
		{
			if($_POST["gain"] > $_POST["loss"])
				$win = 1;
			else
				$win = 0;

			$query_insert = "INSERT INTO `competition`(`Date`, `Type_code`, `Competitor`, `Set_num`, `My_point`, `Opn_point`, `Win`) VALUES (";
			$query_insert .= "'".$_POST["date"]."',";
			$query_insert .= "'".$_POST["compType"]."',";
			$query_insert .= "'".$_POST["competitor"]."',";
			$query_insert .= "'".$_POST["setNum"]."',";
			$query_insert .= "'".$_POST["gain"]."',";
			$query_insert .= "'".$_POST["loss"]."',";
			$query_insert .= "'".$win."')";
			mysqli_query($connect, $query_insert);
			header("Location: competition.php");
		}		
	}
?>
<!DOCTYPE HTML>
	<html lang = "zh-TW">
	<head>
		<meta charest = "utf-8">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.7.3/semantic.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="//cdnjs.com/libraries/jquery-timepicker"></script>
		<link rel="stylesheet" type="text/css" href="/Semantic-UI-1.7.3/dist/semantic.min.css">
		<script src="/Semantic-UI-1.7.3/dist/semantic.min.js"></script>
  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 		<script>
  		$(function() {
    		$( "#datepicker" ).datepicker({
  				dateFormat: "yy-mm-dd",
			});			
		});		
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
    	<div class="ui small header" style="text-align: right">Hi, <?php echo "&nbsp".$_SESSION['account']."!"."&nbsp"."&nbsp"."&nbsp"; ?> 
    		How's your day today? <?php echo "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"; ?>
    	 	<a class="item" href="editProfile.php"><i class="large write square icon"></i></a>
    	</div>
		<div class="ui divider"></div>
		<div class="ui secondary pointing teal menu">
		  <div class="left menu">
		  	<a class="active item"><i class="plus icon"></i> Add Competition Record</a>
		  	<a class="item" href="memberlist.php"><i class="users icon"></i> Team Members</a>
		  	<a class="item" href="competition.php"><i class="trophy icon"></i> Competition Records</a>
		  </div>
		  <div class="right menu">
            <a class="item" href="logout.php"><i class="sign out icon"></i> Log out</a>
		  </div>
		</div>
		<div class="ui one column relaxed fitted stackable grid center aligned" style="margin-top: 1cm; margin-bottom: 2cm; text-align: left" >
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
		      <div class="field"><label style="text-align: left">Date</label>
		        <div class="ui left icon input"><input name="date" type="text" id="datepicker" placeholder="Date"><i class="calendar icon"></i>
		        </div>
		      </div>
		      <div class="field"><label style="text-align: left">Competition Type</label>
		        <select name="compType">
		        	<option>choose a competition type</option>
		        	<option value="1">女排新生盃</option>
		        	<option value="2">女排校長盃</option>
		        	<option value="3">女排台大盃</option>
		        	<option value="4">女排大資盃</option>
		        	<option value="5">女排北資盃</option>
		        	<option value="6">女排資管盃</option>
		        	<option value="7">女排千隊之王</option>
		        	<option value="21">男排新生盃</option>
		        	<option value="22">男排校長盃</option>
		        	<option value="23">男排台大盃</option>
		        	<option value="24">男排大資盃</option>
		        	<option value="25">男排北資盃</option>
		        	<option value="26">男排資管盃</option>
		        	<option value="27">男排千隊之王</option>
		        </select>
		      </div>
		      <div class="field">
		        <label style="text-align: left">Competitor</label>
		        <div class="ui left icon input"><input type="text" name="competitor" placeholder="who..."><i class="users icon"></i>
		        </div>
		      </div>
		      <div class="field"><label style="text-align: left">Set Number</label>
		        <select name="setNum">
		        	<option>choose a set number</option>
		        	<option value="1">1</option>
		        	<option value="2">2</option>
		        	<option value="3">3</option>
		        </select>
		      </div>
		      <div class="two fields">
			  	<div class="field"><label style="text-align: left">Gain</label>
			  	  <input type="number" name="gain" min="1" max="25">
			  	</div>
			  	<div class="field"><label style="text-align: left">Loss</label>
			  	  <input type="number" name="loss" min="1" max="25">
			  	</div>
			  </div>
			  <div class="ui buttons">
			      <input name="action" type="hidden" id="action" value="save">
				  <input type="submit" class="ui red basic button" name="submit" value="Save">
				  <div class="or"></div>
				  <input type="reset" name="submit2" class="ui teal basic button" value="reset">
			  </div>
		    </form>
		  </div>
		  
		</div>
	</div>
	</div>
    </div>
</body>
</html>