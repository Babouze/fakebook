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