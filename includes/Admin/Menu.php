<?php

namespace WP_Starter\Admin;

/**
 * Admin Menu handler class
 */
class Menu {

    /**
     * Plugin slug.
     *
     * @var string
     */
    private $plugin_slug;

    /**
     * Bind events
     */
    public function __construct() {
        $this->plugin_slug = wp_starter()->get_plugin_slug();
    }

    /**
     * Create menu for this plugin
     *
     * @return string The resulting page's hook_suffix.
     */
    public function register() {
        $capability  = 'manage_options';

        $hook = add_menu_page(
            __( 'WP Starter', 'textdomain' ),
            __( 'WP Starter', 'textdomain' ),
            $capability,
            $this->plugin_slug,
            [ $this, 'menu_page' ],
            'dashicons-welcome-learn-more'
        );

        $this->add_submenu( $this->plugin_slug, __( 'WP Starter', 'textdomain' ), $capability );
        $this->add_submenu( $this->plugin_slug, __( 'Settings', 'textdomain' ), $capability, 'settings' );

        return $hook;
    }

    /**
     * Add submenu to a menu
     * 
     * @param string       $parent_slug
     * @param string       $title
     * @param string       $capability
     * @param string       $menu_slug
     * @param string       $callback
     * @param integer|null $position
     *
     * @return string|false The resulting page's hook_suffix, or false if the user does not have the capability required.
     */
    public function add_submenu( $parent_slug, $title, $capability, $menu_slug = '', $callback = 'menu_page', $position = null ) {
        $menu_slug = ( $menu_slug != '' ) ? "{$parent_slug}-{$menu_slug}" : $parent_slug;

        return add_submenu_page( $parent_slug, $title, $title, $capability, $menu_slug, [ $this, $callback ], $position );
    }

    /**
     * Menu page handler
     * 
     * @return void
     */
    public function menu_page() {
        $action = isset( $_GET['page'] ) ? $_GET['page'] : 'default' ;

        switch ( $action ) {
            case "{$this->plugin_slug}-settings":
                $page = __DIR__ . '/views/settings.php';
                break;

            default:
                $page = __DIR__ . '/views/default.php';
                break;
        }

        if ( file_exists( $page ) ) {
            require_once $page;
        }
    }
}


