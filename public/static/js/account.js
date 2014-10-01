$(function(){
	jcam.init('#imgselect_container');

	$('.btn-email').on('click', function(){
		$('.group-btn-account').hide(0, function(){
			$('#frm-change-mail').fadeIn();
		});
	});
	$('.btn-senha').on('click', function(){
		$('.group-btn-account').hide(0, function(){
			$('#frm-change-pass').fadeIn();
		});
	});
	$('.btn-cancel-change-mail').on('click', function(){
		$('#frm-change-mail').hide(0, function(){
			$('.group-btn-account').fadeIn();
		});
	});
	$('.btn-cancel-change-pass').on('click', function(){
		$('#frm-change-pass').hide(0, function(){
			$('.group-btn-account').fadeIn();
		});
	});
	$('.btn-save-change-name').on('click', function(){
		changeName($('#-nome').val());
	});
	$('.btn-save-change-mail').on('click', function(){
		changeMail({
			pass: $('#change-mail-pass').val(),
			mail: $('#change-mail-mail').val(),
			confMail: $('#change-mail-conf-mail').val()
		});
	});
	$('.btn-save-change-pass').on('click', function(){
		changePass({
			pass: $('#change-pass-pass').val(),
			newPass: $('#change-pass-new-pass').val(),
			confPass: $('#change-pass-conf-pass').val(),
			token: $('#_token').val()
		});
	});
	$('.btn-select-image').on('click', function(){
		$('#file').click();
	});
	$('#file').on('change', function(){
		var file = $(this).prop('files')[0];
		var ext = $(this).val().split('.').slice(-1)[0];
	    regexpExtension = /(png|jpg|jpeg|gif)/gi;
	    if (!regexpExtension.test(ext)) {
	    	alert('O tipo de arquivo selecionado é inválido!');
	    } else {
			var url = URL.createObjectURL(file);
			$('.account-options').hide(0, function(){
				$('.crop-image').fadeIn('slow', function(){
					jcrop.new({
						obj: '.crop', 
						src: url,
						onCrop: function(params){
							var reader = new FileReader();
							reader.onload = function(e){
								base64 = reader.result;
								base64 = base64.replace(/data:image\/.+;base64,/, '');
								$.ajax({
									url: '/user/ajax-crop-image?' + params,
									type: 'POST',
									dataType: 'json',
									data: {
										base64: base64
									},
									beforeSend: function(){
										$('.btn-crop-image').html('Salvando...');
									},
									success: function(response){
										window.location.reload();
									},
									error: function(){
										alert('Problemas na conexão! Atualize a página e tente novamente.');
									}
								});
							}
							reader.readAsDataURL(file);
						}
					});
				});
			});
		}
	});
	$('.btn-open-webcam').on('click', function(){
		$('.account-options').hide(0, function(){
			$('.webcam-capture').fadeIn();
		});
	});
	$('.btn-back-account-options').on('click', function(){
		$('.webcam-capture, .crop-image').hide(0, function(){
			$('.account-options').fadeIn();
		});
	});

});

function changeMail(data)
{
	$.ajax({
		url: '/user/ajax-change-mail',
		type: 'POST',
		dataType: 'json',
		data: data,
		success: function(response){
			alert(response.text);
			if (response.status) {
				$('#frm-change-mail').hide(0, function(){
					$('.group-btn-account').fadeIn();
				});
			}
		},
		error: function(){
			alert('Problemas na conexão! Atualize a página e tente novamente.')
		}
	});
}

function changePass(data)
{
	$.ajax({
		url: '/user/ajax-change-pass',
		type: 'POST',
		dataType: 'json',
		data: data,
		success: function(response){
			alert(response.text);
			if (response.status) {
				$('#frm-change-pass').hide(0, function(){
					$('.group-btn-account').fadeIn();
				});
			}
		},
		error: function(){
			alert('Problemas na conexão! Atualize a página e tente novamente.')
		}
	});
}

function changeName(nome)
{
	$.ajax({
		url: '/user/ajax-change-name',
		type: 'POST',
		dataType: 'json',
		data: {nome: nome},
		success: function(response){
			alert(response.text);
		},
		error: function(){
			alert('Problemas na conexão! Atualize a página e tente novamente.')
		}
	});
}