<?php
    header("Content-Type:text/html; charset=utf-8");
    require_once("connMysql.php");
    session_start();

    if(isset($_POST["action"]) && ($_POST["action"] == "donate"))
    {           
        if($_POST["d_money"]=="")
            header("Location: donate.php?errMsg=1");
        else
        {
            $query_insert = "INSERT INTO `donation`(`Account_id`, `Concert_id`, `Money_donated`, `Payment_id`) VALUES (";
            $query_insert .= "'".$_SESSION["account"]."',";
            $query_insert .= "'".$_GET["concertid"]."',";
            $query_insert .= "'".$_POST["d_money"]."',1)";
            mysqli_query($connect, $query_insert);

            $query_t_mon = "SELECT SUM(`Money_donated`) FROM `donation` WHERE `Concert_id` = '".$_GET["concertid"]."'";
            $T_mon = mysqli_query($connect, $query_t_mon);
            $row_T_mon = mysqli_fetch_array($T_mon);

            $query_aquire = "UPDATE `concert` SET `Money_acquired`='$row_T_mon[0]' WHERE `Concert_id` = '".$_GET["concertid"]."'";
            $Aquire = mysqli_query($connect, $query_aquire);

            header("Location: donate2.php?amount=".$_POST["d_money"]."");
        }        
    }    

    $query_detail = "SELECT * FROM `concert` WHERE `Concert_id` = '".$_GET["concertid"]."' ";
    $Detail = mysqli_query($connect, $query_detail);
    $row_Detail = mysqli_fetch_array($Detail);

    $query_order = "SELECT `Order_id`,`ticket`.`Ticket_type`, `order`.`quantity`, `ticket`.`Recommend_price` FROM `order`,`ticket` 
                    WHERE `ticket`.`Ticket_type_id` = `order`.`Ticket_type_id` AND `order`.`Concert_id` = '".$_GET["concertid"]."' AND `order`.`Account_id` = '".$_SESSION["account"]."'";
    $Order = mysqli_query($connect, $query_order);
    
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
<?php 
    if(isset($_GET["errMsg"]) && ($_GET["errMsg"] == "1"))
    {  ?>
        <script language="javascript">
            alert("Failed to donate! Please try again.");     
            location.href=javascript:window.history.back(-1);
        </script>
<?php
    }  ?>
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
    </div>


    <div id="donate" style="margin-bottom: 2cm;">
        <div class="page-header">
            <h3>線上捐款</h3>
            <a href="user_activity.php"><button type="button" class="btn btn-default">回上一頁</button></a>            
        </div>
        <?php  while($row_order = mysqli_fetch_array($Order)) { ?>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td class="tb_label">索票訂單編號</td>
                    <td><?php echo $row_order[0];?></td>
                </tr>        
                <tr>
                    <td class="tb_label">索取票種</td>
                    <td><?php echo $row_order[1];?></td>
                </tr>
                <tr>
                    <td class="tb_label">索取張數</td>
                    <td><?php echo $row_order[2];?></td>
                </tr>
                <tr>
                    <td class="tb_label">建議單張捐款金額</td>
                    <td><?php echo $row_order[3];?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <?php } ?>

        <h4>請填入欲捐贈金額</h4>
        <form name="donate" method="post" action="" class="donate_money">
            <input name="d_money" type="text" class="form-control" placeholder="請填寫您捐款金額（以新台幣作為貨幣單位）">           
            <input name="action" type="hidden" id="action" value="donate">                    
            <input type="submit" name="submit"  class="btn btn-primary" value="確認捐款金額">
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

</body>
</html>