<!-- Auteur : GARAYT Thomas -->


<div id="live-chat" style="z-index: 1000;" onclick="createWindow();">
	<header id="headerLiveChat" class="clearfix">
		<h4>Chat</h4>
		<span id="chatBubble" class="hidden chat-message-counter">New</span>
	</header>
</div>

<div class="hidden" id="chatClose"></div>

<script type="text/javascript">
	var idLastChat = 0;

	function createWindow() {
		content = $("#chatClose").html();
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

		$(".window_frame").click(function() {
			$(".window_title_text").html("Chat");
			$(".window_title_text").css("color","");
		});
	}

	function closeWindow() {

		// $("#live-chat h4").css("background","#1a8a34");
		$("#live-chat").css("display","block");
		$("#chatBubble").hide();
	}

	function focusOnChat() {
		alert("Focus");
	}

</script>

<script>
	
	var isFirstRefresh = true;

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
				$('#chatClose').html("");
				$('#chatHistory').html(returnData);
				var valLastId = $("#lastIdChat").val();
				if(valLastId) { // Le chat est ouvert, on update la fenetre ouverte
					if(valLastId > idLastChat  && idLastChat != 0) {
						idLastChat = valLastId;
						$(".window_title_text").html("New message");
						$(".window_title_text").css("color","red");
					}
					else {
						idLastChat = valLastId;
					}
				}
				else { // Le chat est fermé, on va update l'icone en bas de l'écran
					$('#chatClose').html(returnData);
					valLastId = $("#lastIdChat").val();
					if(valLastId > idLastChat && idLastChat != 0) {	
						idLastChat = valLastId;
						$("#live-chat h4:before").css("background","red");
						$("#chatBubble").show();
					}
					else {
						idLastChat = valLastId;
					}
				}
				
				if(scrollBottom == "true" || isFirstRefresh == true) {
					isFirstRefresh = false;
					$('.window_frame').scrollTop(99999999);	
				}				
			}
		})
	}

	/* Soumission du message du chat lorsque l'on appuie sur "Enter" */
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        sendMessageChat();
	    }
	});

	/* Fonction permettant de requeter la base de donnée pour enregister un nouveau message */
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
				success: function(returnData) {
					refreshChat("true");
				}
			})
		}
	}

</script>
