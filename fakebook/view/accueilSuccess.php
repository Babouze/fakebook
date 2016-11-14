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
	<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1">
	</div>
	<div class="col-lg-10 col-md-10 col-xs-10 col-sm-10">
		<?php
			if($context->listOfMessages)
			{
				foreach($context->listOfMessages as $message)
				{
					echo '<div class="card">';
						if(!empty($message->post->image))
						{
							echo '<img class="card-img-top" src="..." alt="Image du post">';
						}
						echo '<div class="card-block">';
							echo '<h4 class="card-title">'.$message->emetteur->nom." ".$message->emetteur->prenom.'</h4>';
							echo '<p class="card-text">'.$message->post->texte.'</p>';
						echo '</div>';
						echo '<div class="card-block">';
							echo '<a href="#" class="card-link">J\'aime</a> <a href="#" class="card-link">Partager</a>';
						echo '</div>';
					echo '</div>';
				}
			}
			else
			{
				echo "Aucun message ! (ou loader)";
			}
		?>
	</div>
</div>
