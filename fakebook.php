<?php
ini_set('error_reporting', 'E_STRICT');

//nom de l'application
$nameApp = "fakebook";

// Inclusion des classes et librairies
require_once 'lib/core.php';
require_once $nameApp.'/controller/mainController.php';

session_start();

$action = "login";
if(context::isConnect()) // Si l'action est vide et que l'utilisateur est connecté
	$action = "accueil";

if(key_exists("action", $_REQUEST))
	$action =  $_REQUEST['action'];

if(!context::isConnect()) // Si l'utilisateur n'est pas connecté et qu'il essaie d'accéder à une page dont il n'a pas l'accès
	$action = "login";

if(context::isConnect() && $action == "login") // Si un utilisateur connecté essaie d'accéder à la page de login
	$action = "accueil";

$context = context::getInstance();
$context->init($nameApp);

$view=$context->executeAction($action, $_REQUEST);

//traitement des erreurs de bases, reste a traiter les erreurs d'inclusion
if($view===false){
	echo "Une grave erreur s'est produite, il est probable que l'action ".$action." n'existe pas...";
	die;
}

//inclusion du layout qui va lui meme inclure le template view
elseif($view!=context::NONE){
	$template_view=$nameApp."/view/".$action.$view.".php";
	include($nameApp."/view/".$context->getLayout().".php");
}

?>
