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
		$context->listOfMessages = messageTable::getMessages(10);

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
					$av = "https://pedago02a.univ-avignon.fr/~uapv1400724/images/default-avatar.png";
				}
				echo '<li><a title="' . $user->nom . " " . $user->prenom . '" href="fakebook.php?action=profile&id=' . $user->id . '"><img class="img-circle img-raised img-listeamis" src="'.$av.'" alt="Avatar utilisateur" width="16" height="16"> ' . $user->nom . " " . $user->prenom . '</a></li>';
			}
		}

		return context::SUCCESS;
    }

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function profile($request	,$context)
	{
		$context->listOfMessages = messageTable::getMessageByUser($_GET['id'], 10);

		$context->profile = utilisateurTable::getUserById($_GET['id'], 10);

		return context::SUCCESS;
	}

	/*
	* Auteur : GARAYT Thomas
	*/
	public static function refreshChat($request, $context) {

		$newChat = chatTable::getChats();

		$context->listOfChat = $newChat;

		if(!is_null($newChat)) {
			foreach($newChat as $chat)
			{
				if($chat->emetteur != null && $chat->post != null)
				{
					if($chat->emetteur->avatar != '') {
						$av = $chat->emetteur->avatar;
					}
					else {
						$av = 'https://pedago02a.univ-avignon.fr/~uapv1400724/images/default-avatar.png';
					}

					echo '<hr>';
					echo '<div class="chat-message clearfix">';
					echo '<img src="' . $av . '" alt="avatar" width="32" height="32">';
					echo '<div class="chat-message-content clearfix">';
					echo '<h5 class="titleMessageChat">' . $chat->emetteur->nom . ' ' . $chat->emetteur->prenom . '<span class="chat-time">' . date_format($chat->post->date, 'Y-m-d H:i:s') . '</span></h5>' ;
					echo '<p>' . htmlspecialchars($chat->post->texte, ENT_NOQUOTES) . '</p>';
					echo '</div>';
					echo '</div>';
					$idChat = $chat->id;
				}
				else
				{
					$av = 'https://pedago02a.univ-avignon.fr/~uapv1400724/images/default-avatar.png';

					echo '<hr>';
					echo '<div class="chat-message clearfix">';
					echo '<img src="' . $av . '" alt="avatar" width="32" height="32">';
					echo '<div class="chat-message-content clearfix">';
					echo '<h5 class="titleMessageChat">Format du chat incorrect</h5>' ;
					echo '<p></p>';
					echo '</div>';
					echo '</div>';
					$idChat = $chat->id;
				}
			}
			echo "<input class='hidden' id='lastIdChat' value='" . $idChat . "' ></input>";
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

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function postNewMessage($request,$context)
	{
		$resultat = false;
		$image = "";
		if(isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
		{
			$infosfichier = pathinfo($_FILES['image']['name']);
			$extension_upload = $infosfichier['extension'];
			$date = new DateTime();
			$image = "upload_".date_format($date, "Y-m-d_H-i-s").".".$extension_upload;
			$resultat = move_uploaded_file($_FILES["image"]["tmp_name"], "images/".$image);
		}
		if(!$resultat) $image="";
		else $image = "https://pedago02a.univ-avignon.fr/~uapv1400724/images/".$image;

		$newMessage = messageTable::setNewMessage(context::getSessionAttribute('id'), nl2br($_POST['message']), $image);
	}

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function postNewMessageOnFriend($request,$context)
	{
		$resultat = false;
		$image = "";
		if(isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
		{
			$infosfichier = pathinfo($_FILES['image']['name']);
			$extension_upload = $infosfichier['extension'];
			$date = new DateTime();
			$image = "upload_".date_format($date, "Y-m-d_H-i-s").".".$extension_upload;
			$resultat = move_uploaded_file($_FILES["image"]["tmp_name"], "images/".$image);
		}
		if(!$resultat) $image="";
		else $image = "https://pedago02a.univ-avignon.fr/~uapv1400724/images/".$image;

		$newMessage = messageTable::setNewMessageOnFriend(context::getSessionAttribute('id'), $_POST['message'], $image, $_POST['destinataire']);
		var_dump($newMessage);
	}

	/*
	* Auteur : GARAYT Thomas
	*/
	public static function updateStatut($request,$context) {
		
		$statut = $_POST['statut'];

		$idUser = context::getSessionAttribute('id');		

		context::setSessionAttribute('statut', $statut);

		utilisateurTable::updateStatut($idUser,$statut);

		return context::SUCCESS;
	}

	/*
	* Auteur : DAUDEL Adrien
	*/
	public static function jaime($request,$context)
	{
		echo messageTable::jaime($_POST['idMessage']);
	}

	/*
	* Auteur : DAUDEL Adrien
	*/
	public static function partage($request,$context)
	{
		messageTable::partage($_POST['idMessage']);
	}

	/*
	 * Auteur : DAUDEL Adrien
	 */
	public static function refreshMessages($request, $context)
	{
		if(!empty($_POST['id']))
			$context->listOfMessages = messageTable::getMessageByUser($_POST['id'], $_POST['limit']);
		else
			$context->listOfMessages = messageTable::getMessages($_POST['limit']);

		if($context->listOfMessages)
		{
			$content = "";
			$idMessage = 0;
			foreach($context->listOfMessages as $message)
			{
				if($idMessage == 0) $idMessage = $message->id;
				$content .= '<div class="card">';

					$content .= '<div class="card-block">';
						if($message->parent != null && $message->post != null && $message->emetteur != null) // On n'affiche pas les messages qui ne sont pas dans le bon format.
						{

							$content .= '<h4 class="card-title">';

							if($message->emetteur->id != $message->parent->id) {
								$content .= '<span class="linkprofile" onclick="goToProfile(' . $message->emetteur->id . ')" >';
								$content .= $message->emetteur->nom . " " . $message->emetteur->prenom;
								$content .= '</span><span class="messagePartage text-muted" > a partagé ce message</span>';
							}
								
							if($message->post->date != null) {
								$content .= '<span class="messageDate pull-right text-muted">' . date_format($message->post->date, "Y-m-d H:i:s") . '</span>';
							}
								
							if($message->emetteur->id != $message->parent->id) {
								$content .= "<br/>";
							}
								
							$content .= '<span class="linkprofile" onclick="goToProfile(' . $message->parent->id . ')" >';
							$content .= $message->parent->nom." ".$message->parent->prenom;
							$content .= '</span>';

							if($message->destinataire != null) {
								if($message->parent->id != $message->destinataire->id) {
									$content .= ' <i class="arrowMessage material-icons">keyboard_arrow_right</i> ';
									$content .= '<span class="linkprofile" onclick="goToProfile(' . $message->destinataire->id . ')" >';
									$content .= $message->destinataire->nom . " " . $message->destinataire->prenom ;
									$content .= '</span>';

									$content .= '</h4>';
								}
								else {
									$content .= '</h4>';
								}
							}

							$content .= '<p class="card-text">' . htmlspecialchars($message->post->texte,ENT_NOQUOTES);

						}
						else {
							$content .= '<h4>Format du message incorrect</h4>';
						}				

						if(!empty($message->post->image)) {
							$content .= '<img class="img-rounded" style="max-height:300px;" src="'.$message->post->image.'" alt="Image du post">';
						}

					$content .= '</div>';
					$content .= '<div class="card-block pull-right">';

						if($message->aime == "" || $message->aime == null) $message->aime = 0;
						$content .= '<span id="aime'.$message->id.'">'.$message->aime.'</span> <a onClick="jaime('.$message->id.')" class="card-link btn btn-sm btn-danger">J\'aime</a> <a onClick="partage('.$message->id.')" class="card-link btn btn-sm btn-danger">Partager</a>';

					$content .= '</div>';
				$content .= '</div>';
			}
		}
		else
		{
			$content .= '<div class="card">Aucun message !</div>';
		}
		$content .= "<input class='hidden' id='lastIdMessage' value='".$idMessage."'></input>";

		if($_POST['getMessages'] == 'true')
			echo $content;
		else
			echo $idMessage;
	}

	/*
	* Auteur : GARAYT Thomas
	*/
	public static function updateAvatar($request, $context)
	{
		$resultat = false;
		$avatar = "";
		if(isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0)
		{
			$infosfichier = pathinfo($_FILES['avatar']['name']);
			$extension_upload = $infosfichier['extension'];
			$date = new DateTime();
			$avatar = "avatar_".date_format($date, "Y-m-d_H-i-s").".".$extension_upload;
			$resultat = move_uploaded_file($_FILES["avatar"]["tmp_name"], "images/".$avatar);
		}
		if(!$resultat) $avatar="";
		else $avatar = "https://pedago02a.univ-avignon.fr/~uapv1400724/images/".$avatar;

		utilisateurTable::updateAvatar(context::getSessionAttribute('id'), $avatar);
		context::setSessionAttribute('avatar', $avatar);
		echo $avatar;
	}
}
