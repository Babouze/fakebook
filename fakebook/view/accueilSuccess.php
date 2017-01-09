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
								echo '<img class="img-rounded img-responsive img-raised" style="max-height : 150px; max-width : 200px;" src="https://pedago02a.univ-avignon.fr/~uapv1400724/images/default-avatar.png" alt="Votre avatar">';
							} ?>
							<div class="caption">
								<h3><?php echo context::getSessionAttribute('nom')." ".context::getSessionAttribute('prenom'); ?></h3>
								<p><?php echo date_format(context::getSessionAttribute('date_de_naissance'), 'd-m-Y'); ?></p>
								<?php if(context::getSessionAttribute('statut') != "") echo '<p>'.context::getSessionAttribute('statut').'</p>'; ?>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
							<form id="postForm" name="postForm" method="POST" enctype="multipart/form-data">
								<div class="form-group label-floating is-empty">
									<label for="post" class="control-label">Postez un message</label>
									<textarea type="text" class="form-control" id='message' name="message" /></textarea>
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

<!-- Auteur : DAUDEL Adrien -->
			<div class="container">
				<div class="row">
					<div class="col-lg-1 col-md-1 col-xs-1 col-sm-1">
					</div>
					<div class="col-lg-10 col-md-10 col-xs-10 col-sm-10" id="listOfMessages">
						<?php
							if($context->listOfMessages)
							{
								foreach($context->listOfMessages as $message)
								{
									echo '<div class="card">';
										echo '<div class="card-block">';
										if($message->parent != null && $message->post != null && $message->emetteur != null) // On n'affiche pas les messages qui ne sont pas dans le bon format.
										{
											echo '<h4 class="card-title">';

											if($message->emetteur->id != $message->parent->id) { ?>
												<span class="linkprofile" onclick="goToProfile(<?php echo $message->emetteur->id ?>)" >
												<?php echo $message->emetteur->nom . " " . $message->emetteur->prenom . "</span>";
											}

											echo '<span class="text-muted pull-right">' . date_format($message->post->date, "Y-m-d H:i:s") . '</span>';
											
											if($message->emetteur->id != $message->parent->id) {
												echo "</br>";
											}
											?>
												<span class="linkprofile" onclick="goToProfile(<?php echo $message->parent->id ?>)" >
											<?php	
												echo $message->parent->nom." ".$message->parent->prenom . "</span>";
											if($message->parent->id != $message->destinataire->id) {
												echo ' <i class="arrowMessage material-icons">keyboard_arrow_right</i> ';
											?>
												<span class="linkprofile" onclick="goToProfile(<?php echo $message->destinataire->id ?>)" >
											<?php
												echo $message->destinataire->nom . " " . $message->destinataire->prenom . "</span>";
												echo '</h4>';
											}
											else {
												echo '</h4>';
											}

											echo '<p class="card-text">' . nl2br(htmlspecialchars($message->post->texte,ENT_NOQUOTES)) . '</p>';
										}
										else
											echo '<h4>Format du message incorrect</h4>';
										echo '</div>';

										if(!empty($message->post->image))
										{
											echo '<img class="img-rounded" style="max-height:300px;" src="'.$message->post->image.'" alt="Image du post">';
										}

										echo '<div class="card-block pull-right">';

											if($message->aime == "" || $message->aime == null) $message->aime = 0;
											echo '<span id="aime'.$message->id.'">'.$message->aime.'</span> <a onClick="jaime('.$message->id.')" class="card-link btn btn-sm btn-danger">J\'aime</a> <a onClick="partage('.$message->id.')" class="card-link btn btn-sm btn-danger">Partager</a>';

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
					<div class="col-lg-offset-5 col-xl-offset-5 col-md-offset-5 col-sm-offset-2 col-xs-offset-2">
						<input type="hidden" id="limit" value="10">
						<button class="btn btn-danger" onClick="loadMorePosts();">Charger plus de posts</button>
					</div>
				</div>
			</div>
		</div>
</div>

<script type="text/javascript">
// Auteur : DAUDEL Adrien
	setInterval('refreshMessages(false)', 2000);

	var lastId = 0;

	$('#postForm').submit(function(e) {
		e.preventDefault()
		
		var formData = new FormData(document.getElementById("postForm"));

		var message = $("#message").val();

		if(message != "")
		{
			$.ajax({
				type:'POST',
				async: true,
				data: formData,
				url:'Afakebook.php?action=postNewMessage',
				cache: false,
				processData: false,  // indique à jQuery de ne pas traiter les données
				contentType: false,   // indique à jQuery de ne pas configurer le contentType
				success: function(returnData) {
					toastr["success"]("Message posté");	
					$('#message').val("");
					$('#image-text').val("");
				},
				error: function(returnData) {
					toastr["error"]("Erreur lors de l'envoi du message");	
				}
			})
		}
		else {
			toastr["warning"]("Veuillez remplir le champ message");	
		}
	});

// Auteur : DAUDEL Adrien & GARAYT Thomas
	function loadMorePosts() {
		$('#limit').val(parseInt($('#limit').val()) + 10);
		refreshMessages(true);
	}

// Auteur : DAUDEL Adrien
	function refreshMessages(getMessages) {
			var limit = $('#limit').val();
			$.ajax({
			type:'POST',
			async: true,
			data: { getMessages, limit },
			url:'Afakebook.php?action=refreshMessages',
			cache: false,
			success: function(returnData) {
				if(getMessages == true)
					$('#listOfMessages').html(returnData);
				else if(returnData != lastId && lastId != 0)
				{
					lastId = returnData;
					toastr.options.timeOut=-1;
					toastr.options.extendedTimeOut=-1;
					toastr.info("<p onclick='refreshMessages(true)'>Nouveaux posts, cliquez pour charger</p>");
					toastr.options.timeOut=6;
					toastr.options.extendedTimeOut=6;
				}
				else
					lastId = returnData;
			}
		})
	}

// Auteur : GARAYT Thomas
	function goToProfile(idprofile) {
		window.open("fakebook.php?action=profile&id=" + idprofile, "_blank");
	}
</script>