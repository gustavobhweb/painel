$(function(){

	var modalInfo = new WmModal(null,{
		title: 'Informação da liga',
		width: 600
	});

	$('.btn-modal-info').click(function(){

		var dataObject = $(this).data('object');
		modalInfo.open()
				.setContentFromTemplate("#tpl-modal-info", {
					logo: dataObject.logo,
					info: dataObject.info
				});

	});

;
})