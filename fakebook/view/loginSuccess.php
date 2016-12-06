<script type="text/javascript">
	$('body').css('background-image', 'url(\'images/bg.jpg\')');
	$('body').css('background-size', 'cover');
	$('body').css('background-repeat', 'no-repeat');
</script>

<div class="wrapper" id="login-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
				<div class="card card-signup">
					<form class="form" method="post" action="fakebook.php?action=login" enctype="multipart/form-data">
						<div class="header-logo header header-primary text-center">
							<h4><img style="position: relative; left: 12%;" src="images/banner.png" width="80%"></h4>
						</div>
						<div class="content">

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">face</i>
								</span>
								<input name="login" type="text" class="form-control" placeholder="Nom d'utilisateur" aria-describedby="basic-addon1" aria-required="true">
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">lock_outline</i>
								</span>
								<input name="password" type="password" class="form-control" placeholder="Mot de passe" aria-describedby="basic-addon1" aria-required="true">
							</div>
							<h4 class="red"><?php if(!empty($context->message)) echo '<div class="row">'.$context->message.'</div>'; ?></h4>
						</div>
						<div class="footer text-center">
							<button type="submit" class="btn btn-simple btn-primary btn-lg">Se connecter</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
