$(function(){


	$(".gotTopButton").click(function(e){
		e.preventDefault();
		let id = $(this).attr("href"),
		top = $(id).offset().top - 50;
		$("body,html").animate({scrollTop:top}, 500);
	});

	// $(window).scroll(function(){

	// 	let show_button = $("#toCheckButton").offset().top;
	// 	let window_height = window.pageYOffset;
	// 	// console.log(show_button);
	// 	// console.log(window_height);
	// 	if(window_height > show_button){
	// 		$(".gotTopButton").css("display","flex");
	// 	}
	// 	if(window_height < show_button){
	// 		$(".gotTopButton").css("display","none");
	// 	}

	// });

});
