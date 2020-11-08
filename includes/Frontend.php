<?php

namespace WP_Starter;

use WP_Starter\Classes\Assets;

/**
 * Frontend class that handle all the Frontend functionality
 */
class Frontend {

    /**
     * Plugin name.
     *
     * @var string
     */
    private $plugin_name;

    /**
     * Hold \WP_Starter\Classes\Assets class instance
     * 
     * @var object
     */
    private $assets;
    
    /**
     * Frontend class constructor
     */
    public function __construct( $plugin_name, Assets $assets ) {
        $this->assets      = $assets;
        $this->plugin_name = $plugin_name;
    }

    /**
     * Enqueue all front scripts
     *
     * @return void
     */
    public function front_enqueue_scripts() {
        $this->assets->enqueue_frontend_scripts();

        do_action( "{$this->plugin_name}_enqueue_frontend_scripts" );
    }
}
