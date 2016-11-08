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
		
		if ($user == false)
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
		
		if ($user == false)
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
		$users = $userRepository->findAll();	
		
		if ($users == false)
		{
			$context->message = "L'utilisateur n'existe pas";
		}
		return $users; 
	}
}

?>
