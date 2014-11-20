var delay = (function() {

	var timeout = 0;

	return function (ms, callback) {
		clearTimeout(timeout);
		timeout = setTimeout(callback, ms);
	}

})();

$(function(){

	var tplTimes = $('#tpl-times').html(),
		$containerClubes = $('#container-clubes');

	$('.select-paises').change(function(){
		var value = $(this).val();

		$.ajax({
			url		: '/user/ajax-clubes',
			data	: {nacao_id: value},
			type	: 'get',
			success	: function (response) {

				if ($.isEmptyObject(response)) {
					$containerClubes.html('Nenhum resultado encontrado');
					return;
				}


				var html = _.template(tplTimes).call(null, {clubes: response});

				$containerClubes.html(html);

			}
		});
	});


	var modal = new WmModal(null, {
		title: 'Selecione os jogadores',
		width: 700,
		height: 350
	});

	$(document).on('click', '.clube-item', function(){
		var value = $(this).data('id');

		$('#clube-id').val(value);

		$('#clube-selecionado').html(
			$(this).clone()
				.removeClass('clube-item')
				.hide()
				.show(500, function(){
					modal
						.setContentFromTemplate('#tpl-modal-jogadores')
						.open();	
				})
		);
		
	});


	/**
	*
	*/

	var tplJogadoresLista = $("#tpl-jogadores-listagem").html();


	$(document).on('keyup', '#autocomplete-jogadores', function(){

		var formData = {
			nome:$(this).val().trim(),
			liga_id: $('[name=liga_id]').val()
		};

		delay (500, function () {

			$.ajax({
				url: '/user/ajax-listar-jogadores',
				data: formData,
				type: "GET",
				success: function (response) {

					var html = _.template(tplJogadoresLista).call(null, {jogadores: response});
					$("#box-autocomplete-jogadores").html(html);
				}
			});

		});
	});

});