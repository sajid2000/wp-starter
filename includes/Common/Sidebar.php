<?php

namespace WP_Starter\Common;

/**
 * Sidebar class handle Sidebar registration
 */
class Sidebar {

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

    public function register() {
        $this->register_sidebar();
        $this->register_widgets();
    }

    /**
     * Register all the plugin sidebar
     * 
     * @return void
     */
    public function register_sidebar() {
    	foreach ( $this->get_sidebars() as $id => $name ) {
    		register_sidebar( [
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
    		] );
    	}
    }

    public function get_sidebars() {
    	return [
            "{$this->plugin_name}-sidebar"        => __( 'WP Starter Sidebar', 'textdomain' ),
    	];
    }

    public function register_widgets() {
        register_widget( new \WP_Starter\Common\Widgets\Recent_Posts() );
    }

}