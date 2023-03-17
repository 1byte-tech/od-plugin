<?php
/*
* Functions
*/

function aod_print_r( $data, $exit_code = 'eeeeeeeeee' ) {
    echo '<pre>'; print_r( $data ); exit( $exit_code );
}

function aod_generate_wc_api_keys( $args = [] ) {

    $args = array_merge([
        'user_id' => get_current_user_id(), 
        'app_name' => esc_html__( 'Order Defense', 'axon-order-defense' ), 
        'scope' => 'read_write', 
        'return_url' => admin_url( 'admin.php?page=aod_setting' ),
        'callback_url'   => admin_url( 'admin.php?page=aod_setting&callback=aod_api' )
    ], $args );

    if ( ! $args['user_id'] ) {
        return;
    }

    $store_url = site_url();
    $endpoint = '/wc-auth/v1/authorize';
    $params = [
        'app_name' => $args['app_name'],
        'scope' => $args['scope'],
        'user_id' => $args['user_id'],
        'return_url' => $args['return_url'],
        'callback_url' => $args['callback_url']
    ];

    $query_string = http_build_query( $params );

    $api_url = $store_url . $endpoint . '?' . $query_string;

    wp_send_json_success( [ 'url' => $api_url ] );
}

function aod_woocommerce_api_keys( $key_id ) {
    if ( ! $user_id ) {
        return;
    }

    global $wpdb;
    
    $keys = $wpdb->get_results( $wpdb->prepare( "
        SELECT consumer_key, consumer_secret, permissions
        FROM {$wpdb->prefix}woocommerce_api_keys
        WHERE key_id = %d
        ", esc_attr( $key_id ) ), ARRAY_A );

    return $keys;
}

function aod_wc_webhook( $api_keys )
{
	$set_user_id = get_current_user_id();
	$webhook = new WC_Webhook();
    $webhook->set_name('Aod Webhook Order');
    $webhook->set_user_id( $set_user_id ); // User ID used while generating the webhook payload.
    $webhook->set_topic( 'order.created' ); // Event used to trigger a webhook.
    if ( ! empty( $api_keys['consumer_secret'] ) ) {
        $webhook->set_secret( $api_keys['consumer_secret'] ); // Secret to validate webhook when received.
    }
    $webhook->set_delivery_url( site_url() . '/woocommerce/order_created.php' ); // URL where webhook should be sent.
    $webhook->set_status( 'active' ); // Webhook status.
    $save = $webhook->save();
    return $save;
}
