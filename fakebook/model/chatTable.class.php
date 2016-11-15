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
	public static function getChats($limit = 100)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$chatRepository = $em->getRepository('chat');
		$chats = $chatRepository->findAll(array(),array(),$limit);	
		
		if($chats == false)
		{
			$context->message = "Il n'y a aucun chat";
		}
		return $chats; 
	}

	/*
	 * author : GARAYT Thomas
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

		// $idPost = $newPost->id;

		$newChat->post = $newPost;
		$newChat->emetteur =  $utilisateur;

		$em->persist($newChat);
		$em->flush();

		return $newChat; 
	}


	public static function flushEntity($entity) {
		$em = dbconnection::getInstance()->getEntityManager();
		$em->persist($entity);
		$em->flush();
	}

}

?>
