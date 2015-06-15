<?php
    header("Content-Type:text/html; charset=utf-8");
    require_once("connMysql.php");
    session_start();


    if(isset($_POST["action"]) && ($_POST["action"] == "donate"))
    {           
        //$query_

        $query_release = "UPDATE `concert` SET `visible`= 1 WHERE `Concert_id` = '".$_POST["concertid"]."'";
        $store_release = mysqli_query($connect, $query_release);
    }
    

   // $acc = mysqli_escape_string($connect, $_SESSION["account"]);
    $query_order = "SELECT `Order_id`,`ticket`.`Ticket_type`, `order`.`quantity`, `ticket`.`Recommend_price` FROM `order`,`ticket` WHERE `ticket`.`Ticket_type_id` = `order`.`Ticket_type_id` AND `order`.`Order_id` = '".$_GET['orderid']."'";

    $Order = mysqli_query($connect, $query_order);
    $row_order = mysqli_fetch_array($Order);
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


    <div id="donate">
        <div class="page-header">
            <h3>線上捐款</h3>
            <a href="user_activity.php"><button type="button" class="btn btn-default">回上一頁</button></a>
            
        </div>
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
                    <td class="tb_label">建議捐款金額</td>
                    <td><?php echo $row_order[3];?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h4>請填入欲捐贈金額</h4>
        <form name="donate" method="post" action="" class="donate_money">
            <input name="price" type="text" class="form-control" placeholder="請填寫您捐款金額（以新台幣作為貨幣單位）">        
            <input name="action" type="hidden" id="action" value="donate">                    
            <input type="submit" name="submit"  class="btn btn-primary" value="確認捐款金額">
        </form>
        <h4>請選擇以下支付服務，我們將為您進行線上捐款：</h4>
        <table class="table">
            <tbody>
                <td class="tb_donate"><a href="http://www.eden.org.tw/donations/"><i class="fa fa-cc-mastercard"></i> MasterCard 信用卡</a></td>
                <td class="tb_donate"><a href="http://www.eden.org.tw/donate_page.php?level2_id=55&level3_id=192"><i class="fa fa-cc-paypal"></i> PayPal 第三方支付</a></td>
                <td class="tb_donate"><a href="http://www.eden.org.tw/donate_page.php?level2_id=55&level3_id=192"><i class="fa fa-cc-visa"></i> Visa 信用卡</a></td>
                <td class="tb_donate"><a href="http://www.eden.org.tw/donate_page.php?level2_id=55&level3_id=192"><i class="fa fa-university"></i>其他支付服務</a></td>
            </tbody>
        </table>
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