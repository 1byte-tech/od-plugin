<?php
/* 
 * Add custom checkout field: woocommerce_review_order_before_submit
 */
add_action( 'woocommerce_review_order_before_submit', 'aod_custom_checkout_field' );
function aod_custom_checkout_field() {
    echo '<div id="aod_custom_checkout_field">';
    woocommerce_form_field( 'aod_add_insurance_product', array(
        'type'      => 'checkbox',
        'class'     => array('input-checkbox'),
        'label'     => __('Set up insurance product.', 'axon-order-defense'),
        'default'   => false,
    ),  WC()->checkout->get_value( 'aod_add_insurance_product' ) );
    echo '</div>';
}

/* 
 * Save the custom checkout field in the order meta, when checkbox has been checked
 */
add_action( 'woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta', 10, 1 );
function custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['aod_add_insurance_product'] ) )
        update_post_meta( $order_id, 'aod_add_insurance_product', $_POST['aod_add_insurance_product'] );
}

add_action( 'woocommerce_create_order', function($order, $data) {
    $product = $data->get_value('aod_add_insurance_product');
    $options = get_option( 'aod_options' );
    if ( ! empty( $product ) && ! empty( $options['product_id'] ) ) {
        WC()->cart->add_to_cart( $options['product_id'], 1, '', '', [] );
    }
}, 10, 2);

/* 
 * Update price in cart, checkout, success and admin order
 */
add_action( 'woocommerce_before_calculate_totals', 'before_calculate_totals', 10, 1 );
 
function before_calculate_totals( $cart_obj ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }
    $options = get_option( 'aod_options' );
    // Iterate through each cart item
    foreach( $cart_obj->get_cart() as $key => $value ) {
        if ( ! empty( $options['product_id'] ) && $options['product_id'] == $value['product_id'] ) {
            $price = 15;
            $value['data']->set_price( ( $price ) );
        }
    }
}