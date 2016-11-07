<div class="col-lg-12 centered">
	<?php 
		echo "<h2>Bonjour ".context::getSessionAttribute('nom')." ".context::getSessionAttribute('prenom')."</h2>";
		/*if(isset($context->message))*/ echo $context->message;
	?>
	<button class="btn btn-danger" onClick="logout()">Déconnexion</button>
</div>

<script type="text/javascript">
	function logout()
	{
		$.ajax({
			type:'POST',
			url:'Afakebook.php?action=logout',
			cache:'false'

		})
	}
</script>