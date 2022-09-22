<?php 
/**
 * Theme setup
 * 
 * @package Vincent
 */

namespace Vincent\Inc;

use Vincent\Inc\Traits\Singleton;

class Theme {
    use Singleton;

    public function __construct() {
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

		// Load class.
        Assets::get_instance();
    }

    /**
     * Setup theme
     * 
     * @return void
     */
    public function setup_theme() {
        load_theme_textdomain( 'vincent', get_template_directory() . '/languages' );

        add_theme_support(
            'editor-color-palette',
            [
                [
                    'name'	=> 'White',
                    'slug'	=> 'white',
                    'color'	=> '#ffffff',
                ],
                [
                    'name'	=> 'Black',
                    'slug'	=> 'black',
                    'color'	=> "#000000"
                ]
            ]
        );

        add_theme_support(
            'editor-font-size',
            [
                [
                    'name'	=> 'Normal',
                    'size'	=> 16,
                    'slug'	=> 'normal'
                ],
                [
                    'name'	=> 'Large', 
                    'size'	=> 24,
                    'slug'	=> 'large'
                ]
            ]
        );

        add_theme_support( 'wp-block-styles' );

        add_editor_style( 'style.css' );
    }
}