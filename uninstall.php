<?php
$options = get_option( 'aod_options' );

if ( ! empty( $options['product_id'] ) ) {
	wp_delete_post( $options['product_id'] );
}

if ( ! empty( $options['webhook_id'] ) ) {
	$webhook = wc_get_webhook( $options['webhook_id'] );
	$webhook->delete();
}

delete_option( 'aod_options' );