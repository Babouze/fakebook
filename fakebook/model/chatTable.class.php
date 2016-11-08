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

		// $qb = $em->createQueryBuilder();
		// $qb->select('c')
		// 	->from('chat', 'c')
		// 	->innerjoin('post.id', 'c', Join::ON, 'c.post = post.id')
		// 	->orderby('post.date', 'desc')
		// 	->setMaxResults('1');

		// $chat = $qb->getQuery()->getResult();

		$chatRepository = $em->getRepository('chat');
		$chat = $chatRepository->findBy(array(), array('id' => 'desc'), 1);	
		
		if($chat == false)
		{
			$context->message = "Il n'y a aucun chat";
		}
		return $chat;
	}

	/*
	 * author : GARAYT Thomas
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
}

?>
