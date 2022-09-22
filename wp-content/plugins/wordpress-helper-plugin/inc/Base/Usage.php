<?php 

/**
 * @package APIs plugin
 * 
 * This class support functions to usage
 */

namespace Inc\Base; 

class Usage {

    /**
     * Generate log file for debuging
     * 
     * @param mixed log input
     */
    public static function write_log( $log ) {
        $upload_dir = wp_upload_dir();

        $log_file_name = $upload_dir['basedir'] . "/log";

        if ( ! file_exists( $log_file_name ) ) {
            $res = mkdir( $log_file_name, 0777, true );    
        }

        $log_file_data = $log_file_name . '/strava_log_' .date( 'd-M-Y' ) . '.log';

        // If you don't add `FILE_APPEND`, the file will be erased each time you add a log
        ob_start();
        var_dump( $log . " || time: " .date( "d-m-Y H:m:s", time() ) );            
        $log = ob_get_contents();
        file_put_contents( $log_file_data, $log . "\n", FILE_APPEND );
    }
}