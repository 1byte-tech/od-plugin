<?php 
/**
 * Ajax Handling
 */

if ( ! class_exists( 'Aod_Ajax' ) ) {
	class Aod_Ajax
	{
		
		function __construct()
		{
			add_action( 'wp_ajax_aod_ajax', [ $this, 'ajax_handler' ] );
			add_action( 'wp_ajax_nopriv_aod_ajax', [ $this, 'ajax_handler' ] );
		}

		public function ajax_handler() {
			$method = isset( $_REQUEST['subaction'] ) ? $_REQUEST['subaction'] : '';
			if ( method_exists( $this, $method ) ) { 
				$this->$method();
			}
			exit();
		}

		public function register_od() {

			if ( ! isset( $_POST[AOD_NONCE_FIELD] ) || 
					! wp_verify_nonce( $_POST[AOD_NONCE_FIELD], AOD_NONCE )
				) {
					wp_send_json_error( [ 'message' => esc_html__( "Maybe, security verification is failed.", 'axon-order-defense' ) ] );
			}
			wp_send_json_success( [ 'message' => 'success' ] );
		}

		public function setup_billing_od() {

			if ( ! isset( $_POST[AOD_NONCE_FIELD] ) || 
				! wp_verify_nonce( $_POST[AOD_NONCE_FIELD], AOD_NONCE )
			) {
				wp_send_json_error( [ 'message' => esc_html__( "Maybe, security verification is failed.", 'axon-order-defense' ) ] );
			}

			wp_send_json_success( [ 'message' => 'success' ] );
		}

		public function api_permission_od() {

			if ( ! isset( $_POST[AOD_NONCE_FIELD] ) || 
				! wp_verify_nonce( $_POST[AOD_NONCE_FIELD], AOD_NONCE )
			) {
				wp_send_json_error( [ 'message' => esc_html__( "Maybe, security verification is failed.", 'axon-order-defense' ) ] );
			}

			$options = get_option( 'aod_options' );
			if ( ! empty( $options['wc_api_keys']['key_id'] ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Maybe, you have already given Api permission to order defense.', 'axon-order-defense' ) ] );
			}
			aod_generate_wc_api_keys();

			wp_send_json_success( [ 'message' => 'success' ] );
		}

		public function setup_product_od() {

			if ( ! isset( $_POST[AOD_NONCE_FIELD] ) || 
					! wp_verify_nonce( $_POST[AOD_NONCE_FIELD], AOD_NONCE )
				) {
					wp_send_json_error( [ 'message' => esc_html__( "Maybe, security verification is failed.", 'axon-order-defense' ) ] );
			}

			$title = sanitize_text_field( $_POST['data'] );
			$options = get_option( 'aod_options' );
			$check_product = wc_get_product( $options['product_id'] );

			if ( 
				! empty( $title ) && 
				empty( $check_product ) 
			) {
				$product_id = wp_insert_post( [
					'post_title'	=> $title,
					'post_type'	=> 'product',
					'post_status' => 'draft',
				] ); 

				if ( ! empty( $product_id ) ) {
					$product = wc_get_product( $product_id );
					$product->set_regular_price( 11 );
					$product->set_sold_individually( true );
					$product->save();
				}

				$options['product_id'] = $product_id;
				update_option( 'aod_options', $options );
			} else {
				$product_link = ( $options['product_id'] ) ? "<a href=". get_permalink( $options['product_id'] ) .">'". esc_html__( 'Link', 'axon-order-defense' ) ."'</a>" : '';
				wp_send_json_error( [ 
					'message' => sprintf( "%s %s", 
						esc_html__( "You have already set up insurance product or field is empty.", 'axon-order-defense' ), 
						$product_link
					) 
				] );
			}

			wp_send_json_success( [ 'message' => 'success' ] );
		}

		public function add_to_cart_insurance_product() {

			if ( ! isset( $_POST[AOD_NONCE_FIELD] ) || 
				! wp_verify_nonce( $_POST[AOD_NONCE_FIELD], AOD_NONCE )
			) {
				wp_send_json_error( [ 'message' => esc_html__( "Maybe, security verification is failed.", 'axon-order-defense' ) ] );
			}

			$data = $_POST['data'];

			$options = get_option( 'aod_options' );
			if ( 
				WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $options['product_id'] ) ) && 
				$data == 'true' 
			) {
				wp_send_json_error( [ 'message' => esc_html__( 'Product is already in cart.', 'axon-order-defense' ) ] );
			} else {
				if ( ! empty( $options['product_id'] ) && $_POST['data'] == 'true' ) {
					WC()->cart->add_to_cart( $options['product_id'], 1, '', '', [] );
					wp_send_json_success( [ 'message' => esc_html__( 'Product has been added in cart successfully.', 'axon-order-defense' ) ] );
				}
				if ( $_POST['data'] == 'false' ) {
					$product_cart_id = WC()->cart->generate_cart_id( $options['product_id'] );
					$cart_item_key = WC()->cart->find_product_in_cart( $product_cart_id );
					if ( $cart_item_key ) {
						WC()->cart->remove_cart_item( $cart_item_key );
						wp_send_json_error( [ 'message' => esc_html__( 'Product removed successfully from cart.', 'axon-order-defense' ) ] );
					}
				}
			}

		}
	}

	new Aod_Ajax();
}
