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
		$res = chatTable::getLastChat();
		foreach($res as $r) {
			echo $r->post->texte;	
		}
		

		if(empty($_POST['login']) && empty($_POST['password']))
			return context::SUCCESS;
		else if(empty($_POST['login']) || empty($_POST['password']))
		{
			$context->message = "Erreur: veuillez remplir tous les champs.";
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
			}
			return context::SUCCESS;
		}
	}
	public static function logout($request,$context)
	{
		session_destroy();
		// context::redirect('fakebook.php');
		return context::SUCCESS;
	}
}
