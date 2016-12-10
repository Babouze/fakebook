<!DOCTYPE html>
<html lang="fr">
<head>
	<link rel="icon" href="images/favicon.ico" />
	<title>fakebook</title>

	<meta charset="utf-8">
	<link rel="stylesheet" href="css/default.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.0.0.js"></script> -->
	<script src="https://code.jquery.com/jquery-migrate-1.1.1.js"></script>

	<script type="text/javascript" src="js/chat.js"></script>
	<script src="js/material.min.js"></script>
	<script src="js/nouislider.min.js" type="text/javascript"></script>
	<script src="js/material-kit.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r71/three.min.js" type="text/javascript"></script>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css"> -->
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
	<link href="css/material-kit.css" rel="stylesheet"/>

	<!-- CSS and JS for Jquery Window -->
	<link id="jquery_ui_theme_loader" type="text/css" href="js/jquery/themes/black-tie/jquery-ui.css" rel="stylesheet" />
	<!-- <link id="jquery_ui_theme_loader" type="text/css" href="js/jquery/themes/darkness/jquery-ui.css" rel="stylesheet" /> -->
	<link type="text/css" href="js/jquery/window/css/jquery.window.css" rel="stylesheet" />

	<!-- jQuery Library -->
	<script type="text/javascript" src="https://code.jquery.com/ui/jquery-ui-git.js"></script>
	<!-- <script type="text/javascript" src="js/jquery/jquery-ui.js"></script> -->
	<script type="text/javascript" src="js/jquery/window/jquery.window.js"></script>

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