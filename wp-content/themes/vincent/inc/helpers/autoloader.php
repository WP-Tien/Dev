<?php 
/**
 * Autoloader files
 * 
 * @package Vincent
 */

namespace Vincent\Inc\Helpers;

/**
 * Register given function as __autoload() implementation
 * 
 * @see https://www.php.net/manual/en/function.spl-autoload-register.php
 * @param string $class_name Source namespace
 * 
 * @return void
 */ 
spl_autoload_register( function( $classes = '' ) {
    $classes_path = false;
    $namespace_root = 'Vincent\\';
    $classes = trim( $classes, '\\' );

    if ( empty( $classes ) || strpos( $classes, '\\' ) === false || strpos( $classes, $namespace_root ) !== 0 ) {
        // Not our namespace, bail out.
        return;
    }

    // Remove out root namespace.
    $classes = str_replace( $namespace_root, '', $classes );

    $path = explode(
        '\\',
        str_replace( '_', '-', strtolower( $classes ) )
    );

    /**
     * Time to determine which type of resource path it is,
     * so that we can deduce the correct file path for it.
     */
    if ( empty( $path[0] ) || empty( $path[1] ) ) {
        return;
    }

    $dir = '';
    $file_name = '';

    if ( 'inc' === $path[0] ) {
        switch ( $path[1] ) {
            case 'traits':
                $dir = 'traits';
                $file_name = sprintf( 'trait-%s', trim( strtolower( $path[2] ) ) );
                break;

            default:
                $dir = 'classes';
                $file_name = sprintf( 'class-%s', trim( strtolower( $path[1] ) ) );
                break;

        }
    }

    $resource_path = sprintf( '%s/inc/%s/%s.php', untrailingslashit( VINCENT_PATH ), $dir, $file_name );

    /**
	 * If $is_valid_file has 0 means valid path or 2 means the file path contains a Windows drive path.
	 */
	$is_valid_file = validate_file( $resource_path );

    if ( !empty( $resource_path ) && file_exists( $resource_path ) && ( 0 === $is_valid_file || 2 === $is_valid_file ) ) { 
        require_once( $resource_path );
    }    
});