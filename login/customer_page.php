<?php

session_start();

if(!isset($_SESSION['user_role'])) {
	header('location: login.php');
} else if($_SESSION['user_role']!='Customer') {
	header('location: login.php');
}

?>
<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<center>Customer Page</center>
	</body>
</html>
