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

			wp_send_json_success( [ 'message' => 'success' ] );
		}

		public function setup_product_od() {

			if ( ! isset( $_POST[AOD_NONCE_FIELD] ) || 
				! wp_verify_nonce( $_POST[AOD_NONCE_FIELD], AOD_NONCE )
			) {
				wp_send_json_error( [ 'message' => esc_html__( "Maybe, security verification is failed.", 'axon-order-defense' ) ] );
			}

			$title = sanitize_text_field( $_POST['data'] );

			if ( ! empty( $title ) ) {
				$product_id = wp_insert_post( [
					'post_title'	=> $title,
					'post_type'	=> 'product',
					'post_status' => 'publish',
				] ); 

				if ( ! empty( $product_id ) ) {
					$product = wc_get_product( $product_id );
					$product->set_regular_price( 11 );
					$product->save();
				}
				update_option( 'aod_options', [ 'product_id' => $product_id ] );
			}

			wp_send_json_success( [ 'message' => 'success' ] );
		}

		public function ajax_add_to_cart() {

			if ( ! isset( $_POST[AOD_NONCE_FIELD] ) || 
				! wp_verify_nonce( $_POST[AOD_NONCE_FIELD], AOD_NONCE )
			) {
				wp_send_json_error( [ 'message' => esc_html__( "Maybe, security verification is failed.", 'axon-order-defense' ) ] );
			}

			$data = $this->sanitize_fields( $_POST );
			$product_id = $data['aod_fields']['product_id'];

			wp_send_json_success( [ 'message' => 'success' ] );
		}

		public function sanitize_fields( $data ) {
			return $data;
		}
}

	new Aod_Ajax();
}
