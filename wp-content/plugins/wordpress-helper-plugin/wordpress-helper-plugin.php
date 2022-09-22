<?php 
/**
 * @package APIs plugin
 */

/**
 * Plugin Name: Wordpress APIs 
 * Plugin URI: https://www.facebook.com/Tien.it.ntt/
 * Description: This plugin was created for multiple purposes. Generate Apis to create cpt, admin page, customfield...
 * Version: 1.0
 * Author: Huu Tien
 * Author URI: https://www.facebook.com/Tien.it.ntt/
 * License: GPLv2 or later
 * Text Domain: wordpress-helper
 */

defined('ABSPATH') or die('GET OUT MY PLUGIN');

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Define all instances
 */
defined( 'APIS_NAME' )          ? "" : define( 'APIS_NAME', 'wordpressHelperPlugin' );
defined( 'APIS_VERSION' )       ? "" : define( 'APIS_VERSION', '1.0.0' );
defined( 'APIS_OUT_FOLDER' )    ? "" : define( 'APIS_OUT_FOLDER', 'wordpress-helper-plugin/dist' );
defined( 'APIS_URL' )           ? "" : define( 'APIS_URL', plugin_dir_url( __FILE__ ) );
defined( 'APIS_DS' )            ? "" : define( 'APIS_DS', DIRECTORY_SEPARATOR );
defined( 'APIS_PATH' )          ? "" : define( 'APIS_PATH', plugin_dir_path( __FILE__ ) );
defined( 'APIS_UPLOAD_DIR' )    ? "" : define( 'APIS_UPLOAD_DIR', wp_get_upload_dir() );

/** 
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
    Inc\Init::get_instance();
}