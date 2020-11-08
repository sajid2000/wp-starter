<?php

namespace WP_Starter\Classes;

/**
 * Template class that handle all the templates functionality
 */
class Template {

    /**
     * Plugin name
     *
     * @var string
     */
    private $plugin_name;

    /**
     * Contain plugin base path
     *
     * @var string
     */
    private $plugin_path;

    /**
     * Is plugin support defined in the activated theme
     *
     * @var bool
     */
    private $theme_support;

    /**
     * Contain template path
     *
     * @var string
     */
    private $template_path;
    
    /**
     * Template class constructor
     */
    public function __construct( $plugin_name ) {
        $this->plugin_name   = $plugin_name;
        $this->plugin_path   = WP_STARTER_DIR;
        $this->template_path = "{$plugin_name}/";
        $this->theme_support = current_theme_supports( "{$plugin_name}" );

        add_filter( 'template_include', [ $this, 'template_include' ] );
    }

    public function template_include( $template ) {
        return $template;
    }

    /**
     * Get template part
     * Look at theme directory first
     *
     * @param string $slug
     * @param string $name
     * @param array  $args
     * 
     * @return void
     */
    public function get_template_part( $slug, $name = '', array $args = [] ) {
        extract( $args );

        $template = '';

        // look at theme directory first
        $theme_template = locate_template( array( $this->template_path . "{$slug}-{$name}.php", $this->template_path . "{$slug}.php" ) );

        // get default template from plugin
        $plugin_template = ( $name !== '' ) ? $this->plugin_path . "/templates/{$slug}-{$name}.php" : $this->plugin_path . "/templates/{$slug}.php";

        if ( ( $theme_template == '' ) && file_exists( $plugin_template ) ) {
            $template = $plugin_template;
        }

        $template = apply_filters( "{$this->plugin_name}_get_template_part", $template, $name, $args );

        file_exists( $template ) && require $template;
    }

    /**
     * Get template path
     *
     * @return string
     */
    public function get_template_path() {
        return apply_filters( "{$this->plugin_name}_template_path", $this->template_path );
    }

}
