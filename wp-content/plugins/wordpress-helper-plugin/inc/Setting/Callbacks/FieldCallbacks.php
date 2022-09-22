<?php 

/**
 * @package APIs plugin
 */

namespace Inc\Setting\Callbacks;

use Inc\Init;

class FieldCallbacks {

    // public function checkboxSanitize( $input ) {
    //     $output = array();

	// 	foreach ( $this->managers as $key => $value ) {
	// 		$output[$key] = isset( $input[$key] ) ? true : false;
	// 	}

	// 	return $output;
    // }

    /**
     * Sections callback display text
     */
    public function adminSectionManager() {
        echo 'This is example section of admin settings api. Good luck and have fun';
    }
  
    public function colorSchemeManager() {
        echo 'This is example section of color scheme settings';
    }

    public function stravaSectionManager() {
        echo 'This is example section of strava settings';
    }

    /**
     * Sanitize the data Strava
     * 
     * @param array $data fields
     * @return array
     */
    public function fieldsStravaSanitize( $data ){
        $settings = Init::get_instance()->settings;

        // echo "<pre style='color: red'>";
        // print_r( $this );
        // echo "</pre>";

        // !
        // die( print_r( $settings->get_ids() ) );

        // if ( array_key_exists( 'strava_id', $data ) ) {
        // }

        if ( array_key_exists( 'strava_client_id', $data ) && !is_numeric( $data['strava_client_id'] ) ) { 
            add_settings_error( 'strava[strava_client_id]', 'strava_client_id', 'Client ID must be a number.' );
        }

        if ( array_key_exists( 'strava_client_secret', $data ) && '' === trim( $data['strava_client_secret'] ) ) {
            add_settings_error( 'strava[strava_client_secret]', 'strava_client_secret', 'Client Secret is required.' );
        }

        if ( array_key_exists( 'strava_client_secret', $data ) && '' === trim( $data['strava_nickname'] ) ) {
            add_settings_error( 'strava[strava_nickname]', 'strava_nickname', 'Nickname is required' );
        }

        return $data;
    }

