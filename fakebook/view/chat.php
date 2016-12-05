<!-- Auteur : GARAYT Thomas -->


<div id="live-chat" style="z-index: 1000;" onclick="createWindow();">
	<header class="clearfix">
		<h4>Chat</h4>
		<span class="hide chat-message-counter"></span>
	</header>
</div>

<script type="text/javascript">
	function createWindow() {
		$("#live-chat").css("display","none");
		$.window({
			title: "Chat",
			height: 325,
			onClose: function(wnd) { // On affiche le bouton en bas
				closeWindow();
			},
			onMinimize: function(wnd) { // On ferme la fenetre si on minimise (et on affiche le bouton en bas)
				closeWindow();
				wnd.close();
			},
			showFooter: false,
			content: "<div class='chat'><div id='chatHistory' class='chat-history'></div><fieldset class='fieldsetChat'><input id='messageChat' type='text' placeholder='Votre message' autofocus><input type='hidden'></fieldset></div>"
		});
	}
</script>

<script>
	function closeWindow() {
		$("#live-chat").css("display","block");
	}
</script>

<script>
	$( document ).ready(function() {
		/* On hide le chat, on descend en bas du chat */
		// refreshChat("true");
		$('.chat').hide();
		$('.chat-message-counter').show();
		// $('#chatHistory').scrollTop($("#chatHistory")[0].scrollHeight);	
	});
	
	/* Timer pour le rafraichissement du chat toutes les 2 secondes */	
	setInterval('refreshChat("false")', 2000);	
		
	/* Fonction qui va requeter la base de donnée pour rafraichir le chat */
	function refreshChat(scrollBottom) {
		$.ajax({
			type:'POST',
			async: true,
			url:'Afakebook.php?action=refreshChat',
			cache: false,
			success: function(returnData) {
				// alert(returnData);
				$('#chatHistory').html(returnData);	
				if(scrollBottom == 'true') {
					$('#chatHistory').scrollTop($("#chatHistory")[0].scrollHeight);	
				}
				// TODO
				// Récupérer ladate du dernier chat
				// Ne récupérer que les messages dont la date est supérieure à la date et .append()
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
					refreshChat("true");
				}
			})
		}
	}


	(function() {
		$('#live-chat header').on('click', function() {
			// $('#chatHistory').scrollTop($("#chatHistory")[0].scrollHeight);		
			$('.chat').slideToggle(300, 'swing');
			$('.chat-message-counter').fadeToggle(300, 'swing');
		});
	}) ();



</script>
