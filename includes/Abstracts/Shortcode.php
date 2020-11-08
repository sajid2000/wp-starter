<?php

namespace WP_Starter\Abstracts;

/**
 * Abstract Shortcode class
 *
 * This class will be extended by all shortcode class
 */
abstract class Shortcode {

	/**
	 * Name of the shortcode
	 * 
	 * @var string
	 */
	protected $shortcode = '';

    /**
     * Class constructor
     */
    public function __construct() {
		$function = static::class;
		$message  = '$shortcode property is empty';
		$version  = WP_STARTER_VERSION;

        if ( ! $this->shortcode ) {
        	if ( is_request('ajax') || is_request('rest_api') ) {
				do_action( 'doing_it_wrong_run', $function, $message, $version );
				error_log( "{$function} was called incorrectly. {$message}. This message was added in version {$version}." );
			} else {
				_doing_it_wrong( $function, $message, $version );
			}
        }

        add_shortcode( $this->shortcode, [ $this, 'render' ] );
    }

    /**
     * Get the shortcode
     * 
     * @return string
     */
    public function get_shortcode() {
    	return $this->shortcode;
    }

    /**
     * Render shortcode markup
     * 
     * @param  array  $atts
     * @param  string $content
     * 
     * @return void
     */
    abstract public function render( $atts, $content = '' );
}