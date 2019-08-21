function sendRequestUzcard (actionReq){
		$('.errorMessage').html("");
		var actionReq = actionReq;
		if (actionReq == 'pay'){
			$('input[name="cardTel"], input[name="cardNumber"], input[name="cardValid"]').attr("disabled", false);
		}
		var formUzcardArray = $('form[name="ShopFormUzcard"]').serializeArray();
		var UzcardSendArray = [];
		$.each(formUzcardArray, function(){
			UzcardSendArray[this.name]= this.value;
		});

	//	console.log(UzcardSendArray);
		var arr = {
			params:{
					key:UzcardSendArray.key,
					eposId:UzcardSendArray.eposId,
					phoneNumber:UzcardSendArray.cardTel.replace(/[^0-9]/g,''),
					cardLastNumber:UzcardSendArray.cardNumber.replace(/[^0-9]/g,''),
					expire:UzcardSendArray.cardValid.replace(/[^0-9]/g,''),
					summa:UzcardSendArray.Sum,
					orderId:UzcardSendArray.orderNumber
			},
			id:UzcardSendArray.orderNumber
		};
		if (actionReq == "pay"){
			arr.params.otp = UzcardSendArray.otp;
			arr.params.uniques = UzcardSendArray.uniques;
		}
		console.log(arr);
		mess = JSON.stringify (arr);
		$.ajax(
		{
			type: "POST",
			url: urlAPI,
			beforeSend: function (xhr){ 
				xhr.setRequestHeader('Authorization', "Basic " + btoa(UzcardSendArray.login+":"+UzcardSendArray.psw)); 
			},
			contentType:'text/json; charset=UTF-8',
			data: mess,
			dataType: 'json',
			
			success: function(data) {
				console.log(data);
				// запрос на оплату прошел
				if (data.result.sended == true && data.result.uniques && actionReq == 'next'){
					$('input[name="cardTel"], input[name="cardNumber"], input[name="cardValid"]').attr("disabled", true);
					$('input[name="cardTel"], input[name="cardNumber"], input[name="cardValid"]').css("color", "#fff");
					$('.sale-paysystem-uzcard-button-container').append('<input type="hidden" name="uniques" value="'+data.result.uniques+'">');
					$('.sale-paysystem-uzcard-button-container').append('<p><input type="text" class="maskOtp" name="otp" placeholder="Код из СМС"></p>');
					$('.errorMessage').html('</br>Введите код полученный в СМС и нажмите оплатить');
					$('.uzcardNext').hide();
					$('.uzcardPay').show();
					$('.uzcardPay').on('click', function(){
							sendRequestUzcard('pay');
					});
				}
				//оплата прошла
				if (data.result.success == true){
					$('.errorMessage').html('</br>Оплата успешно произведена на сумму ' + data.result.summa + ' UZS' );
					data.result.BX_HANDLER = 'UZCARD';
					$.get('http://homemobilmarket.uz/bitrix/tools/sale_ps_result.php', data.result);
					
				}
			},
			error: function(data){
				$('.errorMessage').html('</br>Uzcard код ошибки: ' + data.responseJSON.error.code + '</br>' + 'Uzcard ошибка: ' + data.responseJSON.error.message);
				console.log('Uzcard код ошибки: ' + data.responseJSON.error.code);
				console.log('Uzcard ошибка:' + data.responseJSON.error.message);
			}
		}
	);
};
function uzcardActive(){
	
	if($(".sale-paysystem-uzcard-wrapper").hasClass('active')) {
		return true;
	}else{
		$('.sale-paysystem-uzcard-wrapper').toggleClass('active');
	}
	$('input[name="cardTel"]').inputmask('+9(9999)999-99-99');
	$('input[name="cardNumber"]').inputmask('XXXX XXXX XX 99 9999');
	$('input[name="cardValid"]').inputmask('99/99');
	$('.uzcardNext').on('click', function(){
		sendRequestUzcard('next');
	});
};

$(document).ready(function(){
	uzcardActive();
});