    /**
     * Callback of setting fields to generate checkbox field
     * 
     * @param array arguments of name, class, section, label of setting fields
     * 
     * @return checkbox
     */
    public function checkboxField( $args ) {
		$name        = $args['name'];
		$classes     = $args['class'];
		$option_name = $args['section'];
        $label       = isset( $args['label'] ) ? $args['label'] : '';

		$checkbox = get_option( $option_name );
		$checked  = isset( $checkbox[$name] ) ? true : false;
        ?>
            <div class="<?php echo esc_attr( $classes ); ?>">
                <label>
                    <input name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" type="checkbox" id="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $checked ) ?> >
                    <?php if( $label ) { ?>
                    <span> <?php echo esc_html( $label ); ?> </span>
                    <?php } ?>
                </label>
            </div>
        <?php
	}

     /**
     * Callback of setting fields to generate radio field
     * 
     * @param array arguments of name, class, section, option of setting fields
     * 
     * @return radio
     */
    public function radioField( $args ) {
        $name        = $args['name'];
        $classes     = $args['class'];
        $option_name = $args['section'];
        $options     = $args['option'];

        $radio = get_option( $option_name );
        $value = isset( $radio[$name] ) ? $radio[$name] : '';
        ?>
            <div class="<?php echo esc_attr( $classes ); ?>">
                <fieldset>
                <?php foreach( $options as $key => $val ) { ?>
                    <label>
                        <input <?php checked($key, $value) ?> type="radio" id="<?php echo esc_attr( "{$option_name}[{$key}]" ); ?>" name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" value="<?php echo esc_attr( $key ); ?>">
                        <span> <?php echo esc_html( $val ); ?></span>
                    </label> <br>
                <?php } ?>
                </fieldset>
            </div>
        <?php
    }

    /**
     * Callback of setting fields to generate checkbox field
     * 
     * @param array name, class, section arguments of setting fields
     * 
     * @return checkbox
     */
    public function inputField( $args ) {
        $name        = $args['name'];
        $class       = $args['class'];
        $option_name = $args['section'];

        $input = get_option( $option_name );

        $value = isset( $input[$name] ) ? $input[$name] : '';
        ?>
        <div class="<?php echo esc_attr( $class ); ?>">
            <input class="regular-text" type="text" name="<?php echo esc_attr("{$option_name}[{$name}]"); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" />
        </div>
        <?php
    }

    /**
     * Callback of setting fields to generate textarea field
     * 
     * @param array arguments of name, class, section of setting fields
     * 
     * @return textarea
     */
    public function textAreaField( $args ) {
        $allowed_html = array( 'br' => array(), 'p' => array(), 'strong' => array() );
        $name         = $args['name'];
        $classes      = $args['class'];
        $option_name  = $args['section'];
        
        $textarea = get_option( $option_name );
        $value    = isset( $textarea[$name] ) ? $textarea[$name] : '';
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <textarea class="large-text code" name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" id="<?php echo esc_attr( $name ); ?>" cols="30" rows="5"><?php echo wp_kses( $value, $allowed_html ); ?></textarea>
        </div>
        <?php
    }

    /**
     * Callback of setting fields to generate select field
     * 
     * @param array arguments of name, class, section, option of setting fields
     * 
     * @return select
     */
    public function selectField( $args ) {
        $name        = $args['name'];
        $classes     = $args['class'];
        $option_name = $args['section'];
        $options     = $args['option'];

        $select = get_option( $option_name );
        $value = isset( $select[$name] ) ? $select[$name] : '';
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <select name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" id="<?php echo esc_attr( $name ); ?>">
                <?php foreach( $options as $key => $val) { ?>
                <option <?php selected( $key, $value ) ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $val ); ?></option>
                <?php } ?>
            </select>
        </div>
        <?php
    }

    /**
     * Callback of setting fields to generate select2 field
     * 
     * @param array arguments of name, class, section, option of setting fields
     * 
     * @return select
     */
    public function select2Field( $args ){
        $selected       = '';
        $name           = $args['name'];
        $classes        = $args['class'];
        $option_name    = $args['section'];
        $options        = $args['option'];

        $select = get_option( $option_name );
        $value = isset( $select[$name] ) ? $select[$name] : '';
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <select name="<?php echo esc_attr( "{$option_name}[{$name}][]" ); ?>" id="<?php echo esc_attr( $name ); ?>" multiple="multiple">
                <?php foreach( $options as $key => $val ){ 
                    if( is_array( $value ) ){
                       $selected = in_array( trim($key), $value ) ? 'selected="selected"' : '';
                    }
                ?>
                <option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $val ); ?></option>
                <?php } ?>
            </select>
        </div>
        <?php
    }

    /**
     * Callback of setting fields to generate number field
     * 
     * @param array arguments of name, class, section, label, min, max of setting fields
     * 
     * @return range
     */
    public function numberField( $args ) {
        $name        = $args['name'];
        $classes     = $args['class'];
        $option_name = $args['section'];
        $label       = isset( $args['label'] ) ? $args['label'] : '';
        $min         = $args['min'];
        $max         = $args['max'];

        $number = get_option( $option_name );
        $value = isset( $number[$name] ) ? $number[$name] : '';
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <label>
                <input min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr($max); ?>" type="number" name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ) ?>">
                <?php if( $label ) { ?>
                    <span><?php echo esc_html( $label ); ?></span>
                <?php } ?>
            </label>
        </div>
        <?php
    }

    /**
     * Callback of setting fields to generate range field
     * 
     * @param array arguments of name, class, section, label, min, max of setting fields
     * 
     * @return range
     */
    public function rangeField( $args ) {
        $name        = $args['name'];
        $classes     = $args['class'];
        $option_name = $args['section'];
        $min         = $args['min'];
        $max         = $args['max'];

        $number = get_option( $option_name );
        $value = isset( $number[$name] ) ? $number[$name] : absint( ( $max+$min )/2 );
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <label style="display: flex">
                <input min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr($max); ?>" type="range" name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ) ?>" oninput="this.nextElementSibling.value = this.value">
                &nbsp;<output><?php echo esc_attr( $value ); ?></output>   
            </label>
        </div>
        <?php
    }

    /**
     * Callback of setting fields to generate media field
     * 
     * @return string url
     */
    public function mediaField( $args ) {
        $name        = $args['name'];
        $classes     = $args['class'];
        $option_name = $args['section'];

        $link = get_option( $option_name );
        $value = isset( $link[$name] ) ? $link[$name] : '';
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <input type="text" class="regular-text apis-input-upload" name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" value="<?php echo esc_attr( $value ); ?>" />
            <button type="button" class="button button-primary apis-button apis-button-upload" value="Upload Profile Picture" >
                <span class="dashicons-before dashicons-format-image apis-button-icon"></span><?php echo esc_html( 'Select Image', 'apis'); ?>
            </button>
            <button class="button button-secondary apis-button apis-button-clear">
                <?php echo esc_html('Clear Image', 'apis'); ?>
            </button>
            <?php
            if( $value ){
            ?>
                <img class="apis-preview-image" src="<?php echo esc_attr( $value ); ?>" />
            <?php 
            }
            ?>
        </div>
        <?php
    }

    /**
     * Callback of setting fields to generate color picker field
     * 
     * @return color
     */
    public function colorField( $args ){
        $name           = $args['name'];
        $classes        = $args['class'];
        $option_name    = $args['section'];

        $color = get_option( $option_name );
        $value = isset( $color[$name] ) ? $color[$name] : '';
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <input type="color" name="<?php echo esc_attr( "{$option_name}[{$name}]" ); ?>" value="<?php echo esc_attr( $value ); ?>">
        </div>
        <?php
    }

}
