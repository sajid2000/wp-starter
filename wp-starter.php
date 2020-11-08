<?php
/*
 * Plugin Name: WP Starter Plugin
 * Plugin URI: https://example.com/
 * Description: A WordPress starter plugin
 * Version: 1.0.0
 * Author: Sajid
 * Author URI: https://example.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: textdomain
 * Domain Path: /i18n/languages/
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/includes/Autoloader.php';

/**
 * WP_Starter the class that holds the entire plugin
 */
class WP_Starter {

    use \WP_Starter\Traits\Singletonable;

    /**
     * Plugin version
     * 
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Plugin name.
     *
     * @var string
     */
    private $plugin_name = 'wp_starter';

    /**
     * Plugin slug.
     *
     * @var string
     */
    private $plugin_slug = 'wp-starter';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param string $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param string $prop
     *
     * @return bool
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Constructor of WP_Starter class
     * 
     * Set up all the appropriate hooks with the plugin
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
     * Define all constants
     *
     * @return void
     */
    private function define_constants() {
        define( 'WP_STARTER_VERSION', $this->version );
        define( 'WP_STARTER_FILE', str_replace( '\\', '/', __FILE__ ) );
        define( 'WP_STARTER_DIR', dirname( WP_STARTER_FILE ) );
        define( 'WP_STARTER_URL', plugin_dir_url( WP_STARTER_FILE ) );
        define( 'WP_STARTER_ASSETS', WP_STARTER_URL . '/assets' );
    }

    /**
     * Run installation proccess when plugin activeted
     *
     * @return void
     */
    public function activate() {
        $this->container['installer'] = new WP_Starter\Classes\Installer( $this->plugin_name );
        $this->installer->run();

        do_action( "{$this->plugin_name}_activated" );
    }

    /**
     * Run uninstallation proccess when plugin deactiveted
     *
     * @return void
     */
    public function deactivate() {}

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init() {
        do_action( "{$this->plugin_name}_before_init" );

        $this->init_hooks();

        do_action( "{$this->plugin_name}_init" );

        $this->load_dependency();

        do_action( "{$this->plugin_name}_loaded" );
    }

    /**
     * Initialize all the plugin hooks
     *
     * @return void
     */
    private function init_hooks() {
        // add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ] );
        add_action( 'init', [ $this, 'load_textdomain' ] );
        // add_action( 'init', [ new WP_Starter\Classes\Custom_Post(), 'register' ] );
        // add_action( 'widgets_init', [ new WP_Starter\Common\Sidebar( $this->plugin_name ), 'register' ] );
    }

    /**
     * Initialize plugin for localization
     *
     * @return void
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'textdomain', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/languages/' );
    }

    /**
     * Load all plugin required dependency
     *
     * @return void
     */
    private function load_dependency() {
        require_once __DIR__ . '/includes/functions.php';

        $this->container['assets']   = new WP_Starter\Classes\Assets( $this->plugin_name );
        // $this->container['template'] = new WP_Starter\Classes\Template( $this->plugin_name );
        // $this->container['api']      = new WP_Starter\Api( $this->plugin_name );

        if ( is_request( 'admin' ) ) {
            $this->container['admin'] = new WP_Starter\Admin( $this->plugin_name, $this->assets );
        } elseif ( is_request( 'frontend' ) ) {
            $this->container['frontend'] = new WP_Starter\Frontend( $this->plugin_name, $this->assets );
        }
    }

    /**
     * Get template path
     *
     * @return string
     */
    public function template_path() {
        return $this->template->get_template_path();
    }

    /**
     * Get plugin slug
     *
     * @return string
     */
    public function get_plugin_slug() {
        return $this->plugin_slug;
    }

}

function wp_starter() {
    return WP_Starter::instance();
}

wp_starter();