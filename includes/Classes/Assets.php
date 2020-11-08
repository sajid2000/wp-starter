<?php

namespace WP_Starter\Classes;

/**
 * Assets class that handle all the Assets
 */
class Assets {

    /**
     * Plugin name.
     *
     * @var string
     */
    private $plugin_name;

    /**
     * Plugin assets url
     *
     * @var string
     */
    public $assets_url;

    /**
     * Plugin assets path
     *
     * @var string
     */
    public $assets_path;

    /**
     * Assets class constructor
     */
    public function __construct( $plugin_name ) {
        $this->plugin_name = $plugin_name;
        $this->assets_url  = WP_STARTER_ASSETS;
        $this->assets_path = WP_STARTER_DIR . '/assets';

        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
        } else {
            add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        }
    }

    /**
     * Enqueue all frontend assets for this plugin
     *
     * @return void
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_script( "{$this->plugin_name}-script" );
        wp_enqueue_style( "{$this->plugin_name}-style" );
    }

    /**
     * Enqueue all admin assets for this plugin
     *
     * @return void
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_script( "{$this->plugin_name}-admin-script" );
        wp_enqueue_style( "{$this->plugin_name}-admin-style" );
    }

    /**
     * Register all the scripts and styles for the plugin
     *
     * @return void
     */
    public function register_assets() {
        foreach ( $this->get_scripts() as $handle => $script ) {
            $version    = $script['version'];
            $dependency = $script['dependency'];
            $in_footer  = isset( $script['in_footer'] ) ? $script['in_footer'] : true;

            wp_register_script( $handle, $script['src'], $dependency, $version, $in_footer );
        }
        
        foreach ( $this->get_styles() as $handle => $style ) {
            $dependency = isset( $style['dependency'] ) ? $style['dependency'] : false;
            $version    = $style['version'];

            wp_register_style( $handle, $style['src'], $dependency, $version );
        }

        do_action( "{$this->plugin_name}_register_scripts" );
    }

    /**
     * Get all the js scripts
     *
     * @return array
     */
    public function get_scripts() {
        $admin = [
            "{$this->plugin_name}-admin-script" => [
                'src'        => $this->assets_url . '/js/admin-script.js',
                'dependency' => [ 'jquery' ],
                'version'    => filemtime( $this->assets_path . '/js/admin-script.js' ),
            ],
        ];
        $frontend = [
            "{$this->plugin_name}-script" => [
                'src'        => $this->assets_url . '/js/script.js',
                'dependency' => [ 'jquery' ],
                'version'    => filemtime( $this->assets_path . '/js/script.js' ),
            ],
        ];

        return is_admin() ? $admin : $frontend;
    }

    /**
     * Get all the css styles
     *
     * @return array
     */
    public function get_styles() {
        $admin = [
            "{$this->plugin_name}-admin-style" => [
                'src'     => $this->assets_url . '/css/admin-style.css',
                'version' => filemtime( $this->assets_path . '/css/admin-style.css' ),
            ],
        ];
        $frontend = [
            "{$this->plugin_name}-style" => [
                'src'     => $this->assets_url . '/css/style.css',
                'version' => filemtime( $this->assets_path . '/css/style.css' ),
            ],
        ];

        return is_admin() ? $admin : $frontend;
    }
    
}
