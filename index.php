<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery.fullPage.css">
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.fullPage.min.js"></script>
	<script>
		$(document).ready(function() {
	    	$('#fullpage').fullpage({
	        //Navigation
		        menu: false,
		        anchors:['firstPage', 'secondPage'],
		        navigation: false,
		        navigationPosition: 'right',
		        navigationTooltips: [],
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
		        controlArrows: false,
		        verticalCentered: true,
		        resize : false,
		        sectionsColor : ['#000000'],
		        paddingTop: '3em',
		        paddingBottom: '10px',
		        fixedElements: '#header',
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
	<div id="header">
		
	</div>
	<div id="fullpage">
		<div class="section">
		</div>
	</div>
</body>
</html>