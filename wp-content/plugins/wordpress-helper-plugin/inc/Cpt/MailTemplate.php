<?php 
/**
 * @package APIs plugin
 */

namespace Inc\Cpt;

class MailTemplate {
    public $post_type;

    public function register() {
        $this->post_type = 'apis_mail_template';
    
        add_action('init', [ $this, 'register_post_type' ]);
    }

    function register_post_type() {
        $args = array(
            'labels' => array(
                        'name' 					=> esc_html_x('Mail templates', 'post type general name','apis'),
                        'singular_name' 		=> esc_html_x('Mail templates', 'post type singular name','apis'),
                        'all_items' 			=> esc_html__('All Mail templates', 'apis'),
                        'add_new' 				=> esc_html_x('Add Mail template', 'Team','apis'),
                        'add_new_item' 			=> esc_html__('Add Mail template','apis'),
                        'edit_item' 			=> esc_html__('Edit Mail template','apis'),
                        'new_item' 				=> esc_html__('New Mail template','apis'),
                        'view_item' 			=> esc_html__('View Mail template','apis'),
                        'search_items' 			=> esc_html__('Search Mail template','apis'),
                        'not_found' 			=> esc_html__('No Mail template found','apis'),
                        'not_found_in_trash' 	=> esc_html__('No Mail template found in Trash','apis'),
                        'parent_item_colon' 	=> '',
                        'menu_name' 			=> esc_html__('Mail templates','apis'),
            )
            ,'singular_label' 		=> esc_html__('Mail templates','apis')
            ,'public' 				=> true
            ,'publicly_queryable' 	=> true
            ,'show_ui' 				=> true
            ,'show_in_menu' 		=> true
            ,'capability_type' 		=> 'post'
            ,'hierarchical' 		=> false
            ,'supports'  			=> array('title', 'custom-fields', 'editor', 'thumbnail')
            ,'has_archive' 			=> false
            ,'rewrite' 				=> array('slug' => str_replace('ts_', '', $this->post_type), 'with_front' => true)
            ,'query_var' 			=> false
            ,'can_export' 			=> true
            ,'show_in_nav_menus' 	=> false
            ,'menu_position' 		=> 5
            ,'menu_icon' 			=> 'dashicons-email-alt'
        );

        register_post_type($this->post_type, $args);	
    }
}
