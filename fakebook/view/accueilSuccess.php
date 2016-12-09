<!-- Author : DAUDEL Adrien -->
<div class="wrapper">
		<div class="header header-filter" style="background-image: url('images/bg2.jpeg'); background-size: cover; background-repeat: no-repeat;"></div>

		<div class="main main-raised">
			<div class="profile-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-xs-12 col-sm-12" id="profile-card">
							<?php if(context::getSessionAttribute('avatar') != "")
							{
								echo '<img class="img-rounded img-responsive img-raised" style="max-height : 150px; max-width : 200px;" src="'.context::getSessionAttribute('avatar').'" alt="Votre avatar">';
							}
							else
							{
								echo '<img class="img-rounded img-responsive img-raised" style="max-height : 150px; max-width : 200px;" src="https://pedago02a.univ-avignon.fr/~uapv1400724/images/default-avatar" alt="Votre avatar">';
							} ?>
							<div class="caption">
								<h3><?php echo context::getSessionAttribute('nom')." ".context::getSessionAttribute('prenom'); ?></h3>
								<p><?php echo date_format(context::getSessionAttribute('date_de_naissance'), 'd-m-Y'); ?></p>
								<?php if(context::getSessionAttribute('statut') != "") echo '<p>'.context::getSessionAttribute('statut').'</p>'; ?>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
							<form id="postForm" method="POST" enctype="multipart/form-data">
								<div class="form-group label-floating is-empty">
									<label for="post" class="control-label">Postez un message</label>
									<input type="text" class="form-control" id='message' name="message" />
									<span class="material-input"></span>
								</div>
								<div class="form-group label-floating is-fileinput">
									<!-- <label class="control-label" for="image">Ajouter une image</label> -->
									<input type="file" id='image' name="image" accept="image/*" />
									<input type="text" id="image-text" readonly class="form-control" placeholder="Ajouter une image..">
								</div>
								<input class="btn btn-danger" type="submit" name="post" value="Poster">
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="container"><!-- Author : DAUDEL Adrien -->
				<div class="row">
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
											echo '<h4 class="card-title">';
											if($message->emetteur->id != $message->parent->id)
												echo $message->parent->nom." ".$message->parent->prenom."<br/>";
											echo $message->emetteur->nom." ".$message->emetteur->prenom;
											if($message->emetteur->id != $message->destinataire->id) {
												echo ' <i class="arrowMessage material-icons">keyboard_arrow_right</i> ' . $message->destinataire->nom . " " . $message->destinataire->prenom ;
												echo '</h4>';
											}
											else {
												echo '</h4>';
											}
											echo '<p class="card-text">'.$message->post->texte.'<p class="text-muted">'.date_format($message->post->date, "Y-m-d H:i:s").'</p></p>';
										echo '</div>';
										echo '<div class="card-block pull-right">';
										if($message->aime == "" || $message->aime == null) $message->aime = 0;
											echo '<div id="like' . $message->id .  '"> $message->aime.' </div> <a onClick="likeMessage(' . $message->id . ')" class="btnLike card-link btn btn-sm btn-danger">J\'aime</a> <a href="#" class="card-link btn btn-sm btn-danger">Partager</a>';
										echo '</div>';
									echo '</div>';
								}
							}
							else
							{
								echo '<div class="card">Aucun message !</div>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
</div>
<script type="text/javascript">
	$('#postForm').submit(function(e) {
		e.preventDefault()
		
		var message = $('#message').val();
		var image = $('#image').val();

		if(message != "")
		{
			$.ajax({
				type:'POST',
				async: true,
				data: { message, image } ,
				url:'Afakebook.php?action=postNewMessage',
				cache: false,
				success: function(returnData) {
					// alert(returnData);
					$('#message').val("");
					$('#image-text').val("");
				}
			})
		}
		else
			alert("Veuillez remplir le champ message");
	});

	function likeMessage(idMessage) {
		alert(idMessage);

		$.ajax({
			type:'POST',
			async: true,
			data: { idMessage } ,
			url:'Afakebook.php?action=likeMessage',
			cache: false,
			success: function(returnData) {
				alert("Message liké");

				// TODO : update le compteur de like


			}
		})
	}
</script>
