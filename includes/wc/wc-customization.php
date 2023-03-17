<?php
/* 
 * Add custom checkout field: woocommerce_review_order_before_submit
 */
$options = get_option( 'aod_options' );
if ( ! empty( $options['product_id'] ) ) {
    add_action( 'woocommerce_proceed_to_checkout', 'aod_custom_checkout_field' );
    add_action( 'woocommerce_review_order_before_submit', 'aod_custom_checkout_field' );
}

function aod_custom_checkout_field() {

    $options = get_option( 'aod_options' );
    if ( 
        ! empty( $options['product_id'] ) && 
        WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $options['product_id'] ) ) 
    ) {
        $active = 'active';
        $checked = 'checked="checked"';
        echo "<script>jQuery(document).ready(function($){
            $('#aod_add_insurance_product').attr('checked','checked');
            console.log($('#aod_add_insurance_product'));
        });"; 
        echo "</script>";
    } else {
        $active = '';
    }

    ?>
    <div id="aod_custom_checkout_field" class="aod-row <?php echo esc_attr( $active ) ?>">
        <div class="aod-col">
            <i class="aod-svg">
                <img src="https://orderdefense.com/wp-content/uploads/2021/02/OD-Logo-Shield.png" alt="<?php esc_html_e( 'Order Defense', 'axon-order-defense' ) ?>">
            </i>
        </div>
        <div class="aod-col">
            <div class="aod-content">
                <h3><?php esc_html_e( 'Order Defense Shipping Protection', 'axon-order-defense' ); ?></h3>    
                <p><?php esc_html_e( 'By deselecting order protection, you will be liable for lost, damaged,  Or stolen items.', 'axon-order-defense' ); ?></p>    
                <ul>
                    <li>
                        <span class="price">$1.50</span>
                        <label class="aod-switch" for="aod_add_insurance_product">
                            <input type="checkbox" id="aod_add_insurance_product" name="aod_add_insurance_product" />
                            <div class="aod-slider aod-round"></div>
                        </label>
                    </li>
                    <li>
                        <p class="aod-poweredby"><?php esc_html_e( 'Powered by OrderDefense', 'axon-order-defense' ) ?></p>
                    </li>
                </ul>
            </div>
        </div>         
    </div>
    <?php
}

/* 
 * Save the custom checkout field in the order meta, when checkbox has been checked
 */
add_action( 'woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta', 10, 1 );
function custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['aod_add_insurance_product'] ) )
        update_post_meta( $order_id, 'aod_add_insurance_product', $_POST['aod_add_insurance_product'] );
}

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

add_action( 'init', 'aod_wc_admin_int' );

function aod_wc_admin_int() {
    if ( ! is_admin() ) {
        return;
    }
    // Generate wc api keys and webhook for order defense
    if ( isset( $_GET['callback'] ) && $_GET['callback'] == 'aod_api' ) {
        $options = get_option( 'aod_options' ); 
        $request = file_get_contents('php://input');
        $api_keys = json_decode( $request, true );
        if ( ! empty( $api_keys['key_id'] ) ) {            
            $options['wc_api_keys'] = $api_keys;
            $options['wc_webhook_id'] = aod_wc_webhook( $api_keys );

            update_option( 'aod_options', $options );
        }
    };
}
