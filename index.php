<!DOCTYPE html>
<?php
    header("Content-Type:text/html; charset=utf-8");
    require_once("connMysql.php");
    session_start();

    // 1. check have login or not
    if(isset($_SESSION["account"]) && ($_SESSION["account"] != ""))
    {
        if($_SESSION["memberType"] == "M") //manager
            header("Location: manager_home.php");
        elseif($_SESSION["memberType"] == "U") //user
            header("Location: user_home.php");
    }

    // 3. login
    if(isset($_POST["action"]) && ($_POST["action"]) == "login")
    {
        if( ($_POST["account"] == "") || ($_POST["passwd"]==""))
            header("Location: index.php?errMsg=1"); 
        elseif(isset($_POST["account"]) && isset($_POST["passwd"]) && $_POST["account"] != "")
        {
            //connecting member data
            $query_RecLogin = "SELECT * FROM `personal_information` WHERE `Email` = '".$_POST["account"]."'";
            $RecLogin = mysqli_query($connect, $query_RecLogin);

            //retrieve account & passwd value
            $row_RecLogin = mysqli_fetch_assoc($RecLogin);
            $acc = $row_RecLogin["Email"];
            $pwd = $row_RecLogin["Password"];
            $type = $row_RecLogin["Type"];

            //compare password, if login successfully then to login state
            if($_POST["passwd"] == $pwd)
            {
                //setting username and type
                $_SESSION["account"] = $acc;
                $_SESSION["memberType"] = $type;

                if($_SESSION["memberType"] == "M") //manager
                    header("Location: manager_home.php");
                elseif($_SESSION["memberType"] == "U") //user
                    header("Location: user_home.php");
            }
            else
                header("Location: index.php?errMsg=1");
        }
    }

    // 2. register
    if(isset($_POST["action"]) && ($_POST["action"]) == "register")
    {
        if( ($_POST["name"]=="") || ($_POST["phonenum"]=="") || ($_POST["type"]=="") || ($_POST["account"] == "") || ($_POST["passwd"]=="") ||  ($_POST["passwdtry"]=="") || ($_POST["passwd"]!=$_POST["passwdtry"]))
            header("Location: index.php?errMsg=2"); 
        else
        {
            //check registered before or not
            $query_RecFindUser = "SELECT `Email` FROM `personal_information` WHERE `Email` = '".$_POST["account"]."'";
            $RecFindUser = mysqli_query($query_RecFindUser);
            if(mysqli_num_rows($RecFindUser) > 0)
            {
                header("Location: index.php?errMsg=2&account=".$_POST["account"]);   
            }
            else
            {
                $query_insert = "INSERT INTO `personal_information`(`Name`, `Password`, `Email`, `Phone_num`, `Type`) VALUES (";
                $query_insert .="'".$_POST["name"]."',";
                $query_insert .="'".$_POST["passwd"]."',";
                $query_insert .="'".$_POST["account"]."',";
                $query_insert .="'".$_POST["phonenum"]."',";
                $query_insert .="'".$_POST["type"]."')";
                mysqli_query($connect, $query_insert);
                header("Location: index.php?loginStats=1");
            }
        }       
    }

    
?>
    
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Eden Ticket</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <link rel="stylesheet" href="css/index.css" type="text/css">


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
            alert("Successfully applied !!");     
            location.href="index.php";
        </script>
<?php   
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
                        <a class="page-scroll" href="#about">關於</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">服務</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">熱門活動</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">聯絡我們</a>
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

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1>讓你輕鬆參加每一場慈善音樂會</h1>
                <hr>
                <p>使用 Eden Ticket</p>
                <a href="#about" class="btn btn-primary btn-xl page-scroll">瞭解更多</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">還記得到了演唱會現場才發現忘記帶票的囧樣嗎？</h2>
                    <hr class="light">
                    <p class="text-faded">Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached!</p>
                    <a href="#" class="btn btn-default btn-xl">開始使用</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary"></i>
                        <h3>Sturdy Templates</h3>
                        <p class="text-muted">Our templates are updated regularly so they don't break.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-paper-plane wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3>Ready to Ship</h3>
                        <p class="text-muted">You can use this theme as is, or you can make changes!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-newspaper-o wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <h3>Up to Date</h3>
                        <p class="text-muted">We update dependencies to keep things fresh.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-heart wow bounceIn text-primary" data-wow-delay=".3s"></i>
                        <h3>Made with Love</h3>
                        <p class="text-muted">You have to make your websites with love these days!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="col-lg-4 col-sm-6">
                    <a href="#" class="portfolio-box">
                        <img src="img/portfolio/1.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    達人分享
                                </div>
                                <div class="project-name">
                                    設計這一條路
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#" class="portfolio-box">
                        <img src="img/portfolio/2.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    DIY 工作坊
                                </div>
                                <div class="project-name">
                                    打造專屬自己的風格文具
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#" class="portfolio-box">
                        <img src="img/portfolio/3.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    達人分享
                                </div>
                                <div class="project-name">
                                    攝影深入淺出
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#" class="portfolio-box">
                        <img src="img/portfolio/4.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    DIY 工作坊
                                </div>
                                <div class="project-name">
                                    十分鐘上菜
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#" class="portfolio-box">
                        <img src="img/portfolio/5.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    達人分享
                                </div>
                                <div class="project-name">
                                    時裝穿搭
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="#" class="portfolio-box">
                        <img src="img/portfolio/6.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    DIY 工作坊
                                </div>
                                <div class="project-name">
                                    北歐風傢俱動手做
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>想要參加更多不同的活動嗎？</h2>
                <a href="#" class="btn btn-default btn-xl wow tada">瀏覽所有活動</a>
            </div>
        </div>
    </aside>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">聯絡我們</h2>
                    <hr class="primary">
                    <p>不只是客戶服務，更是您的最佳良伴！</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x wow bounceIn"></i>
                    <p>123-456-6789</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="mailto:your-email@your-domain.com">feedback@startbootstrap.com</a></p>
                </div>
            </div>
        </div>
    </section>

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
                        <input name="account" type="text" class="form-control" placeholder="請輸入電子信箱" aria-describedby="sizing-addon1">
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
                        <input name="account" type="text" class="form-control" placeholder="請輸入電子信箱" aria-describedby="sizing-addon1">
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
