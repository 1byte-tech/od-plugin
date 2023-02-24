<?php
/**
 * Plugin Name: Order Defense for WooCommerce
 * Description: Order Defense is a Delivery Insurance Integration Plugin for WooCommerce Platform.
 * Plugin URI:  https://axontech.pk/
 * Version:     1.0
 * Author:      Axon
 * Author URI:  https://axontech.pk/
 * Text Domain: axon-order-defense
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'AOD_PL_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AOD_PL_DIR_URL', plugin_dir_url( __FILE__ ) );

define( 'AOD_NONCE', 'aod_nonce' );
define( 'AOD_NONCE_FIELD', 'aod_nonce_field' );

add_action( 'init', function(){
    load_plugin_textdomain( 'axon-order-defense', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
} );

function aod_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=aod_setting' ) )  );
    }
}
add_action( 'activated_plugin', 'aod_activation_redirect' );

require_once( AOD_PL_DIR_PATH . '/includes/aod-load.php' );