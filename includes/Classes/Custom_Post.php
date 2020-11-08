<?php

namespace WP_Starter\Classes;

class Custom_Post {

    /**
     * Register all Custom Post Type
     * 
     * @return void
     */
    public function register() {
        foreach ( $this->get_post_type() as $key => $args ) {
            register_post_type( $key, $args );
        }
    }

    /**
     * Get all custom post type
     * 
     * @return array
     */
    public function get_post_type() {
        // default custom post
        return array(
            // 'wp_starter-post-type' => $this->parse_default( 'WP Starter Post', 'WP Starter Posts', [
            //     'public'    => false,
            //     'menu_icon' => 'dashicons-update',
            // ]),
        );
    }

    /**
     * Parse Custom post type arguments with default
     * 
     * @param  string  $singular_name
     * @param  string  $plural_name
     * @param  array   $args
     * 
     * @return array
     */
    Protected function parse_default( $singular_name, $plural_name, $args = array() ) {
        $default_args = [
            'labels' => [
                'name'          => esc_html__( $plural_name, 'textdomain' ),
                'singular_name' => esc_html__( $singular_name, 'textdomain' ),
                'all_items'     => esc_html__( 'All ' . $plural_name, 'textdomain' ),
                'add_new_item'  => esc_html__( 'Add ' . $singular_name, 'textdomain' ),
                'edit_item'     => esc_html__( 'Edit '. $singular_name, 'textdomain' ),
                'view_item'     => esc_html__( 'View '. $singular_name, 'textdomain' ),
                'search_items'  => esc_html__( 'no '  . $plural_name .' found', 'textdomain' ),
            ],
            'description'   => '',
            'supports'      => [ 'title', 'editor', 'thumbnail' ],
            'public'        => true,
            'show_in_menu'  => true,
            'show_ui'       => true,
            'menu_position' => 5,
        ];

        return wp_parse_args( $args, $default_args );
    }

}
