<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

    $query_tktinfo ="SELECT `Ticket_type`, `ticket`.`Ticket_type_id`,`Recommend_price`, (`ticket`.`Num_of_ticket`-SUM(`order`.`quantity`)) FROM `order`, `concert`, `ticket` WHERE `ticket`.`Concert_id` = '".$_GET["concertid"]."' AND (`order`.`concert_id` = `concert`.`concert_id`) AND (`ticket`.`Ticket_type_id` = `order`.`Ticket_type_id`) GROUP BY `ticket`.`Ticket_type_id` ORDER BY `ticket`.`Ticket_type_id` ASC";
    

	if(isset($_POST["action"]) && ($_POST["action"]) == "get_tkt")
    {		
		if( ($_POST["tkttype"] == "") || ($_POST["number"]=="") || ($_POST["number"]=="0") )
            header("Location: u_eventdetail.php?concertid=".$_GET["concertid"].""); 
		else
		{   	
    		$Tktinfo3 = mysqli_query($connect, $query_tktinfo);
			$row_tktinfo3 = mysqli_fetch_array($Tktinfo3);
            //order ticket
			if($_POST["tkttype"] == $row_tktinfo3[1])
			{
				$query_insert = "INSERT INTO `order`(`Concert_id`, `Account_id`, `Ticket_type_id`, `quantity`) VALUES (";
                $query_insert .="'".$_GET["concertid"]."',";
	            $query_insert .="'".$_SESSION["account"]."',";
	            $query_insert .="'".$row_tktinfo3[1]."',";
	            $query_insert .="'".$_POST["number"]."')";
	            mysqli_query($connect, $query_insert);
	            header("Location: user_activity.php?loginStats=1");
			}		
		}
    }

	$query_detail = "SELECT * FROM `concert` WHERE `Concert_id` = '".$_GET["concertid"]."' ";
    $Detail = mysqli_query($connect, $query_detail);
	$row_Detail = mysqli_fetch_array($Detail);

	$Tktinfo = mysqli_query($connect, $query_tktinfo);
	$Tktinfo2 = mysqli_query($connect, $query_tktinfo);	
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
                        <a href="user_home.php">回到首頁</a>
                    </li>
                    <li>
                        <a href="user_activity.php">我的活動</a>
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
	    	<h3><?php echo $row_Detail[0]; ?></h3>
	    </div>			         
	    <img class="img-responsive img-thumbnail image" alt="Responsive image" src="img/portfolio/8.jpg">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td class="tb_label">活動介紹</td>
                    <td class="tb_value"><?php echo $row_Detail[4]; ?></td>
                </tr>
                <tr>
                    <td class="tb_label">活動人數</td>
                    <td class="tb_value"><?php echo $row_Detail[9]; ?></td>
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
        <hr>
        <div class="action">
        	<a href="#get_ticket" data-toggle="modal" class="btn btn-primary navbar-btn" role="button">索票</a> 
            <a href="user_activity.php"><button type="button" class="btn btn-default">回上一頁</button></a>
        </div>          
    </div>

    <div class="modal fade" id="get_ticket">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">索票</h4>
                </div>
                <div class="modal-body">
	                    <table class="table">
                            <thead>
                                <tr>            
    				                <th>票種名稱</th>
    				                <th>推薦捐款金額</th> 
    				                <th>剩餘數量</th>        
    				            </tr>
                            </thead>
				            <tbody>
				            <?php     
				                while ($row_tktinfo = mysqli_fetch_array($Tktinfo)) 
				                { 	?>
				                	<tr>
				                        <td><?php echo $row_tktinfo[0];?></td>
				                        <td><?php echo $row_tktinfo[2];?></td>
				                        <td><?php echo $row_tktinfo[3];?></td>				                        
				                    </tr> 
				                <?php   
				      		    }  ?> 
				            </tbody>
				        </table>
				        <form name="gettktform" method="post" action="" class="form-horizontal">          
				          	<div class="form-group">
                				<label for="real_name" class="col-sm-2 control-label">選取票種</label>
					            <div class="col-sm-10">
					                <select name="tkttype" class="form-control">
					        <?php    while ($row_tktinfo2 = mysqli_fetch_array($Tktinfo2)) 
						            { 	?>
						                	<option value="<?php echo $row_tktinfo2[1];?>"><?php echo $row_tktinfo2[0];?></option>
						    <?php   }  ?> 							        	
								    </select>
					            </div>
					        </div>
					        <div class="form-group">
				                <label for="real_name" class="col-sm-2 control-label">索取數量</label>
				                <div class="col-sm-10">
				                    <input type="number" name="number" min="0" max="30" value="0">
				                </div>
				            </div>                    
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>             
	                    <input name="action" type="hidden" id="action" value="get_tkt">                    
	                    <input type="submit" name="submit1" class="btn btn-primary navbar-btn" value="確認">
	                </div>
	                </form>   
	           	</div>             	
            </div>
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