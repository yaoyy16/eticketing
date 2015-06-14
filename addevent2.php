<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

	if(isset($_POST["action"]) && ($_POST["action"] == "save"))
	{
		if(($_POST["tkttype"]=="")|| ($_POST["num"]=="")|| ($_POST["price"]==""))
			header("Location: addevent2.php?errMsg=1"); 
		else
		{	
			$query_insert = "INSERT INTO `ticket`(`Concert_id`, `Ticket_type`, `Num_of_ticket`, `Recommend_price`)  VALUES (" ;
			$query_insert .= "'".$_GET["concertid"]."',";
			$query_insert .= "'".$_POST["tkttype"]."',";
			$query_insert .= "'".$_POST["num"]."',";
			$query_insert .= "'".$_POST["price"]."')";
			mysqli_query($connect, $query_insert);

            //add total num of the concert and total expected money aquire
            //$query_seat_money ="SELECT SUM(`Num_of_ticket`), SUM(`Num_of_ticket`*) FROM `ticket` WHERE `Concert_id` = '".$_GET["concertid"]."' ";
            //$Seat_money = mysqli_query($connect, $query_seat_money);
            //$row_Seat_money = mysql_fetch_array($Seat_money);

            //更新當天的練球人數
            //$query_storeNum = "UPDATE `concert` SET `Num_of_people`='$row_NumOfAttend[0]' WHERE `Concert_id` = '".$_GET["concertid"]."'";
            //$storeNum = mysqli_query($connect, $query_storeNum);

			header("Location: addevent2.php?concertid=".$_GET["concertid"]."");
		}
	}

    $query_detail = "SELECT * FROM `concert` WHERE`Concert_id` = '".$_GET["concertid"]."' ";
    $Detail = mysqli_query($connect, $query_detail);
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
            <h3>活動資訊預覽</h3>
        </div>
        <?php 
        while($row_detail = mysqli_fetch_array($Detail))
                {   ?>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td class="tb_label">
                                    活動名稱
                                </td>
                                <td class="tb_value">
                                    <?php echo $row_detail[0];?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tb_label">
                                    活動介紹
                                </td>
                                <td class="tb_value">
                                    <?php echo $row_detail[4];?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tb_label">
                                    活動時間
                                </td>
                                <td class="tb_value">
                                    <?php echo $row_detail[6]."&nbsp"."&nbsp".$row_detail[7];?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tb_label">
                                    活動地點
                                </td>
                                <td class="tb_value">
                                    <?php echo $row_detail[8];?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tb_label">
                                    活動狀態
                                </td>
                                <td class="tb_value"><?php if($row_detail[3]) echo "已發布"; else echo "未發布";?></td>
                            </tr>
                        </tbody>
                    </table>
        <?php   } ?>
        <div class="page-header">
            <h3>票種設定</h3>
        </div>
            <?php     
                $query_tkttype = "SELECT `Ticket_type`, `Num_of_ticket`, `Recommend_price`FROM `concert`NATURAL JOIN `ticket`WHERE `concert`.`Concert_id` = '".$_GET["concertid"]."'";
                $Tkttype = mysqli_query($connect, $query_tkttype);
                if(is_null($Tkttype)) 
                    echo "您未新增任何票種";
                else
                { ?>   
                    <table class="table table-striped">
                        <thead>
                            <tr>            
                                <th>票種名稱</th>
                                <th>數量</th>
                                <th>推薦捐款金額</th>              
                            </tr>
                        </thead>
                    
                    <tbody>
                    <?php while($row_tkttype = mysqli_fetch_row($Tkttype))
                    { ?>
                        <tr>
                            <td><?php echo $row_tkttype[0];?></td>
                            <td><?php echo $row_tkttype[1];?></td>
                            <td><?php echo $row_tkttype[2];?></td>
                        </tr>
            <?php   } ?>
                    </tbody>
                </table>    
            <?php }
            ?> 
                    
        <div class="page-header">
            <h3>新增票種</h3>
        </div>
        <form name="addForm2" method="post" action="addevent2.php?concertid=<?php echo $_GET["concertid"];?>" class="form-horizontal add_ticket">
            <?php
                //not login yet page
                if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
                {  ?>
                   <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i>輸入的過程中可能發生錯誤，或所填改資料不完整，請重新修改。</div>
            <?php
                }
            ?>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">票種名稱</label>
                <div class="col-sm-10">
                    <input name="tkttype" type="text" class="form-control" id="tkttype_input" placeholder="請填寫該票種名稱" >
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">票券數量</label>
                <div class="col-sm-10">
                    <input name="num" type="textarea" class="form-control" id="num_input" placeholder="請填寫該票種的票券數量">
                </div>
            </div>
            <div class="form-group">
                <label for="real_name" class="col-sm-2 control-label">推薦捐款金額</label>
                <div class="col-sm-10">
                    <input name="price" type="text" class="form-control" id="price_input" placeholder="請填寫該票券的推薦捐款金額（以新台幣作為貨幣單位）">
                </div>
            </div>

            <div class="modal-footer">
                <input name="action" type="hidden" id="action" value="save">                    
                <input type="submit" name="submit" class="btn btn-primary navbar-btn" value="新增票種">
                <a href="manage_activity.php"><button type="button" class="btn btn-default">完成活動建立</button></a>
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


