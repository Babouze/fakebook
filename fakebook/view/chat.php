<!-- Auteur : GARAYT Thomas -->

<div id="live-chat" style="z-index: 1000;">
	<header class="clearfix">
		<a href="#" class="chat-close">x</a>
		<h4>Chat</h4>
		<span class="chat-message-counter">3</span>
	</header>
	<div class="chat">
		<div id="chatHistory"  class="chat-history">

			<hr>

		</div>
			<fieldset>
				<input id="messageChat" type="text" placeholder="Votre message" autofocus>
				<input type="hidden">
			</fieldset>
	</div> <!-- end chat -->
</div> <!-- end live-chat -->

<!--
TOUTDOUX:
	- Mettre un loader pendant les deux secondes avant le timer.
	- Mettre le z-index du chat dans le css
-->
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
			}
		})

	}

	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        sendMessageChat();
	    }
	});


	function sendMessageChat() {

		// TODO : Loader send show

		// Message to send
		DATA = $("#messageChat").val();

		if(DATA != "") {

			$.ajax({
				type:'POST',
				async: true,
				data: { DATA } ,
				url:'Afakebook.php?action=sendMessage',
				cache: false,
				success: function(returnData) {
					// TODO : Loader send hide
					refreshChat();
				}
			})
		}
	}

	function refreshChatError() {
		console.log("Error");
	}

	function refreshChatSuccess() {
		$("#chatHistory").append("bidule<br>");		
	}

	$('.chat').hide();

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
