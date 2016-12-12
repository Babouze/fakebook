<!-- Auteur : GARAYT Thomas -->

<div id="live-chat" style="z-index: 1000;" onclick="createWindow();">
	<header id="headerLiveChat" class="clearfix hidden-xs">
		<h4>Chat</h4>
		<span id="chatBubble" class="hidden chat-message-counter">New</span>
	</header>
</div>

<div class="hidden" id="chatClose"></div>

<!-- Auteur : GARAYT Thomas -->
<script type="text/javascript">

	var idLastChat = 0;
	var isFirstRefresh = "true";

	var windowHeight = 400;
	var windowWidth = $('#live-chat').width();
	var windowX = $('body').width() - ($('#live-chat').width() + 40);
	var windowY = document.getElementById('live-chat').getBoundingClientRect().top - windowHeight + 35;
	window.addEventListener('resize', onWindowResize, false);

	function createWindow() {
		$("#live-chat").css("display","none");
		$.window({
			title: "Chat",
			height: windowHeight,
			width: windowWidth,
			x:windowX,
			y:windowY,
			onClose: function(wnd) { // On affiche le bouton en bas
				closeWindow();
			},
			onMinimize: function(wnd) { // On ferme la fenetre si on minimise (et on affiche le bouton en bas)
				closeWindow();
				wnd.close();
			},
			showFooter: false,
			content: "<div class='chat'><div id='chatHistory' class='chat-history'>" + $("#chatClose").html() + "</div><fieldset class='fieldsetChat'><input id='messageChat' type='text' placeholder='Votre message' autofocus><input type='hidden'></fieldset></div>"
		});
		
		$(".window_frame").click(function() {
			$(".window_title_text").html("Chat");
			$(".window_title_text").css("color","");
		});
	}

	function onWindowResize() {
		windowWidth = $('#live-chat').width();
		windowX = $('body').width() - ($('#live-chat').width() + 40);
		windowY = document.getElementById('live-chat').getBoundingClientRect().top - windowHeight + 35;
	}

	function closeWindow() {
		isFirstRefresh = "true";
		$("#live-chat").css("display","block");
		$("#chatBubble").hide();
	}

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
				
				if(scrollBottom == "true" || isFirstRefresh == "true") {
					isFirstRefresh = "false";
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
					toastr["success"]("Message envoyé");	
				},
				error: function(returnData) {
					toastr["error"]("Erreur lors de l'envoi du message");	
				} 
			})
		}
	}

</script>
