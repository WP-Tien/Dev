<?php 

/**
 * @package APIs plugin
 */

namespace Inc\Base;

class SettingOptions {
    /**
     * Namme of all options 
     */
    private static $setting = [ 'apis_plugin', 'color_scheme', 'strava' ];
    
    /**
     * Get the option setting
     * @param string name of options
     * 
     * @return string|array value options
     */
    public static function get_option( $name ) {
        foreach( self::get_setting() as $key => $value ) {
            if( $key == trim( $name ) ) {
                return $value;
                break;
            }
        }
        return;
    }

    /**
     * Function echo the option setting
     */
    public function print_option( $name ) {
        echo get_option( $name );
    }

    /**
     * Get all options of the setting
     * 
     * @return array value options 
     */
    public static function get_setting() {
        $options = [];
        foreach( self::$setting as $value ){
            if( is_array( get_option($value) ) ){
                $option = get_option($value);
                foreach( $option as $key => $value ){
                    $options[$key] = $value;
                }
            }
        }
        return $options;
    }
}
