<?php 
/**
 * Blocks
 * 
 * @package Vincent
 */

namespace Vincent\Inc;

use Vincent\Inc\Traits\Singleton;

class Blocks {
    use Singleton;

    protected function __construct() {
        add_filter( 'block_categories_all', [ $this, 'register_block_categories' ], 10, 2 );
        add_action( 'init', [ $this, 'register_blocks' ] );
    }

    /**
     * Register Categories.
     * @link https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
     * @param block_categories Array of categories for block types.
     * @param block_editor_context The current block editor context. 
     * 
     * @return array Categories for block types.
     */
    public function register_block_categories( $block_categories, $editor_context ) {
        if ( ! empty( $editor_context->post ) ) {
            array_push(
                $block_categories,
                [
                    'slug'  => 'Header',
                    'title' => __( 'Header', 'vincent' ),
                    'icon'  => null
                ],
                [
                    'slug'  => 'Footer',
                    'title' => __( 'Footer', 'vincent' ),
                    'icon'  => null
                ],
                [
                    'slug'  => 'Main',
                    'title' => __( 'Main', 'vincent' ),
                    'icon'  => null
                ]
            );
        }

        return $block_categories;
    }

    /**
     * Register the block using the metadata loaded from the `block.json` file.
     * Behind the scenes, it registers also all assets so they can be enqueued
     * through the block editor iun the corresponding context.
     */
    public function register_blocks() {
        $blocks = [
            'block-one/'
            ,'block-two/'
            ,'block-three/'
            ,'block-four/'
            ,'block-five/'
            ,'block-six/'
        ];	
    
        foreach( $blocks as $block ){
            $file = get_theme_file_path( '/inc/blocks/' . $block );
    
            register_block_type( $file );
        }
    }

}
?>