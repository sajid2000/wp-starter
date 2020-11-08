<?php 

if ( ! function_exists( 'is_rest_api_request' ) ) {
    /**
     * Check if the request is REST API request
     *
     * @return bool
     */
    function is_rest_api_request() {
        if ( empty( $_SERVER['REQUEST_URI'] ) ) {
            return false;
        }

        return ( strpos( $_SERVER['REQUEST_URI'], trailingslashit( rest_get_url_prefix() ) ) );
    }
}

if ( ! function_exists( 'is_request' ) ) {
    /**
     * Check a request type
     *
     * @param string $type
     * 
     * @return boolean
     */
    function is_request( $type ) {
        switch ( $type ) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return wp_doing_ajax();
            case 'cron':
                return wp_doing_cron();
            case 'rest_api':
                return is_rest_api_request();
            case 'frontend':
                return ( ! is_admin() && ! defined( 'DOING_AJAX' ) && ! defined( 'DOING_CRON' ) && ! is_rest_api_request() );
        }
    }
}

if ( ! function_exists( 'array_default' ) ) {
    /**
     * If array key exists get the value or return the default passed value
     *
     * @param string $type
     * @param array  $type
     * @param mixed  $type
     * 
     * @return boolean
     */
    function array_default( $key, array $array, $default = '' ) {
        if ( isset( $array[ $key ] ) ) {
            return $array[ $key ];
        }

        return $default;
    }
}