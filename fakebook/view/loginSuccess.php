
<div class="col-lg-4"></div>
<div class="col-lg-2">
	<form method="post" enctype="multipart/form-data" action="fakebook.php?action=login">
		
		<div class="input-group">
			<input name="login" type="text" class="form-control" placeholder="Nom d'utilisateur" aria-describedby="basic-addon1" aria-required="true">
		</div>

		<div class="input-group">
			<input name="password" type="password" class="form-control" placeholder="Mot de passe" aria-describedby="basic-addon1" aria-required="true">
		</div>
		<div class="input-group">
			<button type="submit" class="btn">Se connecter</button>
		</div>
	</form>
	<div class="row">
			<h4 class="red"><?php echo $context->message; ?></H4>

	</div>
</div>
<div class="col-lg-4"></div>