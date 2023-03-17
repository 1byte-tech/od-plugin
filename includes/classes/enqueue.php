<?php 
/**
 * Scripts and Styles render file
 */
class Aod_Enqueue {
    
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'script'] );
        add_action( 'admin_enqueue_scripts', [$this, 'admin_script'] );
    }

    public function script() {
        $scripts = [
            'aod-script' => 'assets/js/script.js'
        ];

        foreach( $scripts as $key => $val  ) {
            wp_register_script( $key, AOD_PL_DIR_URL . $val, ['jquery'], false, true );
        }

        $styles = [
            'aod-style' => 'assets/css/style.css'
        ];

        foreach( $styles as $key => $val  ) {
            wp_register_style( $key, AOD_PL_DIR_URL . $val, [], false );
        }

        wp_enqueue_style( 'aod-style' );

        wp_enqueue_script( [ 'jquery', 'aod-script'] );


        $aod_localize_script = [
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'aod_nonce_field'  => wp_create_nonce( AOD_NONCE ),
        ];
        
        $options = get_option( 'aod_options' );
        if ( 
            ! empty( $options['product_id'] ) && 
            WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $options['product_id'] ) ) 
        ) {
            $aod_localize_script['aod_already_added'] = true;
        } else {
            $aod_localize_script['aod_already_added'] = false;
        }
        
        wp_localize_script( 'jquery', 'aod_localize_script', $aod_localize_script );

    }

    public function admin_script() {
        $scripts = [
            'aod-admin-script' => 'assets/js/admin-script.js'
        ];

        foreach( $scripts as $key => $val  ) {
            wp_register_script( $key, AOD_PL_DIR_URL . $val, ['jquery'], false, true );
        }

        $styles = [
            'aod-admin-style' => 'assets/css/admin-style.css'
        ];

        foreach( $styles as $key => $val  ) {
            wp_register_style( $key, AOD_PL_DIR_URL . $val, [], false );
        }

        wp_enqueue_script( [ 'jquery', 'aod-admin-script'] );

        $aod_localize_script = [
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'aod_nonce_field'  => wp_create_nonce( AOD_NONCE ),
        ];

        if ( isset( $_GET['success'] ) && $_GET['page'] == 'aod_setting' ) {
            $aod_localize_script['success'] = $_GET['success']; 
        } else {
            $aod_localize_script['success'] = null; 
        }
        
        wp_localize_script( 'jquery', 'aod_localize_script', $aod_localize_script );

    }
}

new Aod_Enqueue();