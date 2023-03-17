jQuery(document).ready(function($){	
	// Register order defense
	$('.aod-register').on('click', function(e){
		e.preventDefault();

		var data = $('#registration').val();

		$.ajax({
			type: 'POST',
			url: aod_localize_script.ajaxurl,
			dataType: 'json',
			data: 'data=' + data + '&aod_nonce_field=' + aod_localize_script.aod_nonce_field + '&action=aod_ajax&subaction=register_od',
			beforeSend: (res) => {
				console.log(res);
			},
			success: (res) => {
				if ( res.success == true ) {
					$('#aod-multi-step').val( 2 );
					$('#aod-multi-step').click();
				}
				console.log(res);
			}
		});
	});

	// Setup Order defense billing
	$('.aod-setup-billing').on('click', function(e){
		e.preventDefault();

		var data = $('#setup_billing').val();

		$.ajax({
			type: 'POST',
			url: aod_localize_script.ajaxurl,
			dataType: 'json',
			data: 'data=' + data + '&aod_nonce_field=' + aod_localize_script.aod_nonce_field + '&action=aod_ajax&subaction=setup_billing_od',
			beforeSend: (res) => {
				console.log(res);
			},
			success: (res) => {
				if ( res.success == true ) {
					$('#aod-multi-step').val( 3 );
					$('#aod-multi-step').click();
				}
				console.log(res);
			}
		});
	});

	// Setup Order defense billing
	$('.aod-api-permission').on('click', function(e){
		e.preventDefault();

		var data = $('#api_permission').val();

		$.ajax({
			type: 'POST',
			url: aod_localize_script.ajaxurl,
			dataType: 'json',
			data: 'data=' + data + '&aod_nonce_field=' + aod_localize_script.aod_nonce_field + '&action=aod_ajax&subaction=api_permission_od',
			beforeSend: (res) => {
				console.log(res);
			},
			success: (res) => {
				if ( res.success == true ) {
					window.location.href = res.data.url;
					$('#aod-multi-step').val( 4 );
					$('#aod-multi-step').click();
				} else {
					$('.aod-popup-html').empty();
					$('.aod-popup-html').append( res.data.message );
					$('.aod-popup').addClass('is-visible');
				}
				console.log(res);
			}
		});
	});

	// Setup insurance product
	$('.aod-setup-product').on('click', function(e){
		e.preventDefault();

		var data = $('#setup_product').val();

		$.ajax({
			type: 'POST',
			url: aod_localize_script.ajaxurl,
			dataType: 'json',
			data: 'data=' + data + '&aod_nonce_field=' + aod_localize_script.aod_nonce_field + '&action=aod_ajax&subaction=setup_product_od',
			beforeSend: (res) => {
				console.log(res);
			},
			success: (res) => {
				if ( res.success == true ) {
					$('#aod-multi-step').val( 5 );
					$('#aod-multi-step').click();
				}
				console.log(res);
			}
		});
	});

	// step prev
	$('.aod-prev').on('click', function(e){
		e.preventDefault();
		let step = $(this).attr('data-step');
		$('#aod-multi-step').val( step - 1 );
		$('#aod-multi-step').trigger('click', 'prev');
	});

	// manage step
	$('#aod-multi-step').on('click', function(e, prev = ''){
		e.preventDefault();
		let step = $(this).val();
		console.log(prev);
		if ( prev == 'prev') {
			$('.aod-multi-step-progress li:nth('+ (step) +')').removeClass('active');
		} else {
			$('.aod-multi-step-progress li:nth('+ (step - 1) +')').addClass('active');
		}
		$('.aod-multi-steps .aod-multi-step:nth('+ (step - 1) +')').addClass('active').siblings().removeClass('active');
	});

	// after wc api return 
	if ( aod_localize_script.success == 1 ) {
		$('.aod-multi-step-progress li:nth-child(-n + 3)').addClass( 'active' );
		$('#aod-multi-step').val( 4 );
		$('#aod-multi-step').click();
	} 
	
	if ( aod_localize_script.success == 0 ) {
		$('.aod-multi-step-progress li:nth-child(-n + 2)').addClass( 'active' );
		$('#aod-multi-step').val( 3 );
		$('#aod-multi-step').click();
	}

	//close popup
	$('.aod-popup').on('click', function(event){
		if( $(event.target).is('.aod-popup-close') || $(event.target).is('.aod-popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
		if(event.which=='27'){
			$('.aod-popup').removeClass('is-visible');
		}
	});
});

