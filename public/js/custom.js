$(document).ready(function(){
	// Confirmer la suppression de l'Usager
	$('.AnnulerReservation').click(function() {
		var reservationid = $(this).attr('data-id');
		var clientname = $(this).attr('data-name');
		var reservationurl = $(this).attr('data-url');
		Swal.fire({
			title: 'ÊTES-VOUS SÛRS ?',
			text: "Vous êtes sur le point de faire la demande d'annulation de la réservation de "+clientname+" !",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Valider',
			cancelButtonText: 'Annuler'
		}).then((result) => {
			if (result.isConfirmed) {
			window.location = ""+reservationurl+""
			Swal.fire(
				'Supprimer!',
				'La demande d\'annulation de la réservation a bien été annulée.',
				'success'
			)
			}
		})
	});
	
	// Confirmer la suppression de la gare
	$('.SupprimerGare').click(function() {
		var gareid = $(this).attr('data-id');
		var garename = $(this).attr('data-name');
		var gare_url = $(this).attr('data-url');
		Swal.fire({
			title: 'ÊTES-VOUS SÛRS ?',
			text: "Vous êtes sur le point de supprimer la gare : "+garename+" !",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Valider',
			cancelButtonText: 'Annuler'
		}).then((result) => {
			if (result.isConfirmed) {
			window.location = ""+gare_url+""
			Swal.fire(
				'Supprimer!',
				'La gare a bien été supprimée.',
				'success'
			)
			}
		})
	});
	
	// Confirmer la suppression du véhicule
	$('.SupprimerVehicule').click(function() {
		var vehiculeid = $(this).attr('data-id');
		var vehiculename = $(this).attr('data-name');
		var vehicule_url = $(this).attr('data-url');
		Swal.fire({
			title: 'ÊTES-VOUS SÛRS ?',
			text: "Vous êtes sur le point de supprimer le véhicule : "+vehiculename+" !",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Valider',
			cancelButtonText: 'Annuler'
		}).then((result) => {
			if (result.isConfirmed) {
			window.location = ""+vehicule_url+""
			Swal.fire(
				'Supprimer!',
				'Le véhicule a bien été supprimé.',
				'success'
			)
			}
		})
	});
	
	// Confirmer la suppression du compagnie
	$('.SupprimerCompagnie').click(function() {
		var compagniename = $(this).attr('data-name');
		var compagnie_url = $(this).attr('data-url');
		Swal.fire({
			title: 'ÊTES-VOUS SÛRS ?',
			text: "Vous êtes sur le point de supprimer la compagnie : "+compagniename+" !",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Valider',
			cancelButtonText: 'Annuler'
		}).then((result) => {
			if (result.isConfirmed) {
			window.location = ""+compagnie_url+""
			Swal.fire(
				'Supprimer!',
				'La compagnie a bien été supprimée.',
				'success'
			)
			}
		})
	});

	// Confirmer la suppression d'une ligne
	$('.SupprimerLigne').click(function() {
		var lignename = $(this).attr('data-name');
		var ligne_url = $(this).attr('data-url');
		Swal.fire({
			title: 'ÊTES-VOUS SÛRS ?',
			text: "Vous êtes sur le point de supprimer la ligne : "+lignename+" !",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Valider',
			cancelButtonText: 'Annuler'
		}).then((result) => {
			if (result.isConfirmed) {
			window.location = ""+ligne_url+""
			Swal.fire(
				'Supprimer!',
				'La ligne a bien été supprimée.',
				'success'
			)
			}
		})
	});

	// Confirmer la suppression d'un départ
	$('.SupprimerDepart').click(function() {
		var departname = $(this).attr('data-name');
		var depart_url = $(this).attr('data-url');
		Swal.fire({
			title: 'ÊTES-VOUS SÛRS ?',
			text: "Vous êtes sur le point de supprimer le départ : "+departname+" !",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Valider',
			cancelButtonText: 'Annuler'
		}).then((result) => {
			if (result.isConfirmed) {
			window.location = ""+depart_url+""
			Swal.fire(
				'Supprimer!',
				'Le départ a bien été supprimé.',
				'success'
			)
			}
		})
	});

	// Confirmer la suppression d'un tarif
	$('.SupprimerTarif').click(function() {
		var tarifname = $(this).attr('data-name');
		var tarif_url = $(this).attr('data-url');
		Swal.fire({
			title: 'ÊTES-VOUS SÛRS ?',
			text: "Vous êtes sur le point de supprimer le tarif : "+tarifname+" !",
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Valider',
			cancelButtonText: 'Annuler'
		}).then((result) => {
			if (result.isConfirmed) {
			window.location = ""+tarif_url+""
			Swal.fire(
				'Supprimer!',
				'Le tarif a bien été supprimé.',
				'success'
			)
			}
		})
	});
});