var delay = (function() {

	var timeout = 0;

	return function (ms, callback) 
	{
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


	$(document).on('click', '.clube-item', function ()
	{

		var value = $(this).data('id');

		$('#clube-id').val(value);

		$('#clube-selecionado').html(
			$(this)
				.clone()
				.removeClass('clube-item')
				.hide()
				.show(500)
		);

		$("#container-clubes").empty();
		
	});

});