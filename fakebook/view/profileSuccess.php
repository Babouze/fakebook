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
								<?php if($context->profile->statut != "") echo '<p>'.$context->profile->statut.'</p>'; ?>
							</div>
						</div>
						<?php if($_GET['id'] != context::getSessionAttribute('id')) { ?>
							<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
								<form action="Afakebook.php?action=post" method="post" enctype="multipart/form-data">
									<div class="form-group label-floating is-empty">
										<label for="post" class="control-label">Postez un message</label>
										<input type="text" class="form-control" name="post" />
										<span class="material-input"></span>
									</div>
									<div class="form-group label-floating is-fileinput">
										<!-- <label class="control-label" for="image">Ajouter une image</label> -->
										<input type="file" name="image" accept="image/*" />
										<input type="text" readonly class="form-control" placeholder="Ajouter une image..">
									</div>
									<input class="btn btn-danger" type="submit" name="post" value="Poster">
								</form>
							</div>
						<?php } else { ?>
							<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
								<form action="Afakebook.php?action=statut" method="post" enctype="multipart/form-data">
									<div class="form-group label-floating is-empty">
										<label for="post" class="control-label">Modifier votre statut</label>
										<input type="text" class="form-control" name="post" />
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
								echo '<div class="card">Aucun message !</div>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
