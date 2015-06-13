<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

	if(isset($_POST["action"]) && ($_POST["action"] == "save"))
	{
		if(($_POST["conname"]=="")|| ($_POST["descp"]=="")|| ($_POST["date"]=="")|| ($_POST["time"]=="")|| ($_POST["place"]==""))
			header("Location: addevent.php?errMsg=1"); 
		//if($_FILES["fileUpload"]["error"]==0)
		else
		{	
			//if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "img/".$_FILES["fileUpload"]["name"]))
			//{	
			$query_insert = "INSERT INTO `concert`(`Concert_name`, `Account_id`, `Description`, `Photo_id`, `Date`, `Time`, `Place`, `Seats`, `Money_acquired`, `Visible`) VALUES (";
			$query_insert .= "'".$_POST["conname"]."',";
			$query_insert .= "'".$_SESSION["account"]."',";
			$query_insert .= "'".$_POST["descp"]."',";
			$query_insert .= "'".$_FILES["fileUpload"]["name"]."',";
			$query_insert .= "'".$_POST["date"]."',";
			$query_insert .= "'".$_POST["time"]."',";
			$query_insert .= "'".$_POST["place"]."',0,0,0)";
			mysqli_query($connect, $query_insert);

			$query_concert = "SELECT MAX(`Concert_id`) FROM `concert`";
			$Concert = mysqli_query($connect, $query_concert);
			$row_concert = mysqli_fetch_array($Concert);
			header("Location: addevent2.php?concertid=".$row_concert[0]."");
			//}
			//else
			//header("Location: addevent.php?errMsg=2");
		}
	}

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
                        <a href="manage_activity.php">我的活動</a>
                    </li>
                    <li>
                        <a href="addevent.php">新增活動</a>
                    </li>
                    <li>
                        <a href="events.php">探索活動</a>
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

    <div id="profile">
        <div class="page-header">
            <h3>新增活動</h3>
        </div>
        <form name="addForm" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <?php
                //not login yet page
                if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
                {  ?>
                   <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i>輸入的過程中可能發生錯誤，或所填改資料不完整，請重新修改。</div>
            <?php
                }
            ?>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">活動名稱</label>
                <div class="col-sm-10">
                    <input name="conname" type="text" class="form-control" id="name_input" placeholder="" >
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">活動介紹</label>
                <div class="col-sm-10">
                    <input name="descp" type="textarea" class="form-control" id="descp_input" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">日期</label>
                <div class="col-sm-10">
                    <input name="date" type="text" class="form-control" id="date_input">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">時間</label>
                <div class="col-sm-10">
                    <input name="time" type="text" class="form-control" id="time_input">
                </div>
            </div>          
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">地點</label>
                <div class="col-sm-10">
                    <input name="place" type="text" class="form-control" id="place_input" >
                </div>
            </div>       
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">上傳活動宣傳圖</label>
                <div class="col-sm-10">
                 
                </div>
            </div>        

            <div class="modal-footer">
                <input name="action" type="hidden" id="action" value="save">                    
                <input type="submit" name="submit" class="btn btn-primary navbar-btn" value="新增">
		    	<input type="button" name="submit3" class="btn btn-default" onclick="window.history.back()" value="取消">
            </div>         
        </form>
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

    <!-- Custom JS -->

</body>
</html>


