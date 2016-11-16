<?php

/* Classe Outils en lien avec l'entité utilisateur
	composée de méthodes statiques
*/

class utilisateurTable
{
	public static function getUserByLoginAndPass($login,$pass)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$userRepository = $em->getRepository('utilisateur');
		$user = $userRepository->findOneBy(array('identifiant' => $login, 'pass' => sha1($pass)));	
		
		if(empty($user))
		{
			$context->message = "L'utilisateur n'existe pas";
		}
		return $user; 
	}

	/*
	 * author : DAUDEL Adrien
	 */
	public static function getUserById($idUser)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$userRepository = $em->getRepository('utilisateur');
		$user = $userRepository->findOneById($idUser);	
		
		if(empty($user))
		{
			$context->message = "L'utilisateur n'existe pas";
		}
		return $user; 
	}

	/*
	 * author : DAUDEL Adrien
	 */
	public static function getUsers()
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$userRepository = $em->getRepository('utilisateur');
		$users = $userRepository->findBy(array(),array('nom' => 'ASC' ));	
		
		if(empty($users))
		{
			$context->message = "L'utilisateur n'existe pas";
		}
		return $users; 
	}
}

?>
