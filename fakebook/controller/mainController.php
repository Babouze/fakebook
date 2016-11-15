<?php
/*
 * All doc on :
 * Toutes les actions disponibles dans l'application 
 *
 */

class mainController
{
	public static function login($request,$context)
	{
		if(empty($_POST['login']) || empty($_POST['password']))
		{
			$context->message = "Erreur : veuillez remplir tous les champs.";

			return context::SUCCESS;
		}
		else if(isset($_POST['login']) && isset($_POST['password']))
		{
			$res = utilisateurTable::getUserByLoginAndPass($_POST['login'], $_POST['password']);
			if(!is_null($res))
			{
				$context->message = "Vous êtes désormais connecté";
				context::setSessionAttribute('id', $res->id);
				context::setSessionAttribute('identifiant', $res->identifiant);
				context::setSessionAttribute('nom', $res->nom);
				context::setSessionAttribute('prenom', $res->prenom);
				context::setSessionAttribute('statut', $res->statut);
				context::setSessionAttribute('avatar', $res->avatar);
				context::setSessionAttribute('date_de_naissance', $res->date_de_naissance);

				context::redirect('fakebook.php?action=accueil');

			}
			else {
				$context->message = "Erreur : Identifiants invalides";
				return context::SUCCESS;
			}
			// return context::SUCCESS;
		}

		return context::SUCCESS;
	}

	public static function logout($request,$context)
	{
		session_destroy();
		// context::redirect('fakebook.php');
		return context::SUCCESS;
	}

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function accueil($request	,$context)
	{
		$context->listOfMessages = messageTable::getMessages();

		return context::SUCCESS;
	}

	/*
	* Author : DAUDEL Adrien
	*/
	public static function friends($request, $context)
	{
		$listOfUsers = utilisateurTable::getUsers();

		if(!is_null($listOfUsers))
		{
			foreach($listOfUsers as $user)
			{
				if($user->avatar != '')
				{
					$av = $user->avatar;
				}
				else {
					$av = "images/default-avatar.png";
				}	
				echo '<li><a href="fakebook.php?action=profile&id='.$user->id.'"><img class="img-circle img-responsive img-raised" src="'.$av.'" alt="Avatar utilisateur" width="16" height="16">'.$user->nom." ".$user->prenom.'</a></li>';
			}
		}

		return context::SUCCESS;
    }

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function profile($request	,$context)
	{
		$context->listOfMessages = messageTable::getMessageByUser($_GET['id']);

		$context->profile = utilisateurTable::getUserById($_GET['id']);

		return context::SUCCESS;
	}

	/*
	* Auteur : GARAYT Thomas
	*/
	public static function refreshChat($request, $context) {
		
		$newChat = chatTable::getChats(5);	

		$context->listOfChat = $newChat;

		if(!is_null($newChat)) {
			foreach($newChat as $chat) {

				if($chat->emetteur->avatar != '') {
					$av = $chat->emetteur->avatar;
				}
				else {
					$av = "images/default-avatar.png";
				}	

				echo '<div class="chat-message clearfix">';
				echo '<img src="' . $av . '" alt="Avatar utilisateur" width="32" height="32">';
				echo '<div class="chat-message-content clearfix">';
				echo '<span class="chat-time">' . date_format($chat->post->date, 'Y-m-d H:i:s') . '</span>';
				echo '<h5>' . $chat->emetteur->nom . ' ' . $chat->emetteur->prenom . '</h5>';
				echo '<p>' . $chat->post->texte . '</p>';
				echo '</div>';
				echo '</div>';	
			}
		}

		return context::SUCCESS;
    }


	/*
	* Auteur : GARAYT Thomas
	*/
    public static function sendMessage($request,$context) {
    	$message = $_POST['DATA'];

    	$idUser = context::getSessionAttribute('id');

		$newChat = chatTable::setNewChat($message,$idUser);	

		return context::SUCCESS;
    }
}
