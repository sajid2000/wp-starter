<?php

namespace WP_Starter;

/**
 * REST_API Handler
 */
class Api {

    /**
     * Plugin name.
     *
     * @var string
     */
    private $plugin_name;

    /**
     * Class constructor
     */
    public function __construct( $plugin_name ) {
        $this->plugin_name = $plugin_name;

        $this->includes();

        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    /**
     * Include the controller classes
     *
     * @return void
     */
    private function includes() {
        if ( ! class_exists( __NAMESPACE__ . '\Api\Example'  ) ) {
            require_once __DIR__ . '/Api/Example.php';
        }
    }

    /**
     * Register the API routes
     *
     * @return void
     */
    public function register_routes() {
        // (new Api\Example())->register_routes();
    }

}
