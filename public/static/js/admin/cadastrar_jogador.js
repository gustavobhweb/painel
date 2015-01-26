$(function(){

	var $fakeFile = $('#fake-file-name'),
		$hiddenFile = $('#hidden-file');

	$fakeFile.click(function(){
		$hiddenFile.trigger('click');
	});

	$hiddenFile.change(function(){

		var $self = $(this);
		var value = ($self.val()).toString().split('\\').pop();

		if (value.length) {

			$fakeFile.html(value);
		}

		console.log(value)
	});



	$('#data-nascimento').datepicker();
});