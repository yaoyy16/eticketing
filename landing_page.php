<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery.fullPage.css" />

	<!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
	
    <!-- Custom JS -->
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="/js/jquery.fullPage.js"></script>

	<script>
		$(document).ready(function() {
			$('#fullpage').fullpage({
		        //Navigation
		        menu: false,
		        anchors:['intro', 'about', 'activity', 'contact'],
		        navigation: false,
		        navigationPosition: 'right',
		        navigationTooltips: ['intro', 'about', 'activity', 'contact'],
		        showActiveTooltips: false,
		        slidesNavigation: true,
		        slidesNavPosition: 'bottom',

		        //Scrolling
		        css3: true,
		        scrollingSpeed: 700,
		        autoScrolling: true,
		        fitToSection: true,
		        scrollBar: false,
		        easing: 'easeInOutCubic',
		        easingcss3: 'ease',
		        loopBottom: false,
		        loopTop: false,
		        loopHorizontal: true,
		        continuousVertical: false,
		        normalScrollElements: '#element1, .element2',
		        scrollOverflow: false,
		        touchSensitivity: 15,
		        normalScrollElementTouchThreshold: 5,

		        //Accessibility
		        keyboardScrolling: true,
		        animateAnchor: true,
		        recordHistory: true,

		        //Design
		        controlArrows: true,
		        verticalCentered: true,
		        resize : false,
		        sectionsColor : ['#eecc29'],
		        paddingTop: '3em',
		        paddingBottom: '10px',
		        fixedElements: '#nav, .footer',
		        responsive: 0,

		        //Custom selectors
		        sectionSelector: '.section',
		        slideSelector: '.slide',

		        //events
		        onLeave: function(index, nextIndex, direction){},
		        afterLoad: function(anchorLink, index){},
		        afterRender: function(){},
		        afterResize: function(){},
		        afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},
		        onSlideLeave: function(anchorLink, index, slideIndex, direction){}
		    });
		});
	</script>
</head>
<body>
	<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation" id="nav">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="#intro">Start Bootstrap</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#about">關於</a>
                    </li>
                    <li>
                        <a href="#activity">活動一覽</a>
                    </li>
                    <li>
                        <a href="#contact">聯絡我們</a>
                    </li>
                    <li>
                    	<a href="">登入</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	<div id="fullpage">
		<div class="section" id="intro">
			b
		</div>
		<div class="section">
			
		</div>
		<div class="section">
			
		</div>
	</div>
	

    
	
</body>
</html>