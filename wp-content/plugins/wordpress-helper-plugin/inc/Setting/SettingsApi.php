<?php 

/**
 * @package APIs plugin
 */

namespace Inc\Setting; 

class SettingsApi {
    public $admin_pages         = [];
    public $admin_subpages      = [];
    
    public $settings            = []; 
    public $sections            = []; 
    public $fields              = [];

    public function register() {
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_action( 'admin_init', [ $this, 'registerCustomFields' ] );
    }

    /**
     * Add the admin pages
     * 
     * @param array pages to add 
     * @return object
     */
    public function addPages( array $pages ) {
        $this->admin_pages = $pages;

        return $this;
    }

    /**
     * Set the first subpage admin
     * 
     * @param string title menu page
     * @return object
     */
    public function withSubpage( string $title = null ) {
        if ( empty( $this->admin_pages ) ) {
            return $this;    
        }

        $admin_page = $this->admin_pages[0];

        $subpage = [
            [
                'parent_slug'   =>  $admin_page['menu_slug'],
                'page_title'    =>  $admin_page['page_title'],
                'menu_title'    =>  ($title) ? $title : $admin_page['menu_title'], 
                'capability'    =>  $admin_page['capability'],
                'menu_slug'     =>  $admin_page['menu_slug'],
                'callback'      =>  $admin_page['callback']
            ]
        ];

        $this->admin_subpages = $subpage;

        return $this;
    }

    /**
     * Add more sub pages
     * 
     * @param array sub page to add
     * @return object
     */
    public function addSubPages( array $pages ) {
        $this->admin_subpages = array_merge( $this->admin_subpages, $pages );

        return $this;
    }

    /**
     * Loop through the functions to add menu page
     */
    public function add_admin_menu() {
        foreach ( $this->admin_pages as $page ) {
            add_menu_page( 
                $page['page_title'], 
                $page['menu_title'], 
                $page['capability'], 
                $page['menu_slug'], 
                $page['callback'], 
                $page['icon_url'], 
                $page['position'] );
        }

        foreach ( $this->admin_subpages as $page ) {
            add_submenu_page( 
                $page['parent_slug'], 
                $page['page_title'], 
                $page['menu_title'], 
                $page['capability'], 
                $page['menu_slug'], 
                $page['callback'] );
        }
    }

    /**
     * Set settings 
     * 
     * @param array settings to loop
     * @return object
     */
    public function setSettings( array $settings ) {
        $this->settings = $settings;
        
        return $this;
    }

    /**
     * Set sections 
     * 
     * @param array sections to loop
     * @return object
     */
    public function setSections( array $sections ) {
        $this->sections = $sections;

        return $this;
    }

    /**
     * Set fields
     * 
     * @param array fields to loop
     * @return object
     */
    public function setFields( array $fields ) {
        $this->fields = $fields;
        
        return $this;
    }

    /**
     * Iterate through the properties to create fields
     */
    public function registerCustomFields() {
        // register setting
        foreach ( $this->settings as $setting ) {
            register_setting( 
                $setting["option_group"], 
                $setting["option_name"],  
                isset( $setting["callback"] ) ? $setting["callback"] : ''
            );
        }
        // add section 
        foreach ( $this->sections as $section ) {
            add_settings_section( 
                $section["id"],
                $section["title"],
                $section["callback"],
                $section["page"]
            );
        }
        // add field
        foreach ( $this->fields as $field ) {
            add_settings_field(
                $field["id"],
                $field["title"],
                $field["callback"],
                $field["page"],
                $field["section"],
                $field["args"]
            );
        }
    }
}