<!-- Author : DAUDEL Adrien -->
<div class="wrapper">
		<div class="header header-filter" style="background-image: url('images/bg3.jpeg');"></div>

		<div class="main main-raised">
			<div class="profile-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-xs-12 col-sm-12" id="profile-card">
							<?php if($context->profile->avatar != "")
							{
								echo '<img id="imgProfile" style="max-height : 150px; max-width : 200px;" src="'.$context->profile->avatar.'" alt="Votre avatar"';
								if($_GET['id'] == context::getSessionAttribute('id'))
									echo ' data-toggle="modal" data-target="#myModal" title="Cliquez pour modifier" class="imgProfile img-rounded img-responsive img-raised imgProfileH">';
								else
									echo 'class="imgProfile img-rounded img-responsive img-raised" title="Avatar de l\'utilisateur">';
							}
							else
							{
								echo '<img id="imgProfile" style="max-height : 150px; max-width : 200px;" src="https://pedago02a.univ-avignon.fr/~uapv1400724/images/default-avatar" alt="Avatar"';
								if($_GET['id'] == context::getSessionAttribute('id'))
									echo ' data-toggle="modal" data-target="#myModal" title="Cliquez pour modifier" class="imgProfile imgProfileH img-rounded img-responsive img-raised imgProfileH">';
								else
									echo 'class="imgProfile img-rounded img-responsive img-raised" title="Avatar de l\'utilisateur">';
							} ?>
							<div class="caption">
								<h3><?php echo $context->profile->nom." ".$context->profile->prenom; ?></h3>
								<p><?php echo date_format($context->profile->date_de_naissance, 'd-m-Y'); ?></p>
								<p id="myStatut"> <?php if($context->profile->statut != "") echo htmlspecialchars($context->profile->statut,ENT_NOQUOTES); ?></p>
							</div>
						</div>
						<?php if($_GET['id'] != context::getSessionAttribute('id')) { ?>
							<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
								<form id="postForm" name="postForm" method="POST" enctype="multipart/form-data">
								<div class="form-group label-floating is-empty">
									<label for="post" class="control-label">Postez un message</label>
									<input type="text" class="form-control" id='message' name="message" />
									<input type="hidden" id="destinataire" name="destinataire" value="<?php echo $_GET['id']; ?>" />
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
						<?php } else { ?>
<!-- Auteur : GARAYT Thomas -->
							<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
								<form id="updateStatut" method="post" enctype="multipart/form-data">
									<div class="form-group label-floating is-empty">
										<label for="post" class="control-label">Modifier votre statut</label>
										<input id="statut" type="text" class="form-control" name="post" />
										<input type="hidden" id="destinataire" name="destinataire" value="<?php echo $_GET['id']; ?>" />
										<span class="material-input"></span>
									</div>
									<input class="btn btn-danger" type="submit" name="post" value="Valider">
								</form>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
<!-- Author : DAUDEL Adrien -->
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
										if(!empty($message->post->image))
										{
											echo '<img class="img-rounded" style="max-height:300px;" src="'.$message->post->image.'" alt="Image du post">';
										}
										echo '<div class="card-block">';
											echo '<h4 class="card-title">';
											if($message->emetteur->id != $message->parent->id)
												echo $message->emetteur->nom." ".$message->emetteur->prenom."<br/>";
											echo $message->parent->nom." ".$message->parent->prenom;
											if($message->parent->id != $message->destinataire->id) {
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
				</div>
			</div>
		</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="updateAvatar" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="material-icons">clear</i>
				</button>
				<h4 class="modal-title">Changer l'avatar</h4>
			</div>
			<div class="modal-body">
				<form id="modalForm" name="modalForm" method="POST" enctype="multipart/form-data">
					<div class="form-group label-floating is-fileinput">
						<input type="file" id='avatar' name="avatar" accept="image/*" />
						<input type="text" id="avatar-text" readonly class="form-control" placeholder="Choisir une image..">
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-danger btn-simple" value="changer">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
// Auteur : DAUDEL Adrien
	setInterval('refreshMessages(false)', 2000);

	var lastId = 0;
	var id = $('#destinataire').val(); // $_GET['id']

	$('#modalForm').submit(function(e) {
		e.preventDefault()
		
		var formData = new FormData(document.getElementById("modalForm"));

		if($('#avatar').val() != "")
		{
			$.ajax({
				type:'POST',
				async: true,
				data: formData,
				url:'Afakebook.php?action=updateAvatar',
				cache: false,
				processData: false,  // indique à jQuery de ne pas traiter les données
				contentType: false,   // indique à jQuery de ne pas configurer le contentType
				success: function(returnData) {
					toastr["success"]("Avatar changé");
					$('#avatar-text').val("");
					$('#imgProfile').attr('src',returnData);
					$('#myModal').modal('hide');
				},
				error: function(returnData) {
					toastr["error"]("Erreur lors du changement de l'image");
				}
			})
		}
		else {
			toastr["warning"]("Veuillez choisir une image");
		}
	});

// Auteur : GARAYT Thomas
	$('#updateStatut').submit(function(e) {
		e.preventDefault()
		
		var statut = $('#statut').val();

		$('#myStatut').css("animation","");
		
		$.ajax({
			type:'POST',
			async: true,
			data: { statut } ,
			url:'Afakebook.php?action=updateStatut',
			cache: false,
			success: function(returnData) {
				$('#myStatut').html(statut);
				$('#myStatut').css("animation","animUpdate 1s 1");
				$('#statut').val("");
				toastr["success"]("Statut mis à jour");	
			},
			error: function(returnData) {
				toastr["error"]("Erreur lors de la mise à jour du statut");	
			}
		})
	});

// Auteur : DAUDEL Adrien
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
				url:'Afakebook.php?action=postNewMessageOnFriend',
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

// Auteur : DAUDEL Adrien
	function refreshMessages(getMessages) {
			$.ajax({
			type:'POST',
			async: true,
			data: { id, getMessages },
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
</script>