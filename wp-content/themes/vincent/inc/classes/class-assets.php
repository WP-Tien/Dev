<?php 
/**
 * Enqueu theme assets
 * 
 * @package Vincent
 */

namespace Vincent\Inc;

use Vincent\Inc\Traits\Singleton;

class Assets {
    use Singleton;

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
    }

    public function register_scripts() {
        wp_enqueue_script( 'vincent-main', VINCENT_BUILD . '/index.js', ['wp-element'], '1.0.0', true );

        wp_enqueue_style( 'vincent-main', VINCENT_BUILD . '/index.css', [], '1.0.0', false);
    }
}