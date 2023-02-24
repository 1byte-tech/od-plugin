<?php 
/**
 * Scripts and Styles render file
 */
class Aod_Enqueue {
    
    public function __construct() {
        // add_action( 'wp_enqueue_scripts', [$this, 'script'] );
        add_action( 'admin_enqueue_scripts', [$this, 'admin_script'] );
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
        
        wp_localize_script( 'jquery', 'aod_localize_script', $aod_localize_script );

    }
}

new Aod_Enqueue();