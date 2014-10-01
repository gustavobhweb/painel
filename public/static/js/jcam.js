function Jcam()
{
	this.init = function(obj){
		new ImgSelect($(obj));
	}
}

window.jcam = new Jcam();