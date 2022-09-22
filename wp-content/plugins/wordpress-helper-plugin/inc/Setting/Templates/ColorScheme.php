<?php 
    /**
     * @package APIs plugin
     * 
     * Option namne: color_scheme
     * Slug page: color_scheme_apis_plugin
     */

    use Inc\Base\DynamicStyle;
    use Inc\Base\Service;

    $dynamicstyle = new DynamicStyle; 
    $slug = 'color_scheme_apis_plugin';
?>

<div class="wrap">
	<h1>Color Scheme</h1>
    <?php
        if ( isset($_GET['page']) && $_GET['page'] == 'color_scheme_apis_plugin' && isset($_GET['settings-updated']) && $_GET['settings-updated'] ) {
            if ( $dynamicstyle->update_dynamic_style() ) {
                // wp_safe_redirect() does not exit automatically, and should almost always be followed by a call to exit;:
                wp_safe_redirect( Service::menu_page_url( $slug, [ 'message' => 'success' ]) );
                exit();
            } else {
                wp_safe_redirect( Service::menu_page_url( $slug, [ 'message' => 'success' ]) );
                exit();
            }
        }

        if ( isset( $_GET['message'] ) ) {
            Service::admin_notice( $_GET['message'] );
        }
    ?>
    <form method="post" action="options.php">
        <?php 
        settings_fields( 'color_scheme_settings' );
        do_settings_sections( 'color_scheme_apis_plugin' );
        submit_button();
        ?>
    </form>
</div>
