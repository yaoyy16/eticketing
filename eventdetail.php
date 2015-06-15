<?php
	header("Content-Type:text/html; charset=utf-8");
	require_once("connMysql.php");
	session_start();

    if(isset($_SESSION["account"]) && ($_SESSION["account"] != ""))
    {
        if($_SESSION["memberType"] == "M") //manager
            header("Location: m_eventdetail.php");
        elseif($_SESSION["memberType"] == "U") //user
            header("Location: u_eventdetail.php");
    }

	$query_tktinfo ="SELECT `Ticket_type`, `ticket`.`Ticket_type_id`,`Recommend_price`, (`ticket`.`Num_of_ticket`-SUM(`order`.`quantity`)) FROM `order`, `concert`, `ticket` WHERE `ticket`.`Concert_id` = '".$_GET["concertid"]."' AND (`order`.`concert_id` = `concert`.`concert_id`) AND (`ticket`.`Ticket_type_id` = `order`.`Ticket_type_id`) GROUP BY `ticket`.`Ticket_type_id` ORDER BY `ticket`.`Ticket_type_id` ASC";

	if(isset($_POST["action"]) && ($_POST["action"]) == "get_tkt")
    {		
		if( ($_POST["tkttype"] == "") || ($_POST["number"]=="") || ($_POST["number"]==0) )
		{  ?>
            <script language="javascript">
			    alert("FAIL to order tickets !! Please try again.");     
		        location.href="eventdetail.php?concertid=".$_GET["concertid"]."";
	        </script>
<?php	}  
		else
		{   	
    		$Tktinfo3 = mysqli_query($connect, $query_tktinfo);
			while ($row_tktinfo3 = mysqli_fetch_array($Tktinfo3)) 
			{
				if($_POST["number"] > $row_tktinfo3[3])
				{ ?>
					<script language="javascript">
			            alert("FAIL to order tickets !! Please try again.");     
			            location.href="eventdetail.php?concertid=".$_GET["concertid"]."";
			        </script>
		<?php   }

				if($_POST["tkttype"] == $row_tktinfo3[1])
				{
					$query_insert = "INSERT INTO `order`(`Concert_id`, `Account_id`, `Ticket_type_id`, `quantity`) VALUES (";
	                $query_insert .="'".$_GET["concertid"]."',";
	                $query_insert .="'".$_SESSION["account"]."',";
	                $query_insert .="'".$row_tktinfo3[1]."',";
	                $query_insert .="'".$_POST["number"]."')";
	                mysqli_query($connect, $query_insert);
	                header("Location: eventdetail.php?concertid=".$_GET["concertid"]."");
				}		
			}
		}
    }

	// 3. login
    if(isset($_POST["action"]) && ($_POST["action"]) == "login")
    {
        if( ($_POST["email"] == "") || ($_POST["passwd"]==""))
            header("Location: index.php?errMsg=1"); 
        elseif(isset($_POST["email"]) && isset($_POST["passwd"]) && $_POST["email"] != "")
        {
            //connecting member data
            $query_RecLogin = "SELECT * FROM `personal information` WHERE `Email` = '".$_POST["email"]."'";
            $RecLogin = mysqli_query($connect, $query_RecLogin);

            //retrieve account & passwd value
            $row_RecLogin = mysqli_fetch_assoc($RecLogin);
            $acc = $row_RecLogin["Account_id"];
            $pwd = $row_RecLogin["Password"];
            $type = $row_RecLogin["Type"];
            $name = $row_RecLogin["Name"];

            //compare password, if login successfully then to login state
            if($_POST["passwd"] == $pwd)
            {
                //setting username and type
                $_SESSION["account"] = $acc;
                $_SESSION["memberType"] = $type;
                $_SESSION["userName"] = $name;

                if($_SESSION["memberType"] == "M") //manager
                    header("Location: manager_home.php");
                elseif($_SESSION["memberType"] == "U") //user
                    header("Location: events.php");
            }
            else
                header("Location: events.php?errMsg=1");
        }
    }

    // 2. register
    if(isset($_POST["action"]) && ($_POST["action"]) == "register")
    {
        if( ($_POST["name"]=="") || ($_POST["phonenum"]=="") || ($_POST["type"]=="") || ($_POST["email"] == "") || ($_POST["passwd"]=="") ||  ($_POST["passwdtry"]=="") || ($_POST["passwd"]!=$_POST["passwdtry"]))
            header("Location: index.php?errMsg=2"); 
        else
        {
            //check registered before or not
            $query_RecFindUser = "SELECT `Email` FROM `personal information` WHERE `Email` = '".$_POST["email"]."'";
            $RecFindUser = mysqli_query($query_RecFindUser);
            if(mysqli_num_rows($RecFindUser) > 0)
            {
                header("Location: events.php?errMsg=2&account=".$_POST["email"]);   
            }
            else
            {
                $query_insert = "INSERT INTO `personal information`(`Name`, `Password`, `Email`, `Phone_num`, `Type`) VALUES (";
                $query_insert .="'".$_POST["name"]."',";
                $query_insert .="'".$_POST["passwd"]."',";
                $query_insert .="'".$_POST["email"]."',";
                $query_insert .="'".$_POST["phonenum"]."',";
                $query_insert .="'".$_POST["type"]."')";
                mysqli_query($connect, $query_insert);
                header("Location: events.php?loginStats=1");
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
<?php 
    if(isset($_GET["loginStats"]) && ($_GET["loginStats"] == "1"))
    {  ?>
        <script language="javascript">
            alert("Successfully got tickets !!");     
            location.href="eventdetail.php?concertid=".$_GET["concertid"]."";
        </script>
<?php 
    }
	if(!isset($_SESSION["account"])){ ?>
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
                        <a class="page-scroll" href="index.php#about">關於</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#services">服務</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="events.php">探索活動</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#contact">聯絡我們</a>
                    </li>
                    <li>
                        <a href="#login" data-toggle="modal">登入</a>
                    </li>
                    <li>
                        <a href="#register" data-toggle="modal">註冊</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

<?php }else{ ?>
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
                <?php if($_SESSION["memberType"] == "M"){ ?>
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
                <?php }else{ ?>
                	<li>
                        <a href="user_home.php">回到首頁</a>
                    </li>
                    <li>
                        <a href="user_activity.php">我的活動</a>
                    </li>
                <?php } ?> 
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
<?php } ?>

    <div id="single_event">
	    <div class="page-header">
	    	<h3><?php echo $row_Detail[0]; ?></h3>
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
        <hr>
        <div class="action">
        	<a href="#notice_no_login" data-toggle="modal" class="btn btn-primary navbar-btn" role="button">索票</a> 
            <a href="events.php"><button type="button" class="btn btn-default">回上一頁</button></a>
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
	                    <?php
	                        //not login yet page
	                        if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
	                        {  ?>
	                           <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i>輸入有誤，請再試一次</div>
	                    <?php
	                        }
	                    ?>
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
				        <form name="gettktform" method="post" action="eventdetail.php?concertid=<?php echo $_GET["concertid"];?>" class="form-horizontal">	          
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
				                    <input type="number" name="number" min="0" value="0">
				                </div>
				            </div>                    
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>             
	                    <input name="action" type="hidden" id="action" value="get_tkt">                    
	                    <input type="submit" name="submit" class="btn btn-primary navbar-btn" value="確認">
	                </div>
	                </form>   
	           	</div>             	
            </div>
        </div>
    </div>

    <div class="modal fade" id="login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">登入</h4>
                </div>
                <form name="loginForm" method="post" action="">
                <div class="modal-body">
                    <?php
                        //not login yet page
                        if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "1")
                        {  ?>
                           <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i>您輸入的帳號或密碼錯誤</div>
                    <?php
                        }
                    ?>                    
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-envelope-o"></i></span>
                        <input name="email" type="text" class="form-control" placeholder="請輸入電子信箱" aria-describedby="sizing-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-key"></i></span>
                        <input name="passwd" type="password" class="form-control" placeholder="請輸入密碼" aria-describedby="sizing-addon1">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#register" data-toggle="modal" data-dismiss="modal"><button type="button" class="btn btn-default">尚未擁有帳號？</button></a>             
                    <input name="action" type="hidden" id="action" value="login">                    
                    <input type="submit" name="submit" class="btn btn-primary navbar-btn" value="登入">
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="register">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">註冊</h4>
                </div>
                <form name="signUpForm" id="formReg" method="post" action="">
                <div class="modal-body">
                    <?php
                        //not login yet page
                        if(isset($_GET["errMsg"]) && ($_GET["errMsg"]) == "2")
                        {  ?>

                           <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i>您未填完完整資訊</div>
                    <?php
                        }
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user"></i></span>
                        <input name="name" type="text" class="form-control" placeholder="請輸入真實姓名" aria-describedby="sizing-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-phone"></i></span>
                        <input name="phonenum" type="text" class="form-control" placeholder="請輸入連絡電話" aria-describedby="sizing-addon1">
                    </div>
                    <span>請選擇註冊會員類型</span>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="type" value="M" autocomplete="off" checked>活動管理者
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="type" value="U" autocomplete="off">一般會員
                        </label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-envelope-o"></i></span>
                        <input name="email" type="text" class="form-control" placeholder="請輸入電子信箱" aria-describedby="sizing-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-key"></i></span>
                        <input name="passwd" type="password" class="form-control" placeholder="請輸入密碼" aria-describedby="sizing-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-check"></i></span>
                        <input name="passwdtry" type="password" class="form-control" placeholder="請再次輸入密碼" aria-describedby="sizing-addon1">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#login" data-toggle="modal" data-dismiss="modal"><button type="button" class="btn btn-default">已經擁有帳號？</button></a>             
                    <input name="action" type="hidden" id="action" value="register">
                    <input type="submit" name="submit1" class="btn btn-primary navbar-btn" value="註冊">
                </div>
                </form>
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

    <div class="modal fade" id="notice_no_login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">尚未登入</h4>
                </div>
                <div class="modal-body">
                    您尚未登入。
                    此服務只供會員使用。若非會員，請先進行註冊。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">確定</button>             
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