<?php 
/**
 * @package APIs plugin
 */

namespace Inc\Base;

class Enqueue {
    public function register() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        /**
         * Fires after block assets have been enqueued for the editing interface.
         * @see https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/  
         */ 
        add_action( 'enqueue_block_editor_assets', [ $this, 'register_blocks' ] );
    }

    /**
     * Register/enqueue admin scripts.
     */
    public function enqueue_scripts( $hook ) {
        global $config;

        wp_enqueue_media();

        wp_enqueue_script(
            'select2-style',
            APIS_URL . '/resource/select2/dist/js/select2.min.js',
            ['jquery'],
            APIS_VERSION
        );

        wp_enqueue_script(
            'wp-helper-script',
            APIS_URL . '/assets/js/apis.admin.script.js',
            ['jquery'],
            APIS_VERSION,
            true
        );

        wp_enqueue_style(
            'wp-helper-style',
            APIS_URL . '/assets/css/apis.admin.style.css',
            [],
            APIS_VERSION
        );

        wp_enqueue_style(
            'select2-script',
            APIS_URL . '/resource/select2/dist/css/select2.min.css',
            [],
            APIS_VERSION
        );
    }

    /**
     * Register basic blocks Gutenberg blocks.
     */
    public function register_blocks() {
        wp_enqueue_script( 
            'gutenberg-blocks', 
            APIS_URL . '/assets/js/blocks.example.js',
            [ 'wp-blocks', 'wp-i18n', 'wp-editor' ],
            APIS_VERSION,
            false 
        );
    }

}
