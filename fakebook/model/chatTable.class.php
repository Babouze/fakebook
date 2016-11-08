<?php

/* Classe Outils en lien avec l'entité utilisateur
	composée de méthodes statiques
*/

class chatTable
{
	/*
	 * author : GARAYT Thomas
	 */
	public static function getLastChat()
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$userRepository = $em->getRepository('utilisateur');
		$user = $userRepository->findOneById($idUser);	
		
		if ($user == false)
		{
			$context->message = "Il n'y a aucun chat";
		}
		return $user; 
	}

	/*
	 * author : GARAYT Thomas
	 */
	public static function getChats()
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$chatRepository = $em->getRepository('chat');
		$chats = $chatRepository->findAll();	
		
		if ($chats == false)
		{
			$context->message = "Il n'y a aucun chat";
		}
		return $chats; 
	}
}

?>
