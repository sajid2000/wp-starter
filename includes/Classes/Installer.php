<?php

namespace WP_Starter\Classes;

/**
 * Installer class that handle the Installation preccess
 */
class Installer {

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
    }
    
    /**
     * Run the installation proccess
     *
     * @return void
     */
    public function run() {
        if ( ! get_option( "{$this->plugin_name}_installed" ) ) {
            update_option( "{$this->plugin_name}_installed", time() );
        }

        update_option( "{$this->plugin_name}_version", WP_STARTER_VERSION );
    }
}
