<?php 
/**
 * @package APIs plugin
 */

namespace Inc\Base;

use Inc\Base\SettingOptions;

class DynamicStyle {
    private $file_name, $file_name_dir;

    public function __construct() {
        $this->set_usage();
    }

    public function set_usage() {
        $this->file_name = strtolower(APIS_NAME) . '.css';
        $this->file_name_dir = trailingslashit(APIS_UPLOAD_DIR['basedir']) . $this->file_name;

        add_action( 'wp_enqueue_scripts', [ $this, 'register_dynamic_style' ], 9999 );
    }

    /**
     * Function to get options, if no value from the setting, the options will be setting default
     * 
     * @return options
     */
    public function get_options() {
        $options = new SettingOptions;
        $result = array();

        foreach( $this->default_values() as $key => $value ) {
            if ( array_key_exists( $key, $options->get_setting() ) ) {
                $result[$key] = $options->get_option( $key );
            } else {
                $result[$key] = $value; 
            }
        }

        return $result;
    }   

    public function default_values() {
        return [
            'color_primary'          => '#000000',
            'color_text'             => '#000000',
            'color_text_bold'        => '#000000',
            'color_text_italic'      => '#000000',
            'color_heading_1'        => '#000000',
            'color_heading_2'        => '#000000',
            'color_heading_3'        => '#000000',
            'color_heading_4'        => '#000000',
            'color_heading_5'        => '#000000',
            'color_link'             => '#000000',
            'color_link_hover'       => '#000000',
            'color_input_text'       => '#000000',
            'color_input_background' => '#000000',
            'color_input_border'     => '#000000'
        ];
    }

    /**
     * Update dynamic style 
     * 
     * @return boolean
     */
    public function update_dynamic_style() {
        global $wp_filesystem;
        $result = false;

        ob_start();
        $this->dynamic_style();
        $dynamic_css = ob_get_clean();
        ob_end_clean();

        if( empty( $wp_filesystem ) ){
            require_once ABSPATH .'/wp-admin/includes/file.php';
			WP_Filesystem();
        }

        $creds = request_filesystem_credentials($this->file_name_dir, '', false, false, array());
		if( !WP_Filesystem($creds) ){
			return false;
		}

		if( $wp_filesystem ) {
			$result = $wp_filesystem->put_contents(
				$this->file_name_dir,
				$dynamic_css,
				FS_CHMOD_FILE
			);
		}

        return $result;
    }

    /**
     * Register dynamic style
     */
    public function register_dynamic_style() {
        $upload_dir = wp_get_upload_dir();
        $plugin_name = strtolower(APIS_NAME);
        $filename = trailingslashit($upload_dir['baseurl']) . $plugin_name . '.css';
        $filename_dir = trailingslashit($upload_dir['basedir']) . $plugin_name . '.css';

        if ( file_exists( $filename_dir ) ) {
            $css_version =  APIS_NAME . '.' . filemtime( $filename_dir );
            wp_enqueue_style( 'apis-dynamic-css', $filename, array(), $css_version );
        } else { 
            ob_start();
            $this->dynamic_style();
            $dynamic_css = ob_get_contents();
            ob_end_clean();
            wp_add_inline_style( 'apis-style', $dynamic_css );
        }
    }   

    public function dynamic_style(){
        extract( $this->get_options() );
    ?>
h1{
    color: <?php echo esc_html( $color_heading_1 ); ?>;
}
h2{
    color: <?php echo esc_html( $color_heading_2 ); ?>;
}

h3{
    color: <?php echo esc_html( $color_heading_3 ); ?>;
}

h4{
    color: <?php echo esc_html( $color_heading_4 ); ?>;
}

h5{
    color: <?php echo esc_html( $color_heading_5 ); ?>;
}
    <?php
    }
}