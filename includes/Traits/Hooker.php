<?php
namespace WP_Starter\Traits;

/**
 * Class Hooker
 */
trait Hooker {

    /**
     * Hooks a function of this class on to a specific action.
     *
     * @param string   $tag
     * @param string   $function
     * @param integer  $priority
     * @param integer  $accepted_args
     *
     * @return void
     */
    public function action( $tag, $function, $priority = 10, $accepted_args = 1 ) {
        add_action( $tag, [ $this, $function ], $priority, $accepted_args );
    }

    /**
     * Hooks a function of this class on to a specific filter.
     *
     * @param string   $tag
     * @param string   $function
     * @param integer  $priority
     * @param integer  $accepted_args
     *
     * @return void
     */
    public function filter( $tag, $function, $priority = 10, $accepted_args = 1 ) {
        add_filter( $tag, [ $this, $function ], $priority, $accepted_args );
    }
}