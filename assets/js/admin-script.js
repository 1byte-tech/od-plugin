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
					$('#aod-multi-step').val( 4 );
					$('#aod-multi-step').click();
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
});

