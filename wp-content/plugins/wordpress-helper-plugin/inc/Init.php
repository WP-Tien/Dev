<?php 
/**
 * @package APIs plugin
 */

namespace Inc;
use Inc\Setting\Pages\AdminPage;
 
final class Init {

    /**
     * Setting object to access settings.
     * @var SettingsApi
     */
    public $settings = null;

    /**
     * Instance
     */
    private static $instance = null;

    /**
     * Store the global config
     */
    private static $config;

    /**
     * Start all codes
     */
    private function __construct() { 
        // Create constructor
        self::register_services();

        $this->settings = new AdminPage();
    }

    /**
     * Blocked __clone() method
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'apis' ), '1.0.0' );
    }

    /**
     * Blocked __wakeup() method
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'apis' ), '1.0.0' );
    }

    /**
     * Instance 
     * 
     * Ensures only one instance of the plugin class is loaded or can be loaded.
     */
    public static function get_instance() {
        if ( self::$instance === null ) {
            self::$instance = new Init();
        }

        return self::$instance;
    }    

    /**
     * Store all classes inside an array
     * @return array Full list of classes
     */
    public static function get_services() {
        return [
            Base\Setup::class,
            Base\Enqueue::class,
            Base\Service::class,
            Setting\SettingsApi::class,
            Setting\Pages\AdminPage::class,
            Base\SettingOptions::class,
            Base\DynamicStyle::class,
            Cpt\MailTemplate::class,
            // STRAVA
            Strava\AuthRefresh::class
        ];
    }

    /**
     * Loop through the classes, initialize them,
     * and call the register() method if it exists
     * @return
     */
    public static function register_services() {
        foreach ( self::get_services() as $class ) {
            $service = self::instantiate( $class );

            if ( method_exists( $service, 'register' ) ) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param class $class Class from the services array
     * @return class instance New instance of the class
     */
    private static function instantiate($class) {
        $service = new $class();

        return $service;
    }
}