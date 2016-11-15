<!DOCTYPE html>
<html lang="fr">
<head>
	<link rel="icon" href="images/favicon.ico" />
	<title>fakebook</title>

	<meta charset="utf-8">
	<link rel="stylesheet" href="css/default.css">

	<script type="text/javascript" src="js/chat.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="js/material.min.js"></script>
	<script src="js/nouislider.min.js" type="text/javascript"></script>
	<script src="js/material-kit.js" type="text/javascript"></script>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css"> -->
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
	<link href="css/material-kit.css" rel="stylesheet"/>
</head>
<body style="background-color: #191919;">
	<?php
		if(context::isConnect())
		{
			include("header.php");
			include("chat.php");
		}
		
		include($template_view);
		include("footer.php");
	?>
</body>
</html>
