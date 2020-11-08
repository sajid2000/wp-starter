<?php

namespace WP_Starter\Admin;

use  WP_Starter\Traits\Hooker;

/**
 * The ajax handler class
 */
class Ajax {

    use Hooker;

    /**
     * Bind events
     */
    public function __construct() {
        // $this->action( 'wp_ajax_action', 'callback');
    }

    /**
     * Verify request nonce
     *
     * @param  string $action  The nonce action name.
     */
    public function verify_nonce( $action ) {
        if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], $action ) ) {
            wp_send_json_error( __( 'Error: Nonce verification failed', 'textdomain' ) );
        }
    }
}

new Ajax();
