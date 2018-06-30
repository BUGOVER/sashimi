$(document).ready(function(){
//		var discount = 0;
//		$('#promo').on('change', function () {
//
//			if($(this).val() == settings.setting[3].value) {
//				discount = settings.setting[4].value;
//				$('.error-min-delivery').text('');
//				$('.bdiscount span').text(settings.setting[4].value + '%');
//				rebusk();
//			}
//		});
		$('.delivery_info_basket').append('<div class="bdelivery">ДОСТАВКА <span class="card_body_right"></span></div>');
//		$('.delivery_info_basket').append('<div class="bdiscount">СКИДКА <span class="card_body_right">0</span></div>');
		$('#itog').append('<div class="bitog">ИТОГО <span class="card_body_right"></span></div>');
		var settings = $.ajax({
			url: 'https://2.app-sashimi59.ru/api/v1/settings',
			dataType: 'json',
			async: false
		}).responseJSON;
		var cafe = settings.cafe;
		$('#cafeId').html('');
		for(caf in cafe){
			$('#cafeId').append('<option value="'+cafe[caf]['id']+'">'+cafe[caf]['name']+'</option>');
		}
		var rebusk = function () {
			var sum = Math.round($('#bsum').text().replace(/D+/g,""));
			var deliveryMin = settings.setting[0].value;
			if (parseInt(sum) < parseInt(deliveryMin)) {
				$('.error-min-delivery').append('<span>Внимание! Минимальная сумма заказа '+deliveryMin+' Ք</span>');
				$('#sendBusketButton').hide();
			} else {
				$('#sendBusketButton').show();
				$('.error-min-delivery').html('');
			}
			var deliveryCost = settings.setting[2].value;
			var deliveryFree = settings.setting[1].value;

			if(parseInt(sum) > parseInt(deliveryFree)) {
				$('.bdelivery span').text('БЕСПЛАТНО');
				$('.bitog span').text(sum.toString() + " Ք");
			} else {
				var res = parseInt(deliveryCost) + parseInt(sum);
				$('.bdelivery span').text(deliveryCost + " Ք");
				$('.bitog span').text( res.toString() + " Ք");
			}
		};

		rebusk();
		$(cart).on('deleteItem', rebusk);

		$('.cart_mp').on('click', rebusk);
		$('input[name="wayDelivery"]').on('click', function () {
			if($('input[name="wayDelivery"]:checked').val() == 'delivery') {
				$('.group-delivery').show();
			} else {
				$('.group-delivery').hide();
			}
		});
		$('.group-time').hide();
		$('input[name="timeDelivery"]').on('click', function () {
			if($('input[name="timeDelivery"]:checked').val() == 'time') {
				$('.group-time').show();
			} else {
				$('.group-time').hide();
			}
		});

		$("#phone").mask("+7 (999) 999-9999");
		$('#formToSend').validationEngine({promptPosition : "topLeft"});
		$("#bcontainer").css({"position": "static"});
		$('#basket').append( $("#bcontainer") );
		$("#bcontainer").show();

		$(cart).on('clickSendForm', function () {
			for(item in cart.DATA) {
				$('#data_form').append('<input type="hidden" name="produts['+item+']" value="'+cart.DATA[item].num+'">');
			}
			if($('#name').size() > 0) {
				$('#post-name').val($('#name').val());
			}
			if($('#phone').size() > 0) {
				$('#post-phone').val($('#phone').val());
			}
			if($('#place').size() > 0) {
				$('#post-place').val($('#place').val());
			}
			if($('input[name="wayDelivery"]:checked').size() > 0) {
				$('#post-wayDelivery').val($('input[name="wayDelivery"]:checked').val());
			}
			if($('#porch').size() > 0) {
				$('#post-porch').val($('#porch').val());
			}
			if($('#floor').size() > 0) {
				$('#post-floor').val($('#floor').val());
			}
			if($('input[name="timeDelivery"]:checked').size() > 0) {
				if($('input[name="timeDelivery"]:checked').val() == 'time') {
					$('#post-hour').val($('#time-hour').val());
					$('#post-min').val(	$('#time-min').val());
				}
				$('#post-timeDelivery').val($('input[name="timeDelivery"]:checked').val());
			}
			if($('#cafeId').size() > 0) {
				$('#post-cafeId').val($('#cafeId').val());
			}
			if($('#promo').size() > 0) {
				$('#post-promo').val($('#promo').val());
			}
			for(item in cart.DATA) {
				$('#data_form').append('<input type="hidden" name="produts['+item+']" value="'+cart.DATA[item].num+'">');
			}
		});
	});
