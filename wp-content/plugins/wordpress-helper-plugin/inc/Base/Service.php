<?php 

/**
 * @package APIs plugin
 */

namespace Inc\Base;

class Service {
    public static function menu_page_url( $menu_slug, $query = '' ) {
        $query = wp_parse_args( $query, [] );
        $url = menu_page_url( $menu_slug, false );        
        if( !empty( $query ) ){
            $url = add_query_arg( $query, $url );
        }
        return $url;
    }

    public static function admin_notice( $message = '' ) {
        if ( 'unauthorized' == $message ) {
            echo sprintf(
                '<div class="notice notice-error"><p><strong>%1$s</strong>: %2$s</p>
                    <button type="button" class="notice-dismiss apis-notice-dismiss">
                        <span class="screen-reader-text">Dismiss this notice.</span>
                    </button>
                </div>',
                esc_html( __( 'Error', 'apis' )  ),
                esc_html( __( 'You have not been authenticated. Make sure the provided API key is correct.'
                , 'apis' ) )
            );
        }

        if ( 'invalid' == $message ) {
            echo sprintf(
                '<div class="notice notice-error"><p><strong>%1$s</strong>: %2$s</p>
                    <button type="button" class="notice-dismiss apis-notice-dismiss">
                        <span class="screen-reader-text">Dismiss this notice.</span>
                    </button>
                </div>',
                esc_html( __( 'Error', 'apis' ) ),
                esc_html( __( 'Invalid key values', 'apis' ) )
            );
        }

        if ( 'success' == $message ) {
            echo sprintf(
                '<div class="notice notice-success settings-error is-dismissible">
                <p>%s</p>
                    <button type="button" class="notice-dismiss apis-notice-dismiss">
                        <span class="screen-reader-text">Dismiss this notice.</span>
                    </button>
                </div>',
                esc_html( __( 'Settings saved.', 'apis' ) )
            );
        }

        if ( 'error' == $message ) {
            echo sprintf(
                '<div class="notice notice-error"><p><strong>%1$s</strong>: %2$s</p>
                    <button type="button" class="notice-dismiss apis-notice-dismiss">
                        <span class="screen-reader-text">Dismiss this notice.</span>
                    </button>
                </div>',
                esc_html( __( 'Error', 'apis' ) ),
                esc_html( __( 'Settings weren\'t save', 'apis' ) )
            );
        }
    }
}