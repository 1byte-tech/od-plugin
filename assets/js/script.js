jQuery(document).ready(function($){
	// add to cart
	$('body').on('change', '#aod_add_insurance_product', function(e, aod_already_added = ''){
		e.preventDefault();

			var data = $(this).is(':checked');
			$.ajax({
				type: 'POST',
				url: aod_localize_script.ajaxurl,
				dataType: 'json',
				data: 'data=' + data + '&aod_nonce_field=' + aod_localize_script.aod_nonce_field + '&action=aod_ajax&subaction=add_to_cart_insurance_product',
				beforeSend: (res) => {
					console.log(res);
				},
				success: (res) => {
					if ( res.success ) {
						$('#aod_custom_checkout_field').addClass('active');
					} else {
						$('#aod_custom_checkout_field').removeClass('active');
					}
				}
			});
	});
});

