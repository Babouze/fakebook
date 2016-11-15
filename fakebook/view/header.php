<nav class="navbar navbar-transparent navbar-fixed-top navbar-color-on-scroll">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only"><i class="material-icons">unarchive</i></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="fakebook.php">Fakebook</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="fakebook.php?action=accueil">Accueil<span class="sr-only">(current)</span></a></li>
				<li><a href="#">Profil<span class="sr-only"></span></a></li>
				<li><button class="btn btn-primary btn-danger" onClick="logout()">Déconnexion</button></li>
			</ul>
		</div>
	</div>
</nav>


<?php 
	/*if(isset($context->message))*/ echo $context->message;
?>

<script type="text/javascript">
	function logout()
	{
		$.ajax({
			type:'POST',
			url:'Afakebook.php?action=logout',
			cache:'false',
			succces: function(returnHtml) {
			}
		})
		window.location.replace("fakebook.php");
	}
</script>
