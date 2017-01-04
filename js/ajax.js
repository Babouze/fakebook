// Auteur : DAUDEL Adrien
$('#postForm').submit(function(e) {
	e.preventDefault()
	
	var formData = new FormData(document.getElementById("postForm"));

	var message = $("#message").val();

	if(message != "")
	{
		$.ajax({
			type:'POST',
			async: true,
			data: formData,
			url:'Afakebook.php?action=postNewMessageOnFriend',
			cache: false,
			processData: false,  // indique à jQuery de ne pas traiter les données
			contentType: false,   // indique à jQuery de ne pas configurer le contentType
			success: function(returnData) {
				toastr["success"]("Message posté");	
				$('#message').val("");
				$('#image-text').val("");
			},
			error: function(returnData) {
				toastr["error"]("Erreur lors de l'envoi du message");	
			}
		})
	}
	else {
		toastr["warning"]("Veuillez remplir le champ message");	
	}
});

// Auteur : GARAYT Thomas
$('#updateStatut').submit(function(e) {
	e.preventDefault()
	
	var statut = $('#statut').val();

	$('#myStatut').css("animation","");
	
	$.ajax({
		type:'POST',
		async: true,
		data: { statut } ,
		url:'Afakebook.php?action=updateStatut',
		cache: false,
		success: function(returnData) {
			$('#myStatut').html(statut);
			$('#myStatut').css("animation","animUpdate 1s 1");
			$('#statut').val("");
			toastr["success"]("Statut mis à jour");	
		},
		error: function(returnData) {
			toastr["error"]("Erreur lors de la mise à jour du statut");	
		}
	})
});

// Auteur : DAUDEL Adrien
function jaime(idMessage) {
	$('#aime' + idMessage).css("animation","");
	$.ajax({
		type:'POST',
		async: true,
		data: { idMessage } ,
		url:'Afakebook.php?action=jaime',
		cache: false,
		success: function(returnData) {
			$('#aime' + idMessage).html(returnData);
			$('#aime' + idMessage).css("animation","animUpdate 3s 1");
			toastr["success"]("Like ajouté !");
		},
		error: function(returnData) {
			toastr["error"]("Erreur lors du like");
		}
	})
};

// Auteur : DAUDEL Adrien
function partage(idMessage) {
	$.ajax({
		type:'POST',
		async: true,
		data: { idMessage } ,
		url:'Afakebook.php?action=partage',
		cache: false,
		success: function(returnData) {
			toastr["success"]("Message partagé !");
		},
		error: function(returnData) {
			toastr["error"]("Erreur lors du partage");
		}
	})
};

// Auteur : DAUDEL Adrien
function refreshMessages(getMessages) {
		$.ajax({
		type:'POST',
		async: true,
		data: { id, getMessages },
		url:'Afakebook.php?action=refreshMessages',
		cache: false,
		success: function(returnData) {
			if(getMessages == true)
				$('#listOfMessages').html(returnData);
			else if(returnData != lastId && lastId != 0)
			{
				lastId = returnData;
				toastr.options.timeOut=-1;
				toastr.options.extendedTimeOut=-1;
				toastr.info("<p onclick='refreshMessages(true)'>Nouveaux posts, cliquez pour charger</p>");
			}
			else
				lastId = returnData;
		}
	})
}

// Auteur : DAUDEL Adrien
$('#postForm').submit(function(e) {
	e.preventDefault()
	
	var formData = new FormData(document.getElementById("postForm"));
	
	var message = $("#message").val();

	if(message != "")
	{
		$.ajax({
			type:'POST',
			async: true,
			data: formData,
			url:'Afakebook.php?action=postNewMessage',
			cache: false,
			processData: false,  // indique à jQuery de ne pas traiter les données
			contentType: false,   // indique à jQuery de ne pas configurer le contentType
			success: function(returnData) {
				toastr["success"]("Message envoyé");	
				$('#message').val("");
				$('#image-text').val("");
			},
			error: function(returnData) {
				toastr["error"]("Erreur lors de l'envoi du message");
			}
		})
	}
	else {
		toastr["warning"]("Veuillez remplir le champ message");
	}
});

// Auteur : DAUDEL Adrien
function jaime(idMessage) {
	$('#aime' + idMessage).css("animation","");
	$.ajax({
		type:'POST',
		async: true,
		data: { idMessage } ,
		url:'Afakebook.php?action=jaime',
		cache: false,
		success: function(returnData) {
			$('#aime' + idMessage).html(returnData);
			$('#aime' + idMessage).css("animation","animUpdate 1s 1");
			toastr["success"]("Like ajouté !");
		},
		error: function(returnData) {
			toastr["error"]("Erreur lors du like");
		}
	})
};

// Auteur : DAUDEL Adrien
function partage(idMessage) {
	$.ajax({
		type:'POST',
		async: true,
		data: { idMessage } ,
		url:'Afakebook.php?action=partage',
		cache: false,
		success: function(returnData) {
			toastr["success"]("Message partagé !");
		},
		error: function(returnData) {
			toastr["error"]("Erreur lors du partage");
		}
	})
};
