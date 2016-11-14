<!-- Auteur : GARAYT Thomas -->

<div id="live-chat">
	<header class="clearfix">
		<a href="#" class="chat-close">x</a>
		<h4>Chat</h4>
		<span class="chat-message-counter">3</span>
	</header>
	<div class="chat">
		<div id="chatHistory"  class="chat-history">

			<hr>

		</div>
		<form action="#" method="post">
			<fieldset>
				<input type="text" placeholder="Votre message" autofocus>
				<input type="hidden">
			</fieldset>
		</form>
	</div> <!-- end chat -->
</div> <!-- end live-chat -->


<script>


	var timerChat = setInterval(refreshChat, 2000);

	function refreshChat() {

		$.ajax({
			type:'POST',
			async: true,
			url:'Afakebook.php?action=refreshChat',
			cache: false,
			success: function(returnData) {
				// alert(returnData);
				$("#chatHistory").html(returnData);
				// récupérer les nouveaux messages et non pas tous les messages
				// afficher seulement les nouveaux messages
			},
			error: function(data) {
				alert("ERROR");
			}
		})

	}

	function refreshChatError() {
		console.log("Error");
	}

	function refreshChatSuccess() {
		$("#chatHistory").append("bidule<br>");		
	}

	(function() {

		$('#live-chat header').on('click', function() {
			$('.chat').slideToggle(300, 'swing');
			$('.chat-message-counter').fadeToggle(300, 'swing');
		});

		$('.chat-close').on('click', function(e) {
			e.preventDefault();
			$('#live-chat').fadeOut(300);
		});

	}) ();

</script>