<?php
/**
 * @package APIs plugin
 */

namespace Inc;

final class Dir {
    public function __construct() {
        self::class_name();
    }

    public static function autoload() {
        spl_autoload_register( function( $class_name ) {
            echo "<pre style='color: red, margin-left: 300px;' >";
            print_r( $class_name );
            echo "</pre>";
        });
    }

    public static function class_name() {
        echo "<pre style='color: red; margin-left: 250px'>";
        print_r( get_declared_classes() );
        echo "</pre>";
    }  
}