function Jcrop()
{
	var crop;

	this.new = function(data)
	{
		var $thisContext = this;

		var	html = '<div class="cropMain"></div>';
			html += '<div class="cropSlider"></div>';
			html += '<button class="btn btn-info btn-sm btn-back-account-options pull-left" style="margin:0 5px 0 0">Cancelar</button>';
			html += '<button class="btn btn-primary btn-sm btn-crop-image pull-left">Salvar</button>';

		$(data.obj).html(html);
		this.crop = new CROP();
		this.crop.init(data.obj);
		this.crop.loadImg(data.src);

		$('.btn-back-account-options').on('click', function(){
			$('.webcam-capture, .crop-image').hide(0, function(){
				$('.account-options').fadeIn();
			});
		});

		$('.btn-crop-image').on('click', function(){
			data.onCrop($.param(coordinates($thisContext.crop)));
		});
	}
}

window.jcrop = new Jcrop();