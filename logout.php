<?php
	ob_start();
	session_start() ;
	unset($_SESSION["account"]) ;
	unset($_SESSION["memberType"]) ;
	unset($_SESSION["memberGender"]) ;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php header ("Location:index.php"); ?>
</body>
</html>