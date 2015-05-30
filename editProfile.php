<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
    session_start();
	
	if(isset($_POST["action"]) && ($_POST["action"] == "edit"))
	{
		$pass = $_POST["passwd"];
		$id = $_POST["s_id"];
		$na = $_POST["cname"];
		$no = $_POST["number"];
		$po = $_POST["pos"];
		$g = $_POST["gender"];
		$query_update = "UPDATE `player` SET `Password`='$pass',`Student_id`='$id',`Name`='$na',`Number`='$no',`Pos_code`='$po',`Gender`='$g' WHERE `Account`='".$_SESSION["account"]."'";
		mysqli_query($connect, $query_update);
		header("Location: editProfile.php?editStats=1");
	}
	$query_profile = "SELECT * FROM `player` WHERE `Account` = '".$_SESSION["account"]."'";
	$Profile = mysqli_query($connect ,$query_profile);
	$row_Profile = mysqli_fetch_array($Profile);
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
<?php if(isset($_GET["editStats"]) && ($_GET["editStats"] == "1"))
	  {  ?>
	  	<script language="javascript">
			alert("Successfully applied !!");	  
			location.href="memberlist.php";
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
		    <form class="ui form segment" name="signUpForm" id="formReg" onsubmit="return checkform();" method="post" action="">
		      <div class="two fields">
			    <div class="field"><label style="text-align: left">Account</label>
			      <input type="text" name="account" readonly="readonly" value="<?php echo $row_Profile["Account"]; ?>">
	            </div>
		        <div class="field"><label style="text-align: left">Password</label>
		          <input type="password" name="passwd"  value="<?php echo $row_Profile["Password"]; ?>">
		        </div>
		      </div>
		      <div class="two fields">
			    <div class="field"><label style="text-align: left">Name</label>
			      <input type="text" name="cname"  value="<?php echo $row_Profile["Name"]; ?>">
			    </div>
			    <div class="field"><label style="text-align: left">Student ID</label>
			      <input type="text" name="s_id"  value="<?php echo $row_Profile["Student_id"]; ?>">
			    </div>
			  </div>
			  <div class="three fields">
			  	<div class="field"><label style="text-align: left">Number</label>
			  	  <input type="number" name="number" min="1" max="100"  value="<?php echo $row_Profile["Number"]; ?>">
			  	</div>
			  	<div class="field"><label style="text-align: left">Position</label>
			  	  <select name="pos">
			  	  	<option value="01" <?php if ($row_Profile["Pos_code"] == '01') echo "selected" ?>>攻擊</option>
		        	<option value="02" <?php if ($row_Profile["Pos_code"] == '02') echo "selected" ?>>舉球</option>
		        	<option value="03" <?php if ($row_Profile["Pos_code"] == '03') echo "selected" ?>>自由</option>
		        	<option value="04" <?php if ($row_Profile["Pos_code"] == '04') echo "selected" ?>>攔中</option>
		        	<option value="05" <?php if ($row_Profile["Pos_code"] == '05') echo "selected" ?>>球經</option>
		          </select>
			  	</div>
			  	<div class="field" style="text-align: left"><label>Gender</label>
				<div class="grouped inline fields">
        		  <div class="field">	
        			<input type="radio" name="gender" value="M" <?php if($row_Profile["Gender"] == "M") echo "checked";?>><label><i class="big male icon"></i></label>
        		  </div>
        		  <div class="field">
        			<input type="radio" name="gender" value="F" <?php if($row_Profile["Gender"] == "F") echo "checked";?>><label><i class="big female icon"></i></label>
        		  </div>
    		    </div>
    		    </div>
              </div>
              <div class="ui buttons">
              	<input name="action" type="hidden" id="action" value="edit">
			    <input type="submit" name="submit1" class="ui red basic button" value="Edit">
			    <div class="or"></div>
			    <input type="reset" name="submit2" class="ui teal basic button" value="Reset">
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