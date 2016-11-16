<!-- Auteur : GARAYT Thomas -->

<div id="live-chat" style="z-index: 1000;">
	<header class="clearfix">
		<h4>Chat</h4>
		<span class="chat-message-counter">3</span>
	</header>
	<div class="chat">
		<div id="chatHistory"  class="chat-history">

		</div>
		<fieldset class="fieldsetChat">
			<input id="messageChat" type="text" placeholder="Votre message" autofocus>
			<input type="hidden">
		</fieldset>
	</div>
</div>

<script>
	/* Timer pour le rafraichissement du chat toutes les 2 secondes */
	var timerChat = setInterval(refreshChat(false), 2000);

	/* On rafraichit une premiere fois en scrollant en bas du chat */
	refreshChat(true);

	$('.chat').hide();
	$('.chat-message-counter').show();
	$("#chatHistory").scrollTop($("#chatHistory")[0].scrollHeight);	

	/* On cache le gif de loading */
	$('#loaderMessage').hide();

	/* Fonction qui va requeter la base de donnée pour rafraichir le chat */
	function refreshChat(scrollBottom) {
		$.ajax({
			type:'POST',
			async: true,
			url:'Afakebook.php?action=refreshChat',
			cache: false,
			success: function(returnData) {
				// alert(returnData);
				$("#chatHistory").html(returnData);	
				if(scrollBottom == true) {
					$("#chatHistory").scrollTop($("#chatHistory")[0].scrollHeight);
				}
				<!-- TODO -->
				// récupérer les nouveaux messages et non pas tous les messages
				// afficher seulement les nouveaux messages
			}
		})
	}

	/* Soumission du message du chat lorsque l'on appuie sur "Enter" */
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        sendMessageChat();
	    }
	});

	/* Fonction permet de requeter la base de donnée pour enregister un nouveau message */
	function sendMessageChat() {

		$('#loaderMessage').show();

		// Message to send
		DATA = $("#messageChat").val();

		if(DATA != "") {

		    $("#messageChat").val('');

			$.ajax({
				type:'POST',
				async: true,
				data: { DATA } ,
				url:'Afakebook.php?action=sendMessage',
				cache: false,
				success: function(returnData) {
					$('#loaderMessage').hide();

					refreshChat(true);


				}
			})
		}
	}


	(function() {

		$('#live-chat header').on('click', function() {

			$("#chatHistory").scrollTop($("#chatHistory")[0].scrollHeight);		
			$('.chat').slideToggle(300, 'swing');
			$('.chat-message-counter').fadeToggle(300, 'swing');
		});
	}) ();

</script>
