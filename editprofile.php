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
                        <a href="manager_home.php">新增活動</a>
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
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">帳戶設定</h4>
                </div>
                <form name="editForm" method="post" action="">
                <div class="modal-body">
                 	<?php
                        //not login yet page
                        if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
                        {  ?>
                           <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i>您輸入的過程中可能發生錯誤，或所填改資料不完整，請重新修改。</div>
                    <?php
                        }
                    ?>
                    <h5 class="modal-title" style=" margin-top: 0.2cm;">真實姓名</h5>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user"></i></span>
                        <input name="name" type="text" class="form-control" value="<?php echo $row_Profile["Name"]; ?>" aria-describedby="sizing-addon1">
                    </div>
                    <h5 class="modal-title" style=" margin-top: 0.2cm;">聯絡電話</h5>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-phone"></i></span>
                        <input name="phonenum" type="text" class="form-control" value="<?php echo $row_Profile["Phone_num"]; ?>" aria-describedby="sizing-addon1">
                    </div>
                    <h5 class="modal-title" style=" margin-top: 0.2cm;">電子信箱</h5>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-envelope-o"></i></span>
                        <input name="account" type="text" class="form-control" readonly="readonly" value="<?php echo $row_Profile["Email"]; ?>" aria-describedby="sizing-addon1">
                    </div>
                    <h5 class="modal-title" style=" margin-top: 0.2cm;">密碼</h5>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-key"></i></span>
                        <input name="passwd" type="password" class="form-control" value="<?php echo $row_Profile["Password"]; ?>" aria-describedby="sizing-addon1">
                    </div>
                    <h5 class="modal-title" style=" margin-top: 0.2cm;">密碼確認</h5>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-check"></i></span>
                        <input name="passwdtry" type="password" class="form-control" placeholder="請再次輸入密碼" aria-describedby="sizing-addon1">
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="action" type="hidden" id="action" value="edit">
                    <input type="submit" name="submit1" class="btn btn-primary navbar-btn" value="修改">
			    	<input type="button" name="submit3" class="btn btn-default" onclick="window.history.back()" value="Back">
                </div>
                </form>
            </div>
        </div>

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