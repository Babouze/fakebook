<script type="text/javascript">
	$(document).ready(getFriends());
	function getFriends() {

		$.ajax({
			type:'POST',
			async: true,
			url:'Afakebook.php?action=friends',
			cache: false,
			success: function(returnData) {
				$("#friends").append(returnData);
			}
		})
	}
</script>

<nav class="navbar navbar-transparent navbar-fixed-top navbar-color-on-scroll">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<i class="material-icons">menu</i>
			</button>
			<a class="navbar-brand" href="fakebook.php"><img src="images/banner.png" width="200px"></a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li <?php if($_REQUEST['action'] == 'accueil') { ?> class="active" <?php } ?>><a href="fakebook.php?action=accueil">Accueil<span class="sr-only">(current)</span></a></li>
				<li <?php if($_REQUEST['action'] == 'profile') { ?> class="active" <?php } ?>><a href="fakebook.php?action=profile&id=<?php echo context::getSessionAttribute('id'); ?>">Profil<span class="sr-only"></span></a></li>
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Amis
						<b class="caret"></b>
					<div class="ripple-container"></div></a>
					<ul class="dropdown-menu dropdown-menu-right scrollable-menu" id="friends">
						<li class="dropdown-header">Liste d'amis</li>
					</ul>
				</li>
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
				toastr["success"]("Déconnecté");	
			},
			error: function(returnHtml) {
				toastr["error"]("Erreur lors de la deconnexion");	
			}
		})
		window.location.replace("fakebook.php");
	}
</script>

    <script>
		toastr.options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": false,
		  "progressBar": false,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": false,
		  "onclick": null,
		  "showDuration": "1000",
		  "hideDuration": "1000",
		  "timeOut": "5000",
		  "extendedTimeOut": "100000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "slideDown",
		  "hideMethod": "slideUp"
		}
    </script>