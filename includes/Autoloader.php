<?php

namespace WP_Starter;

/**
 * Autoloader class
 */
class Autoloader {

    /**
     * Path of the `includes` directory
     *
     * @var string
     */
    public $incDir;
    
    /**
     * Autoloader class constructor
     */
    public function __construct() {
        $this->incDir = __DIR__ . '/';

        spl_autoload_register( [ $this, 'autoload' ] );
    }

    /**
     * Autoload classes
     *
     * @param string $class
     * 
     * @return void
     */
    public function autoload( $class ){
        $file_name = $this->get_file_name_from_class( $class );
        
        if ( ! empty( $file_name ) ) {
            $this->load( $this->incDir . $file_name . '.php' );
        }
    }

    /**
     * Get the file name
     *
     * @param string $class
     * 
     * @return string
     */
    public function get_file_name_from_class( $class ){
        return trim( str_replace( [ '\\', 'WP_Starter' ], [ '/', '' ], $class ), '/' );
    }

    /**
     * Include a file based on given path
     *
     * @param string $path
     * 
     * @return bool
     */
    public function load( $path ){
        if ( file_exists( $path ) ) {
            require_once $path;
        }
    }

}

new Autoloader();