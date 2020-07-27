$(function(){
	

	function close_modal(){
		$(".overlay").fadeOut();
		$(".overlay").remove();
	}

	function show_modal(){
		$("html").mouseleave(function(event){
			if(event.clientY <= 0){
				$(".overlay").fadeIn();
				// $("#phone").mask("+380 (99) 999-99-99");
			}
		});
	}
	function imm_show(){
		$(".overlay").fadeIn();
		// $("#phone").mask("+380 (99) 999-99-99");
	}

	$(".close_modal").click(function(){
		close_modal();
	});

	if(screen.width > 768){
		show_modal();
	}else{
		setTimeout(imm_show,8000);
	}

	$("#phone").mask("+380 (99) 999-99-99");

 	
 		$("#phone").keyup(function(){
 			let phone_length = $("#phone").val().length;
 			// console.log(phone_length);
 			if(phone_length == 19){
 				$(".button_block button").prop("disabled",false);
 				$(".button_block button").text("Отправить");
 			}else{
 				$(".button_block button").prop("disabled",true);
 				$(".button_block button").text("Заполните форму");
 			}
 		});

 		function randomInteger(min, max) {
		  let rand = min - 0.5 + Math.random() * (max - min + 1);
		  return Math.round(rand);
		}
		function hideBlock(){
			$(".push_block").fadeOut();
		}
 		function fillRandom(){
 			var companies = ['Ccloan', 'Miloan', 'CreditPlus', 'Credit7', 'Mazila', 'MoneyVeo', 'Швидкогроші'];
 			let company_random = ( randomInteger(1, companies.length));
 			let day_random = ( randomInteger(5, 15));
 			let amount_random = ( randomInteger(5, 100));
 			amount_random = amount_random * 100;
 			// console.log(company_random);
 			// console.log(day_random);
 			// console.log(amount_random);
 			$(".company_name_push").text(companies[company_random]);
 			$(".amount_push").text(amount_random);
 			$(".days_push").text(day_random);
 			$(".push_block").fadeIn();
 			setTimeout(hideBlock, 5000);
 		}

 		setInterval(fillRandom,12000);
 		

});