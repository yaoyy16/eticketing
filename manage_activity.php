<?php
    header("Content-Type:text/html; charset=utf-8");
    require_once("connMysql.php");
    session_start();


    if(isset($_POST["action"]) && ($_POST["action"] == "release"))
    {           
        $query_release = "UPDATE `concert` SET `visible`= 1 WHERE `Concert_id` = '".$_POST["concertid"]."'";
        $store_release = mysqli_query($connect, $query_release);
    }
    
    if(isset($_POST["action"]) && ($_POST["action"] == "addevent"))
    {
        if( ($_POST["concertname"]==""))
            header("Location: manage_activity.php?errMsg=1"); 
        else
            header("Location: addevent.php");
    }

   // $acc = mysqli_escape_string($connect, $_SESSION["account"]);
    $query_myevent = "SELECT * FROM `concert`"; // where `holder` = '".$_SESSION['account']."'";
    $Myevent = mysqli_query($connect, $query_myevent);



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
    <div id="my_events">
	    <div class="page-header">
	    	<h3>我的活動</h3>
	    </div>
	    
	    <div class="row">
			<?php 
			    while($row_Myevent = mysqli_fetch_array($Myevent))
			    {   ?>
			        <div class="col-sm-6 col-md-4">
			            <div class="thumbnail">
			                <img src="img/portfolio/7.jpg">
			                <div class="caption">
			                    <h3><?php echo $row_Myevent[0];?></h3>
			                    <ul>
			                      <li>地點 : <?php echo $row_Myevent[6];?></li>
			                      <li>時間 : <?php echo $row_Myevent[4]."&nbsp"."&nbsp".$row_Myevent[5];?></li>
			                      <li>狀態 : <?php if($row_Myevent[2]) echo "已發布"; else echo "未發布";?></li>
			                    </ul>
                                <form name="po" method="post" action="">
                                <?php 
                                    echo "<a href='m_eventdetail.php?concertid=".$row_Myevent[1]."' class='btn btn-primary' role='button'>檢視與編輯</a>";  
			                        if(!$row_Myevent[2])
                                    {?>                                        
                                        <input name="concertid" type="hidden" value="<?php echo $row_Myevent[1];?>">
                                        <input name="action" type="hidden" id="action" value="release">
                                        <input type="submit" name="submit3" class='btn btn-default' role='button' value="發佈">
                                <?php 
                                    } ?>
                                </form>
			                </div>
			            </div>
			        </div>
			<?php
			    }
			?>
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

    <!-- Custom JS -->

</body>
</html>
