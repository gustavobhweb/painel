// $(function(){
// 	var active = true;
// 	$(window).on('keyup', function(e){
// 		if (e.keyCode == 118) {
// 			e.preventDefault();
// 			if (active) {
// 				showProduction();
// 				active = false;
// 			} else {
// 				hideProduction();
// 				active = true;
// 			}
// 		}
// 	});
// 	hideProduction();
// });

// function hideProduction(){
// 	$('body').css({background: '#efefef'});
// 	$('.menu, .mercado, .profile').css({visibility: 'hidden'});
// }

// function showProduction(){
// 	$('body').css({background: "url('/static/img/bg_auth.jpg') fixed"});
// 	$('.menu, .mercado, .profile').css({visibility: 'visible'});
// }