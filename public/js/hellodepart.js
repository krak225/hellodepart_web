$(document).ready(function () {		
	//Ajouter un nouveau client
	$('.DetailsReservation').click(function(){
		var url = $(this).data('url');
		var details = $(this).data('details');

		$('#dialog').krakPopup({
			title:details,
			url:url,
			width: 900, 
			height: 50,
			top:250,
			contentMinHeight: 140,
			onOutClickClose:false,
			closeButton:false,
			submitButton:false,
			 customButton:{show:false,text:'Boutton',clickFn:function(){
				// alert('A Click on customButton');
				}
			},
			positionTop: '70px',
		});
		
	});
});