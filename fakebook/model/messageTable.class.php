<?php
/*
*
*/

class messageTable
{
	/*
	 * Author : DAUDEL Adrien
	 */
	public static function getMessageByUser($idUser)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$messageRepository = $em->getRepository('message');

		$listOfMessage = array();

		// On récupère la liste des messages dont l'utilisateur est le destinataire mais aussi le parent
		$listOfMessageDestinataire = $messageRepository->findByDestinataire($idUser, array('id' => 'desc'));
		$listOfMessageParent = $messageRepository->findByParent($idUser, array('id' => 'desc'));

		foreach($listOfMessageDestinataire as $message) {
			array_push($listOfMessage,$message);
		}

		foreach($listOfMessageParent as $message) {
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

		/* if(!empty($listOfMessage))
		{
			$context->message = "Aucun message pour cet utilisateur";
		} */

		return $listOfMessage;
	}

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function getMessages()
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$messageRepository = $em->getRepository('message');

		$listOfMessage = $messageRepository->findBy(array(), array('id' => 'desc'));

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

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function jaime($idMessage)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$messageRepository = $em->getRepository('message');

		$message = $messageRepository->findOneById($idMessage);

		$message->aime++;

		$aime = $message->aime;

		$em->persist($message);
		$em->flush();

		return $aime;
	}

	/*
	 * Author : DAUDEL Adrien
	 */
	public static function partage($idMessage)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$messageRepository = $em->getRepository('message');
		$utilisateurRepository = $em->getRepository('utilisateur');

		$message = $messageRepository->findOneById($idMessage);
		$emetteur = $utilisateurRepository->findOneById(context::getSessionAttribute('id'));

		$newMessage = new message;
		$newMessage->post = $message->post;
		$newMessage->parent = $message->parent;
		$newMessage->destinataire = $message->destinataire;
		$newMessage->aime = 0;
		$newMessage->emetteur = $emetteur;

		$em->persist($newMessage);
		$em->flush();

		return $newMessage;
	}

}

?>
