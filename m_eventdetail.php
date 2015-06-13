<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
    session_start();

    if(isset($_POST["action"]) && ($_POST["action"] == "release"))
    {           
        $query_release = "UPDATE `concert` SET `visible`= 1 WHERE `Concert_id` = '".$_GET["concertid"]."'";
        $store_release = mysqli_query($connect, $query_release);
        header("Location: m_eventdetail.php?concertid=".$_GET["concertid"]."");
    }
	
	if(isset($_POST["action"]) && ($_POST["action"] == "edit"))
	{
		if( ($_POST["conname"]=="") || ($_POST["descp"]=="") || ($_POST["date"] == "") || ($_POST["time"]=="") ||  ($_POST["place"]==""))
			header("Location: m_eventdetail.php?errMsg=1");
		else
		{
			$conname = $_POST["conname"];
			$descp = $_POST["descp"];
			$date = $_POST["date"];
			$time = $_POST["time"];
			$place = $_POST["place"];
			$query_update = "UPDATE `concert` SET `Concert_name`='$conname',`Description`='$descp',`Date`='$date',`Time`='$time', `Place`='$place' WHERE `Concert_id` = '".$_GET["concertid"]."' ";
			mysqli_query($connect, $query_update);
			header("Location: m_eventdetail.php?concertid=".$_GET["concertid"]."");
		}
	}
   
	$query_detail = "SELECT * FROM `concert` WHERE `Concert_id` = '".$_GET["concertid"]."' ";
    $Detail = mysqli_query($connect, $query_detail);
	$row_Detail = mysqli_fetch_array($Detail);
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

    
    <div id="single_event">
        <div class="page-header">
            <h3>活動資訊</h3>
    <?php
        //未發佈 可改資訊
        if($row_Detail[3] == 0)
        { ?>
    		<form name="po" method="post" action="" >
                <input name="action" type="hidden" id="action" value="release">
                <input type="submit" name="submit4" class='btn btn-default' role='button' value="發佈">
            </form>            
        </div>    		
        	<form name="editForm" method="post" action="" class="form-horizontal" >
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
                    <input name="conname" type="text" class="form-control" value="<?php echo $row_Detail[0]; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">活動介紹</label>
                <div class="col-sm-10">
                    <input name="descp" type="text" class="form-control" value="<?php echo $row_Detail[4]; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">日期</label>
                <div class="col-sm-10">
                    <input name="date" type="text" class="form-control" value="<?php echo $row_Detail[6]; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">時間</label>
                <div class="col-sm-10">
                    <input name="time" type="text" class="form-control" value="<?php echo $row_Detail[7]; ?>">
                </div>
            </div>          
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">地點</label>
                <div class="col-sm-10">
                    <input name="place" type="text" class="form-control" value="<?php echo $row_Detail[8]; ?>">
                </div>
            </div>       

            <div class="modal-footer">
                <input name="action" type="hidden" id="action" value="edit">
                <input type="submit" name="submit" class="btn btn-primary navbar-btn" value="修改">
                <input type="reset" name="submit2" class="btn btn-default" value="取消">
            </div>         
        	</form>
<?php   }
		else
		{ ?>
		  </div>
		  	<img class="img-responsive img-thumbnail image" alt="Responsive image" src="img/portfolio/2.jpg">
		        <table class="table table-striped">
		            <tbody>
		                <tr>
		                    <td class="tb_label">活動介紹</td>
		                    <td class="tb_value"><?php echo $row_Detail[4]; ?></td>
		                </tr>
		                <tr>
		                    <td class="tb_label">日期</td>
		                    <td class="tb_value"><?php echo $row_Detail[6]; ?></td>
		                </tr>
		                <tr>
		                    <td class="tb_label">時間</td>
		                    <td class="tb_value"><?php echo $row_Detail[7]; ?></td>
		                </tr>
		                <tr>
		                    <td class="tb_label">地點</td>
		                    <td class="tb_value"><?php echo $row_Detail[8]; ?></td>
		                </tr>
		            </tbody>
		        </table>
<?php
		} ?> 
		<div class="page-header">
	    	<h3>索票紀錄</h3>
	    </div>
	    <table class="table">
			<thead ><tr>            
			    <th>票種名稱</th>
			    <th>推建捐款金額</th> 
			    <th>數量</th> 
			    <th>剩餘票數</th>        
			</tr></thead>
			<tbody>
			    <?php   
			    $query_order="SELECT `Ticket_type`, `Recommend_price`, (`ticket`.`Num_of_ticket`-SUM(`order`.`quantity`)), `ticket`.`Num_of_ticket` FROM `order`, `concert`, `ticket` WHERE `ticket`.`Concert_id` = '".$_GET["concertid"]."' AND (`order`.`concert_id` = `concert`.`concert_id`) AND (`ticket`.`Ticket_type_id` = `order`.`Ticket_type_id`) GROUP BY `ticket`.`Ticket_type_id` ORDER BY `ticket`.`Ticket_type_id` ASC";
			    	
			    	$Order = mysqli_query($connect, $query_order);

			    	while ($row_order = mysqli_fetch_array($Order)) 
			    	{ ?>
			    		<tr>
				            <td><?php echo $row_order[0];?></td>
				            <td><?php echo $row_order[1];?></td>
				            <td><?php echo $row_order[3];?></td>
				            <td><?php echo $row_order[2];?></td>				                        
				        </tr> 
			<?php   } ?>
			</tbody>
		</table> 	
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
