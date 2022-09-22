<?php
/**
 * @package Vincent
 */
if ( !defined( 'VINCENT_PATH' ) ) {
	define( 'VINCENT_PATH', untrailingslashit( get_template_directory() ) );
}

if ( !defined( 'VINCENT_URI' ) ) {
	define( 'VINCENT_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( !defined( 'VINCENT_BUILD' ) ) {
	define( 'VINCENT_BUILD', untrailingslashit( get_template_directory_uri() ) . '/build' );
}

if ( !defined( 'VINCENT_IMG' ) ) {
	define( 'VINCENT_IMG', untrailingslashit( get_template_directory_uri() ) . '/img' );
}

require_once VINCENT_PATH . '/inc/helpers/autoloader.php';

if( class_exists( '\Vincent\Inc\Theme' ) ){
	\Vincent\Inc\Theme::get_instance();
}