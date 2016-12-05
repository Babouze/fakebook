<?php
/*
*
*/

class messageTable
{
	public static function getMessageByUser($idUser)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$messageRepository = $em->getRepository('message');

		$listOfMessage = array();

		// On récupère la liste des messages dont l'utilisateur est le destinataire mais aussi l'émetteur
		$listOfMessageDestinataire = $messageRepository->findByDestinataire($idUser);
		$listOfMessageEmetteur = $messageRepository->findByEmetteur($idUser);

		foreach($listOfMessageDestinataire as $message) {
			array_push($listOfMessage,$message);
		}

		foreach($listOfMessageEmetteur as $message) {
			$isHere = false;
			foreach($listOfMessage as $messageInArray) {
				if($messageInArray->id == $message->id) {
					$isHere = true;
				}
			}
			if($isHere == false) {
				array_push($listOfMessage,$message);
			}

		}

		if(!empty($listOfMessage))
		{
			$context->message = "Aucun message pour cet utilisateur";
		}

		return $listOfMessage;
	}

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function getMessages()
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$messageRepository = $em->getRepository('message');

		$listOfMessage = $messageRepository->findAll();

		if(!empty($listOfMessage))
		{
			//$context->message = "Aucun message";
		}

		return $listOfMessage;
	}

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function setNewMessage($idUser,$texte,$image) {

			$em = dbconnection::getInstance()->getEntityManager() ;

			$messageRepository = $em->getRepository('message');
			$utilisateurRepository = $em->getRepository('utilisateur');

		 	$utilisateur = $utilisateurRepository->findOneById($idUser);

			$newMessage = new message;
			$newPost = new post;

			$newPost->texte = $texte;
			$newPost->image = $image;
			$newPost->date = new DateTime();

			$em->persist($newPost);
			$em->flush();

			$newMessage->post = $newPost;
			$newMessage->emetteur = $utilisateur;
			$newMessage->parent = $utilisateur;
			$newMessage->destinataire = $utilisateur;
			$newMessage->aime = 0;

			$em->persist($newMessage);
			$em->flush();

			return $newMessage; 
	}

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function setNewMessageOnFriend($idUser,$texte,$image,$idDest) {

			$em = dbconnection::getInstance()->getEntityManager() ;

			$messageRepository = $em->getRepository('message');
			$utilisateurRepository = $em->getRepository('utilisateur');

		 	$utilisateur = $utilisateurRepository->findOneById($idUser);
		 	$destinataire = $utilisateurRepository->findOneById($idDest);

			$newMessage = new message;
			$newPost = new post;

			$newPost->texte = $texte;
			$newPost->image = $image;
			$newPost->date = new DateTime();

			$em->persist($newPost);
			$em->flush();

			$newMessage->post = $newPost;
			$newMessage->emetteur = $utilisateur;
			$newMessage->parent = $utilisateur;
			$newMessage->destinataire = $destinataire;
			$newMessage->aime = 0;

			$em->persist($newMessage);
			$em->flush();

			return $newMessage; 
	}
}

?>
