<div class="container"><!-- Author : DAUDEL Adrien -->
	<div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
		<div class="thumbnail">
			<img class="media-object img-rounded" style="max-height : 150px; max-width : 200px;" src="<?php echo context::getSessionAttribute('avatar'); ?>" alt="votre avatar">
			<div class="caption">
				<h3><?php echo context::getSessionAttribute('nom')." ".context::getSessionAttribute('prenom'); ?></h3>
				<p><?php echo date_format(context::getSessionAttribute('date_de_naissance'), 'd-m-Y'); ?></p>
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
		<div class="thumbnail">
			<form action="Afakebook.php?action=post" method="post" enctype="multipart/form-data">		
				<div class="formgroup">
					<textarea name="post"></textarea>
					<input type="file" name="image" accept="image/*" />
				</div>
				<br /><br /><input class="btn btn-default" type="submit" name="post" value="Poster">
			</form>
		</div>
	</div>
</div>

<div class="container"><!-- Author : DAUDEL Adrien -->
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
		<?php
			if($context->listOfMessages)
			{
				foreach($context->listOfMessages as $message)
				{
					echo $message->post->texte." par ".$message->emetteur->nom." ".$message->emetteur->prenom;
				}
			}
			else
			{
				echo "Aucun message ! (ou loader)";
			}
		?>
	</div>
</div>
