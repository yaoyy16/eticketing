<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");

	if(isset($_POST["action"]) && ($_POST["action"]) == "register")
	{
		if( ($_POST["account"] == "") || ($_POST["passwd"]=="") || ($_POST["s_id"]=="") || ($_POST["cname"]=="") || ($_POST["number"]=="") || ($_POST["pos"]=="")|| ($_POST["gender"]==""))
			header("Location: register.php?errMsg=1"); 
		else
		{
			//check registered before or not
			$query_RecFindUser = "SELECT `Account` FROM `player` WHERE `Account` = '".$_POST["account"]."'";
			$RecFindUser = mysqli_query($query_RecFindUser);
			if(mysqli_num_rows($RecFindUser) > 0)
			{
				header("Location: register.php?errMsg=1&account=".$_POST["account"]);	
			}
			else
			{
				$query_insert = "INSERT INTO `player`(`Account`, `Password`, `Student_id`, `Name`, `Number`, `Pos_code`, `Gender`) VALUES (";
				$query_insert .="'".$_POST["account"]."',";
				$query_insert .="'".$_POST["passwd"]."',";
				$query_insert .="'".$_POST["s_id"]."',";
				$query_insert .="'".$_POST["cname"]."',";
				$query_insert .="'".$_POST["number"]."',";
				$query_insert .="'".$_POST["pos"]."',";
				$query_insert .="'".$_POST["gender"]."')";
				mysqli_query($connect, $query_insert);
				header("Location: register.php?loginStats=1");
			}
		}		
	}
?>
<!DOCTYPE HTML>
	<html lang = "zh-TW">
	<head>
		<meta charest = "utf-8">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.7.3/semantic.css">
			<script language = "javascript">
			function checkform()
			{
				if(document.formReg.account.value=="")
				{
					alert("Please enter your Account!!");
					document.formReg.account.focus();
					return false;
				}
				else
				{
					uid = document.formReg.account.value;
					if(uid.length > 15)
					{
						alert("Account length must be less than 15 !!");
						document.formReg.account.focus();
						return false;
					}
					for(idx = 0; idx < uid.length; idx++)
					{
						if(!(( uid.charAt(idx) >= 'a'&& uid.charAt(idx) <= 'z') || (uid.charAt(idx) >= '0' && uid.charAt(idx) <= '9')))
						{
							alert("You can only use number and english characters !!");
							document.formReg.account.focus();
							return false;
						}
					}
					
				}
				if(!check_passwd(document.fromReg.passwd.value,document.formReg.passwdrecheck.value))
				{
					document.formReg.passwd.focus();
					return false;
				}
				
				if(document.formReg.account.value=="")
				{
					alert("Please enter your Account!!");
					document.formReg.account.focus();
					return false;
				}
				else
				{
					uuid = document.formReg.s_id.value;
					if(uuid.length != 9)
					{
						alert("Student ID length must be 9 !!");
						document.formReg.s_id.focus();
						return false;
					}
					if(!(uuid.charAt(0) >= 'a' && uuid.charAt(0) <= 'z'))
					{
						alert("Student ID must start with lowercase character !!");
						document.formReg.s_id.focus();
						return false;
					}
					for(idx = 1; idx < uuid.length; idx++)
					{
						if(!(uuid.charAt(idx) >= '0' && uuid.charAt(idx) <= '9'))
						{
							alert("Mind your student ID syntax !!");
							document.formReg.s_id.focus();
							return false;
						}
					}
				}			
				if(document.formReg.name.value=="")
				{
					alert("Enter your name!! ");
					return false;
				}
				<?php
				$query_RecFindNum = "SELECT 'Number' FROM player WHERE 'Number' = '".$_POST[number]."'";
				$RecFindNum = mysqli_query($query_RecFindNum);
				if(mysqli_num_rows($RecFindNum) > 0)
				{?>
					alert("Number invalid. Choose another one !!");
					return false;
				<?php }?>
				if(document.formReg.pos.value=="")
				{
					alert("Enter your position!! ");
					return false;
				}
				if(document.formReg.gender.value=="")
				{
					alert("Enter your gender!! ");
					return false;
				}
				return confirm('Sure to hand out your application form?');
			}

			function check_passwd(pw1,pw2){
				if(pw1==''){
					alert("You must enter password !!");
					return false;
				}
				for(var idx=0;idx<pw1.length;idx++){
					if(pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"'){
						alert("Blanks and quotation mraks are unavailable !!\n");
						return false;
					}
					if(pw1.length>20){
						alert( "password length must be less than 20 !!\n" );
						return false;
					}
					if(pw1!= pw2){
						alert("You must enter the same password twice !!\n");
						return false;
					}
				}
				return true;
			}
			</script>
		<title>IM Volleyball Team System</title>		
	</head>
	<body style="background-image: url('rockywall.png');">
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"] == "1"))
	  {  ?>
	  	<script language="javascript">
			alert("Successfully applied !!");	  
			location.href="index.php";
		</script>
<?php   
	  }
?>
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
		<div class="ui one column relaxed fitted stackable grid center aligned" style="margin-bottom: 2cm;">
		  <div class="twelve wide column" >
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
		    <form class="ui form segment" name="signUpForm" id="formReg" onsubmit="return checkform();" method="post" action="">
		      <div class="two fields">
			    <div class="field"><label style="text-align: left">Account</label>
			      <input type="text" name="account" placeholder="account">
	            </div>
		        <div class="field"><label style="text-align: left">Password</label>
		          <input type="password" name="passwd" placeholder="password">
		        </div>
		      </div>
		      <div class="two fields">
			    <div class="field"><label style="text-align: left">Name</label>
			      <input type="text" name="cname" placeholder="chinese name">
			    </div>
			    <div class="field"><label style="text-align: left">Student ID</label>
			      <input type="text" name="s_id" placeholder="student id">
			    </div>
			  </div>
			  <div class="three fields">
			  	<div class="field"><label style="text-align: left">Number</label>
			  	  <input type="number" name="number" min="1" max="100">
			  	</div>
			  	<div class="field"><label style="text-align: left">Position</label>
			  	  <select name="pos">
		        	<option value="01">攻擊</option>
		        	<option value="02">舉球</option>
		        	<option value="03">自由</option>
		        	<option value="04">攔中</option>
		        	<option value="04">球經</option>
		          </select>
			  	</div>
			  	<div class="field" style="text-align: left"><label>Gender</label>
				<div class="grouped inline fields">
        		  <div class="field">	
        			<input type="radio" name="gender" value="M" ><label><i class="big male icon"></i></label>
        		  </div>
        		  <div class="field">
        			<input type="radio" name="gender" value="F"><label><i class="big female icon"></i></label>
        		  </div>
    		    </div>
    		    </div>
              </div>
              <div class="ui buttons">
              	<input name="action" type="hidden" id="action" value="register">
			    <input type="submit" name="submit1" class="ui red basic button" value="register">
			    <div class="or"></div>
			    <input type="reset" name="submit2" class="ui teal basic button" value="reset">
			    <div class="or"></div>
			    <input type="button" name="submit3" class="ui yellow basic button" onclick="window.history.back()" value="Back">
			  </div>		      
		    </form>
		  </div>
		</div>
	</div>
	</div>
    </div>
</body>
</html>
