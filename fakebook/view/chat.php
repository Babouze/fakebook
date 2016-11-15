<!-- Auteur : GARAYT Thomas -->

<div id="live-chat" style="z-index: 1000;">
	<header class="clearfix">
		<h4>Chat</h4>
		<span class="chat-message-counter">3</span>
	</header>
	<div class="chat">
		<div id="chatHistory"  class="chat-history">

			<hr>

		</div>
		<div class="row">
			<fieldset>
				<input id="messageChat" type="text" placeholder="Votre message" autofocus>
				<input type="hidden">
			</fieldset>
		</div>
	</div>
</div>

<!--
TOUTDOUX:
	- Mettre un loader pendant les deux secondes avant le timer.
	- Mettre le z-index du chat dans le css
-->
<script>
	var timerChat = setInterval(refreshChat(false), 2000);

	$('#loaderMessage').hide();

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

	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        sendMessageChat();
	    }
	});


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

	$('.chat').hide();
	$('.chat-message-counter').show();

	(function() {

		$('#live-chat header').on('click', function() {

			$("#chatHistory").scrollTop($("#chatHistory")[0].scrollHeight);		
			$('.chat').slideToggle(300, 'swing');
			$('.chat-message-counter').fadeToggle(300, 'swing');
		});
	}) ();

</script>
