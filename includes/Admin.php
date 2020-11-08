<?php

namespace WP_Starter;

use WP_Starter\Admin\Action;
use WP_Starter\Admin\Menu;
use WP_Starter\Classes\Assets;
use WP_Starter\Traits\Hooker;

/**
 * Admin class that handle all the admin functionality
 */
class Admin {

    use Hooker;

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
     * Admin class constructor
     */
    public function __construct( $plugin_name, Assets $assets ) {
        $this->assets      = $assets;
        $this->plugin_name = $plugin_name;

        $this->action( 'admin_menu', 'register_menus' );
    }

    /**
     * Register admin menus
     * 
     * @return void
     */
    public function register_menus() {
        $menu = new Menu();
        $hook = $menu->register();

        $this->action( 'admin_head-' . $hook, 'admin_enqueue_scripts' );
    }

    /**
     * Enqueue all admin scripts for this plugin
     *
     * @return void
     */
    public function admin_enqueue_scripts() {
        $this->assets->enqueue_admin_scripts();

        do_action( "{$this->plugin_name}_enqueue_admin_scripts" );
    }

}
