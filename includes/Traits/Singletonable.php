<?php

namespace WP_Starter\Traits;

/**
 * Singletonable trait
 */
trait Singletonable {

    /**
     * Singletonable class instance container
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * Make a class instance
     *
     * @return object
     */
    public static function instance() {
        if ( is_null( static::$instance ) ) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Disable class cloning
     *
     * @return void
     */
    public function __clone() {} 

    /**
     * Disable unserializing of the class
     *
     * @return void
     */
    public function __wakeup() {} 

}
