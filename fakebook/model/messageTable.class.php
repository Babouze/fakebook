<?php
/*
*
*
*/

class messageTable
{
	public static function getMessageByUser($idUser)
	{
		$em = dbconnection::getInstance()->getEntityManager() ;

		$messageRepository = $em->getRepository('message');

		// $listOfMessage = $messageRepository->findAll();
		$listOfMessage = $messageRepository->findBy(array('emetteur' => $idUser));
		// $listOfMessageDestinataire = $messageRepository->findBy(array('destinataire' => $idUser));	
		// $listOfMessage = $messageRepository->findByEmetteur($idUser);;

		/*array_push($listOfMessage,$listOfMessageEmetteur);	
		array_push($listOfMessage,$listOfMessageDestinataire);*/

		
		if($listOfMessage == false)
		{
			$context->message = "Aucun message pour cet utilisateur";
		}

		return $listOfMessage; 
	}
}

?>
