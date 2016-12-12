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
								echo '<img class="img-rounded img-responsive img-raised" style="max-height : 150px; max-width : 200px;" src="'.$context->profile->avatar.'" alt="Votre avatar">';
							}
							else
							{
								echo '<img class="img-rounded img-responsive img-raised" style="max-height : 150px; max-width : 200px;" src="https://pedago02a.univ-avignon.fr/~uapv1400724/images/default-avatar" alt="Votre avatar">';
							} ?>
							<div class="caption">
								<h3><?php echo $context->profile->nom." ".$context->profile->prenom; ?></h3>
								<p><?php echo date_format($context->profile->date_de_naissance, 'd-m-Y'); ?></p>
								<p id="myStatut"> <?php if($context->profile->statut != "") echo $context->profile->statut ; ?></p>
							</div>
						</div>
						<?php if($_GET['id'] != context::getSessionAttribute('id')) { ?>
							<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
								<form id="postForm" method="post" enctype="multipart/form-data">
									<div class="form-group label-floating is-empty">
										<label for="post" class="control-label">Postez un message</label>
										<input type="text" id="message" class="form-control" name="post" />
										<span class="material-input"></span>
										<input type="hidden" id="idDest" value="<?php echo $_GET['id']; ?>" />
									</div>
									<div class="form-group label-floating is-fileinput">
										<!-- <label class="control-label" for="image">Ajouter une image</label> -->
										<input type="file" id="image" name="image" accept="image/*" />
										<input type="text" id="image-text" readonly class="form-control" placeholder="Ajouter une image..">
									</div>
									<input class="btn btn-danger" type="submit" name="post" value="Poster">
								</form>
							</div>
						<?php } else { ?>
							<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
								<form id="updateStatut" method="post" enctype="multipart/form-data">
									<div class="form-group label-floating is-empty">
										<label for="post" class="control-label">Modifier votre statut</label>
										<input id="statut" type="text" class="form-control" name="post" />
										<span class="material-input"></span>
									</div>
									<input class="btn btn-danger" type="submit" name="post" value="Valider">
								</form>
							</div>
						<?php } ?>
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
<script type="text/javascript">
	$('#postForm').submit(function(e) {
		e.preventDefault()
		
		var message = $('#message').val();
		var image = $('#image').val();
		var destinataire = $('#idDest').val();

		if(message != "")
		{
			$.ajax({
				type:'POST',
				async: true,
				data: { message, image, destinataire } ,
				url:'Afakebook.php?action=postNewMessageOnFriend',
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
</script>

<script type="text/javascript">
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
				$('#myStatut').css("animation","animUpdate 3s 1");
				$('#statut').val("");
			},
			error: function(returnData) {
				alert("Erreur");
			}
		})
	});
</script>

<script type="text/javascript">
	function jaime(idMessage) {
		$('#aime' + idMessage).css("animation","");
		$.ajax({
			type:'POST',
			async: true,
			data: { idMessage } ,
			url:'Afakebook.php?action=jaime',
			cache: false,
			success: function(returnData) {
				$('#aime' + idMessage).html(returnData);
				$('#aime' + idMessage).css("animation","animUpdate 3s 1");
			},
			error: function(returnData) {
				alert("Erreur");
			}
		})
	};
</script>

<script type="text/javascript">
	function partage(idMessage) {
		$.ajax({
			type:'POST',
			async: true,
			data: { idMessage } ,
			url:'Afakebook.php?action=partage',
			cache: false,
			success: function(returnData) {
				// alert(returnData);
			},
			error: function(returnData) {
				alert("Erreur");
			}
		})
	};
</script>