<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
    session_start();
	
	if(isset($_POST["action"]) && ($_POST["action"] == "edit"))
	{
		if( ($_POST["name"]=="") || ($_POST["phonenum"]=="") || ($_POST["account"] == "") || ($_POST["passwd"]=="") ||  ($_POST["passwdtry"]=="") || ($_POST["passwd"]!=$_POST["passwdtry"]))
			header("Location: editprofile.php?errMsg=1");
		else
		{
			$na = $_POST["name"];
			$pass = $_POST["passwd"];
			$email = $_POST["account"];
			$phone = $_POST["phonenum"];
			$query_update = "UPDATE `personal_information` SET `Name`='$na',`Password`='$pass',`Email`='$email',`Phone_num`='$phone' WHERE `Email`='".$_SESSION["account"]."'";
			mysqli_query($connect, $query_update);
			header("Location: editProfile.php?editStats=1");
		}
	}

	$query_profile = "SELECT * FROM `personal_information` WHERE `Email` = '".$_SESSION["account"]."'";
	$Profile = mysqli_query($connect ,$query_profile);
	$row_Profile = mysqli_fetch_array($Profile);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Eden Ticket - 電子票卷最佳選擇</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <!-- <link rel="stylesheet" href="css/animate.min.css" type="text/css"> -->

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/common.css" type="text/css">
	<link rel="stylesheet" href="css/manage.css" type="text/css">    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">
<?php if(isset($_GET["editStats"]) && ($_GET["editStats"] == "1"))
	  {  
			if($_SESSION["memberType"] == "M") //manager
            	header("Location: manager_home.php");
        	elseif($_SESSION["memberType"] == "U") //user
            	header("Location: user_home.php");  
	  }
?>

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Eden Ticket</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="manager_home.php">回到首頁</a>
                    </li>
                    <li>
                        <a href="manager_home.php">所有我的活動</a>
                    </li>
                    <li>
                        <a href="#new_event" data-toggle="modal">新增活動</a>
                    </li>
                    <li>
                        <a href="editprofile.php">個人帳戶管理</a>
                    </li>
                    <li>
                        <a href="#logout" data-toggle="modal">登出</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div style=" margin-top: 3cm;"></div>
    <form name="editForm" method="post" action="" id="profile" class="form-horizontal">
            <?php
                //not login yet page
                if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
                {  ?>
                   <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i>您輸入的過程中可能發生錯誤，或所填改資料不完整，請重新修改。</div>
            <?php
                }
            ?>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">真實姓名</label>
                <div class="col-sm-10">
                    <input name="name" type="text" class="form-control" id="name_input" value="<?php echo $row_Profile["Name"]; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">聯絡電話</label>
                <div class="col-sm-10">
                    <input name="phonenum" type="text" class="form-control" id="phonenum_input" value="<?php echo $row_Profile["Phone_num"]; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">電子信箱</label>
                <div class="col-sm-10">
                    <input name="account" type="text" class="form-control" id="account_input" value="<?php echo $row_Profile["Email"]; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">密碼</label>
                <div class="col-sm-10">
                    <input name="passwd" type="password" class="form-control" id="password_input" value="<?php echo $row_Profile["Password"]; ?>">
                </div>
            </div>          
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">密碼確認</label>
                <div class="col-sm-10">
                    <input name="passwdtry" type="password" class="form-control" id="passwordtry_input" >
                </div>
            </div>        

            <div class="modal-footer">
                <input name="action" type="hidden" id="action" value="edit">
                <input type="submit" name="submit1" class="btn btn-primary navbar-btn" value="修改">
		    	<input type="button" name="submit3" class="btn btn-default" onclick="window.history.back()" value="取消">
            </div>
            
        </form>

    <div class="modal fade" id="logout">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">登出 Eden Ticket</h4>
                </div>
                <div class="modal-body">
                    你確定要登出嗎？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">我按錯拉</button>             
                    <a href="logout.php"><button type="button" class="btn btn-primary">登出</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new_event">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">新增活動</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="event_name">活動名稱</label>
                            <input type="text" class="form-control" id="" placeholder="請在此輸入活動名稱">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">下一步</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jquery.fittext.js"></script>
    <script src="js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/creative.js"></script>

</body>
</html>
