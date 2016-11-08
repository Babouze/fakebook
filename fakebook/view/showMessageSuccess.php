
	Message de <?php echo context::getSessionAttribute('nom') . " " . context::getSessionAttribute('prenom') . "(" . context::getSessionAttribute('identifiant') . ")"; ?> : <br>
<?php

	if($context->listOfMessages) {
		foreach($context->listOfMessages as $message) {
?>
		--> <?php echo $message->post->texte; ?> par <?php echo $message->emetteur->nom . " " . $message->emetteur->prenom; ?>
<?php
		}
	}
	else {
?>
	Aucun message !
<?php
	}
?>