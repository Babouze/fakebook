<?php

/* Classe Outils en lien avec l'entité utilisateur
	composée de méthodes statiques
*/

class chatTable
{
	/*
	 * Auteur : GARAYT Thomas
	 */
	public static function getLastChat()
	{
		$em = dbconnection::getInstance()->getEntityManager();

		$chatRepository = $em->getRepository('chat');
		$chat = $chatRepository->findBy(array(), array('id' => 'desc'), 1);	
		
		if($chat == false)
		{
			$context->message = "Il n'y a aucun chat";
		}
		return $chat;
	}

	/*
	 * Auteur : GARAYT Thomas
	 */
	public static function getChats()
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$chatRepository = $em->getRepository('chat');
		$chats = $chatRepository->findAll();	
		
		if($chats == false)
		{
			$context->message = "Il n'y a aucun chat";
		}
		return $chats; 
	}

	/*
	 * Auteur : GARAYT Thomas
	 */
	public static function setNewChat($message,$idUser)
	{
		$em = dbconnection::getInstance()->getEntityManager();

		$chatRepository = $em->getRepository('chat');
		$utilisateurRepository = $em->getRepository('utilisateur');

	 	$utilisateur = $utilisateurRepository->findOneById($idUser);

		$newChat = new chat;
		$newPost = new post;

		$newPost->texte = $message;
		$newPost->date = new DateTime();

		$em->persist($newPost);
		$em->flush();

		$newChat->post = $newPost;
		$newChat->emetteur =  $utilisateur;

		$em->persist($newChat);
		$em->flush();

		return $newChat; 
	}
}

?>
