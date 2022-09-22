<?php 

/**
 * @package APIs plugin
 * * Using class default: apis-field-group, apis-select-multiple
 */
namespace Inc\Setting\Pages;

use Inc\Setting\SettingsApi;
use Inc\Setting\Callbacks\AdminCallbacks;
use Inc\Setting\Callbacks\FieldCallbacks;
use Inc\Base\Usage;

class AdminPage {
    private $ids = [];

    private $page_name  = 'Dashboard';
    public $pages = [];
    public $sub_pages = [];

    // More properties here ! must be updated later
    // Options group
    private $apis_plugin_settings   = 'apis_plugin_settings';
    private $color_scheme_settings  = 'color_scheme_settings';
    private $strava_settings        = 'strava_settings';

    // Slug/ page name
    private $apis_plugin_slug       = '';
    private $color_scheme_slug      = '';
    private $strava_slug            = 'strava_apis_plugin';

    /**
     * Initialize for AdminPage class, it will run as __construct
     */
    public function register() {
        $this->settings  = new SettingsApi();
        $this->fields    = new FieldCallbacks();

        $this->setPages();
        $this->setSubPages();

        $this->setSettings();
		$this->setSections();
		$this->setFields();

        $this->settings->addPages( $this->pages )->withSubpage( $this->page_name )->addSubPages( $this->sub_pages )->register();

        // echo "<pre style='color: red; margin-left: 300px'>";
        // print_r( $this->fixed_something_wrong() );
        // echo "</pre>";
    }
    
    /**
     * Set pages for SettingsApi properties class.
     */
    public function setPages() {
        $this->pages = [
            [
                'page_title'    => 'Apis Theme Options',
                'menu_title'    => 'Apis',
                'capability'    => 'manage_options',
                'menu_slug'     => 'apis_plugin',
                'callback'      => [ $this, 'adminDashboard' ],
                'icon_url'      => 'dashicons-hammer',
                'position'      => 110
            ]
        ];
    }

    /**
     * Set subpages for SettingsApi properties class.
     */
    public function setSubPages() {
        $this->sub_pages = [
            [
                'parent_slug'   =>  'apis_plugin',
                'page_title'    =>  'Color Scheme',
                'menu_title'    =>  'Color Scheme', 
                'capability'    =>  'manage_options',
                'menu_slug'     =>  'color_scheme_apis_plugin',
                'callback'      =>  [ $this, 'colorScheme' ]
            ],
            [
                'parent_slug'   => 'apis_plugin',
                'page_title'    => 'Posts Option',
                'menu_title'    => 'Posts (Example Menu)',
                'capability'    => 'manage_options',
                'menu_slug'     => 'post_apis_plugin',
                'callback'      => [ $this, 'adminPost' ]
            ], 
            [
                'parent_slug'   => 'apis_plugin',
                'page_title'    => 'Single Posts Option',
                'menu_title'    => 'Single Posts (Example Menu)', 
                'capability'    => 'manage_options',
                'menu_slug'     => 'single_post_apis_plugin',
                'callback'      => [ $this, 'adminSinglePost' ]
            ],
            [
                'parent_slug'   => 'apis_plugin',
                'page_title'    => 'Footer Option',
                'menu_title'    => 'Footer (Example Menu)', 
                'capability'    => 'manage_options',
                'menu_slug'     => 'footer_apis_plugin',
                'callback'      => [ $this, 'adminFooter' ]
            ],
            [
                'parent_slug'   => 'apis_plugin',
                'page_title'    => 'Custom Code',
                'menu_title'    => 'Custom Code (Example Menu)', 
                'capability'    => 'manage_options',
                'menu_slug'     => 'custom_code_apis_plugin',
                'callback'      => [ $this, 'adminCustomCode' ]
            ],
            [
                'parent_slug'   => 'apis_plugin',
                'page_title'    => 'Strava Settings',
                'menu_title'    => 'Strava',
                'capability'    => 'manage_options',
                'menu_slug'     => $this->strava_slug,
                'callback'      =>  [ $this, 'adminStrava' ]
            ]
        ];  
    }

    /**
     * Set settings for SettingsApi properties class.
     */
    public function setSettings() {
        $args = [
            [
                'option_group'  => $this->apis_plugin_settings,
                'option_name'   => 'apis_plugin',
            ],
            [
                'option_group'  => $this->color_scheme_settings,
                'option_name'   => 'color_scheme',
            ],
            [
                'option_group'  => $this->strava_settings,
                'option_name'   => 'strava',
                'callback'      => [ $this->fields, 'fieldsStravaSanitize' ]
            ]
        ];

        $this->settings->setSettings( $args );
    }

    /**
     * Set sections for SettingsApi properties classs.
     */
    public function setSections() { 
        $args = [
            [
                'id'        => 'apis_admin_section',
                'title'     => 'Setting manager example fields',
                'callback'  => [ $this->fields, 'adminSectionManager' ],
                'page'      => 'apis_plugin'
            ],
            [
                'id'        => 'color_scheme_section',
                'title'     => 'Color scheme example colors',
                'callback'  => [ $this->fields, 'colorSchemeManager' ],
                'page'      => 'color_scheme_apis_plugin'
            ],
            [
                'id'        => 'strava_section',
                'title'     => 'Strava API',
                'callback'  => [ $this->fields, 'stravaSectionManager' ],
                'page'      => $this->strava_slug 
            ]
        ];

        $this->settings->setSections( $args );
    }

    /**
     * Set fields for SettingsApi properties class.
     */
    public function setFields() {
        $ids = $this->get_ids();

        $args = [
            /**
             * Fields for apis_admin_section section
             * ! Section's arg must be same the options_name setting to group into array
            **/ 
            [
                'id'       => 'checkbox_field_id',
                'title'    => 'Check box example',
                'callback' => [ $this->fields, 'checkboxField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'checkbox_field_id',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                    'label'   => 'Label of this checkbox'
                ]
            ],
            [
                'id'       => 'checkbox_field_id_2',
                'title'    => 'Check box example 2',
                'callback' => [ $this->fields, 'checkboxField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'checkbox_field_id_2',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin'
                ]
            ],
            [
                'id'       => 'radio_field_id',
                'title'    => 'Radio checkbox example',
                'callback' => [ $this->fields, 'radioField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'radio_field_id',
                    'section' => 'apis_plugin',
                    'class'   => 'apis-field-group',
                    'option'  => [
                        'choice-1' => 'Choice 1',
                        'choice-2' => 'Choice 2',
                        'choice-3' => 'Choice 3'
                    ]
                ]
            ],
            [
                'id'       => 'radio_field_id_2',
                'title'    => 'Radio checkbox example',
                'callback' => [ $this->fields, 'radioField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'radio_field_id_2',
                    'section' => 'apis_plugin',
                    'class'   => 'apis-field-group',
                    'option'  => [
                        'choice-1' => 'Choice 1',
                        'choice-2' => 'Choice 2',
                        'choice-3' => 'Choice 3'
                    ]
                ]
            ],
            [
                'id'       => 'text_field_id',
                'title'    => 'Input example',
                'callback' => [ $this->fields, 'inputField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'text_field_id',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                ]
            ],
            [
                'id'       => 'text_field_id_2',
                'title'    => 'Input example 2',
                'callback' => [ $this->fields, 'inputField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'text_field_id_2',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin'
                ]
            ],
            [
                'id'       => 'text_field_id_3',
                'title'    => 'Input example 3',
                'callback' => [ $this->fields, 'inputField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'text_field_id_3',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin'
                    
                ]
            ],
            [
                'id'       => 'textarea_field_id',
                'title'    => 'Textarea example',
                'callback' => [ $this->fields, 'textareaField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'textarea_field_id',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                ]
            ],
            [
                'id'       => 'textarea_field_id_2',
                'title'    => 'Textarea example 2',
                'callback' => [ $this->fields, 'textareaField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'textarea_field_id_2',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                ]
            ],
            [
                'id'       => 'select_field_id',
                'title'    => 'Select example',
                'callback' => [ $this->fields, 'selectField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'select_field_id',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                    'option'  => [
                        'default' => 'Default',
                        'value-1' => 'Value example 1',
                        'value-2' => 'Value example 2',
                        'value-3' => 'Value example 3',
                    ]
                ]
            ],
            [
                'id'       => 'select_field_id_2',
                'title'    => 'Select example 2',
                'callback' => [ $this->fields, 'selectField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'select_field_id_2',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                    'option'  => [
                        'default' => 'Default',
                        'value-1' => 'Value example 1',
                        'value-2' => 'Value example 2',
                        'value-3' => 'Value example 3',
                    ]
                ]
            ],
            [
                'id'        => 'select2_field_id_1',
                'title'     => 'Select 2 example',
                'callback'  => [ $this->fields, 'select2Field' ],
                'page'      => 'apis_plugin',
                'section'   => 'apis_admin_section',
                'args'      => [
                    'name'      => 'select2_field_id',
                    'class'     => 'apis-field-group apis-select-multiple',
                    'section'   => 'apis_plugin',
                    'option'    => [
                        'default'   => 'Default',
                        'value-1'   => 'Value example 1',
                        'value-2'   => 'Value example 2',
                        'value-3'   => 'Value example 3',
                    ]
                ]
            ],
            [
                'id'        => 'select2_field_id_2',
                'title'     => 'Select 2 example 2',
                'callback'  => [ $this->fields, 'select2Field' ],
                'page'      => 'apis_plugin',
                'section'   => 'apis_admin_section',
                'args'      => [
                    'name'      => 'select2_field_id_2',
                    'class'     => 'apis-field-group apis-select-multiple',
                    'section'   => 'apis_plugin',
                    'option'    => [
                        'default'   => 'Default',
                        'value-1'   => 'Value example 1',
                        'value-2'   => 'Value example 2',
                        'value-3'   => 'Value example 3',
                    ]
                ]
            ],
            [
                'id'       => 'number_field_id',
                'title'    => 'Number example',
                'callback' => [ $this->fields, 'numberField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'number_field_id',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                    'label'   => 'Min: 5, max: 10',
                    'min'     => 5,
                    'max'     => 10
                ]
            ],
            [
                'id'       => 'number_field_id_2',
                'title'    => 'Number example 2',
                'callback' => [ $this->fields, 'numberField'],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'number_field_id_2',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                    'min'     => 5,
                    'max'     => 100
                ]
            ],
            [
                'id'       => 'range_field_id',
                'title'    => 'Range example',
                'callback' => [ $this->fields, 'rangeField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'range_field_id',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                    'min'     => 5,
                    'max'     => 100,
                ]
            ],
            [
                'id'       => 'range_field_id_2',
                'title'    => 'Range example 2',
                'callback' => [ $this->fields, 'rangeField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'range_field_id_2',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                    'min'     => 0,
                    'max'     => 100,
                ]
            ],
            [
                'id'       => 'media_upload_id',
                'title'    => 'Media upload example',
                'callback' => [ $this->fields, 'mediaField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'media_upload_id',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin',
                ]
            ],
            [
                'id'       => 'media_upload_id_2',
                'title'    => 'Media upload example 2',
                'callback' => [ $this->fields, 'mediaField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'media_upload_id_2',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin'
                ]
            ],
            [
                'id'       => 'media_upload_id_3',
                'title'    => 'Media upload example 3',
                'callback' => [ $this->fields, 'mediaField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'    => 'media_upload_id_3',
                    'class'   => 'apis-field-group',
                    'section' => 'apis_plugin'
                ]
            ],
            [
                'id'       => 'color_picker_id',
                'title'    => 'Color picker example',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'      => 'color_picker_id',
                    'class'     => 'apis-field-group',
                    'section'   => 'apis_plugin'
                ]
            ],
            [
                'id'       => 'color_picker_id_2',
                'title'    => 'Color picker example',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'apis_plugin',
                'section'  => 'apis_admin_section',
                'args'     => [
                    'name'      => 'color_picker_id_2',
                    'class'     => 'apis-field-group',
                    'section'   => 'apis_plugin'
                ]
            ],
        /**
         * End Fields for apis_admin_section section 
        **/
        /**
         * Fields for color_scheme_section section
         * ! Section's arg must be same the options_name setting to group into array
        **/ 
            [
                'id'       => 'color_primary',
                'title'    => 'Primary Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_primary',
                    'class'     => 'apis-field-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_text',
                'title'    => 'Text Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_text',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_text_bold',
                'title'    => 'Text Color Bold',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_text_bold',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_text_italic',
                'title'    => 'Text Color Italic',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_text_italic',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_heading_1',
                'title'    => 'Heading 1 Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_heading_1',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_heading_2',
                'title'    => 'Heading 2 Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_heading_2',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_heading_3',
                'title'    => 'Heading 3 Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_heading_3',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_heading_4',
                'title'    => 'Heading 4 Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_heading_4',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_heading_5',
                'title'    => 'Heading 5 Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_heading_5',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_link',
                'title'    => 'Link Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_link',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_link_hover',
                'title'    => 'Link Color Hover',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_link_hover',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_input_text',
                'title'    => 'Input Text Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_input_text',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_input_background',
                'title'    => 'Input Background Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_input_background',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
            [
                'id'       => 'color_input_border',
                'title'    => 'Input Border Color',
                'callback' => [ $this->fields, 'colorField' ],
                'page'     => 'color_scheme_apis_plugin',
                'section'  => 'color_scheme_section',
                'args'     => [
                    'name'      => 'color_input_border',
                    'class'     => 'apis-fields-group',
                    'section'   => 'color_scheme'
                ]
            ],
        /**
         * End Fields for color_scheme_section section
        **/
        /**
         * Fields for strava_section section
         * ! Section's arg must be same the options_name setting to group into array
        **/ 
            [
                'id'       => 'strava_client_id',
                'title'    => 'Strava Client ID',
                'callback' => [ $this->fields, 'inputField' ],
                'page'     => $this->strava_slug,
                'section'  => 'strava_section',
                'args'     => [
                    'name'      => 'strava_client_id',
                    'class'     => 'apis-fields-group',
                    'section'   => 'strava'
                ]
            ],
            [
                'id'       => 'strava_client_secret',
                'title'    => 'Strava Client Secret',
                'callback' => [ $this->fields, 'inputField' ],
                'page'     => $this->strava_slug,
                'section'  => 'strava_section',
                'args'     => [
                    'name'      => 'strava_client_secret',
                    'class'     => 'apis-fields-group',
                    'section'   => 'strava'
                ]
            ],
            [
                'id'       => 'strava_nickname',
                'title'    => 'Strava Nickname',
                'callback' => [ $this->fields, 'inputField' ],
                'page'     => $this->strava_slug,
                'section'  => 'strava_section',
                'args'     => [
                    'name'      => 'strava_nickname',
                    'class'     => 'apis-fields-group',
                    'section'   => 'strava'
                ]
            ]   
        /**
         * End Fields for strava_section section
        **/
        ];

        if ( ! $this->ids_empty( $ids ) ) {
            $args[] = [
                'id'            => 'strava_id',
                'title'         => 'Saved ID',
                'callback'      => [ $this->fields, 'inputField' ],
                'page'          => $this->strava_slug,
                'section'       => 'strava_section',
                'args'          => [
                    'name'          => 'strava_id',
                    'class'         => 'apis-fields-group',
                    'section'       => 'strava'
                ]
            ];
        }

        $this->settings->setFields( $args );
    }

    /**
     * Print the admin dashboard page container.
     */
    public function adminDashboard() {
        return require_once( APIS_PATH . 'inc' . APIS_DS . 'Setting' . APIS_DS . 'Templates' . APIS_DS . 'Dashboard.php' );
    }

    /**
     * Print the color scheme page container.
     */
    public function colorScheme() {
        return require_once( APIS_PATH . 'inc' . APIS_DS . 'Setting' . APIS_DS . 'Templates' . APIS_DS . 'ColorScheme.php' );
    }

    /**
     * Print the admin strava page container.
     */
    public function adminStrava(){
        return require_once( APIS_PATH . 'inc' . APIS_DS . 'Setting' . APIS_DS . 'Templates' . APIS_DS . 'Strava.php' );
    }

    /**
     * Print the admin post page container.
     */
    public function adminPost() {
        echo 'Admin Post';
    }

    /**
     * Print the admin single post page container.
     */
    public function adminSinglePost() {
        echo 'Admin Single Post';
    }

    /**
     * Print the admin footer page container.
     */
    public function adminFooter() {
        echo 'Admin Footer';
    }

    /**
     * Print the admin custom code page container.
     */
    public function adminCustomCode() {
        echo 'Admin Custom Code';
    }

    /**
     * Check to see if settings have been updated.
     * 
     * @param array $value Data array from pre_set_transient_settings_errors filter.
     * @return boolean
     */
    public function is_settings_updated( $value ) {
        return ( isset( $value[0]['type'] ) && ( 'updated' === $value[0]['type'] || 'success' === $value[0]['type'] ) );
    }

    /**
     * Whether or not we're on the options page
     * 
     * @return boolean
     */
    public function  is_strava_options_page () {
        return filter_input( INPUT_POST, 'option_page', FILTER_SANITIZE_STRING ) === $this->strava_settings;
    }
    
    /**
     * Whether or not we're on the Strava settings page.
     * 
     * @return boolean     
     */
    public function is_strava_settings_page() {
        return filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING ) === $this->strava_slug;
    }

    /**
     * Get Strava page settings name.
     * 
     * @return string 
     */
    public function get_strava_page_name() {
        return $this->strava_slug;
    }

    /**
     * Gets all saved strava ids as an array.
     * 
     * @return array
     */
    public function get_ids() {
        if ( $this->ids ) {
            return $this->ids;
        }

        $ids = $this->get_option( 'strava', 'id', true );

        if ( ! is_array( $ids ) ) {
            $ids = [ $ids ];
        }

        foreach ( $ids as $index => $id ) {
            if ( empty( $id ) ) {
                unset( $ids[ $index ] );
            }
        }

        // Rebase array keys after unset @see https://stackoverflow.com/a/5943165/2146022
        $this->ids = array_values( $ids );
        return $this->ids;
    }

    /**
     * Checks for valid IDS.
     * 
     * @param string|array Single ID or array of IDs.
     * @return boolean True if empty.
     */
    public function ids_empty( $ids ) {
        if ( empty( $ids ) ) {
            return true;
        }

        if ( is_array( $ids ) ) {
            foreach ( $ids as $id ) {
                if ( ! empty( $id ) ) {
                    return false;
                } 
            }
        }

        return true;
    }

    /**
     * Add add id if it's not already there, and save to the DB.
     * 
     * @param string $id
     */
    public function add_id( $id ) {
        $this->get_ids();

        if ( false === array_search( $id, $this->ids, true ) ) {
            $this->ids[] = $id;

            $this->update_option( 'strava', 'id', $this->ids, true );
        }
    }

    /**
     * Update options with new CLient ID and Info.
     * 
     * @param int $id Strava API Client ID
     * @param string $secret Stra API Client Secret
     * @param stdClass $info
     */
    public function save_info( $id, $secret, $info ) {
        $infos = $this->get_option( 'strava', 'info' );
        $infos = unserialize( $infos );
        $infos = empty( $infos ) ? array() : $infos;

        // array_walk( $infos, [ $this, 'filter_by_id' ] );
        $infos = array_filter( $infos );
        
        $info->client_secret = $secret;
        $infos[ $id ]        = $info;
        
        $this->update_option( 'strava', 'info', $infos, true );
    }

    /**
     * array_walk() callback to clear IDs we no longer want.
     * 
     * @param int $key Strava Client ID.
     */
    // public function filter_by_id( &$value, $key ) {
    //     $ids = $this->get_ids();
    //     if ( in_array( $key, $ids ) ) {
    //         return;
    //     }

    //     $value = null;
    // }

    /**
     * Getter for Strava settings of wp_options.
     * 
     * @param string $name Option name without the 'strava_' prefix.
     * @return mixed
     */
    public function __get( $name ) {
        if( !strpos('strava_', $name) ) {
            $name = "strava_{$name}";
            $option = get_option('strava');

            if( array_key_exists( $name, $option ) ) {
                return get_option('strava')[$name];
            }
        }

        return;
    }

    /**
     * Because the page option returned an array, we must get the option again and add new key value pair for it.
     * 
     * @param string $name Section name of the options.
     * @param string $key New key wanna add without the 'strava_' prefix, check the section in function setFields for more detail.
     * @param string $value New value wanna add.
     * 
     * @return boolean true if updated. 
     */
    private function update_option( $name, $key, $value, $serialize = false ) {
        if ( !strpos('strava_', $key ) ) {
            $key = "strava_{$key}";
            $option = get_option($name);

            if ( $option ) {
                if ( $serialize && is_array( $value ) ) {
                    $option[$key] = serialize( $value );
                } else {
                    $option[$key] = $value;
                }
               
                // update_option function returned true/false @see https://developer.wordpress.org/reference/functions/update_option/
                return update_option( 'strava', $option );
            }
        }
        return false;
    }

    /**
     * Because the page option returned an array, we need the key to find exactly the value option.
     * 
     * @param string $name Section name of the options.
     * @param string $key New key wanna get without the 'strava_' prefix.
     * 
     * @return mixed
     */
    private function get_option( $name, $key, $unserialize = false ) {
        if ( !strpos('strava_', $key ) ) {  
            $key = "strava_{$key}";
            $option = get_option($name);

            if ( $option && array_key_exists( $key, $option ) ) {
                if ( $unserialize ) {
                    return unserialize( get_option($name)[$key] );
                } else {
                    return get_option($name)[$key];
                }
            }
        }

        return;
    }

    /**
     * Remove the client ID and Secret (they're saved in the strava option).
     * 
     * @return boolean true if deleted
     */
    public function delete_id_secret() {
        $option = get_option( 'strava' );

        // ! Example for debugging
        // Usage::write_log( 'Removing ...' . $option['strava_client_id'] . ' - ' . $option['strava_client_secret'] );

        if ( $option && array_key_exists( 'strava_client_id', $option ) && array_key_exists( 'strava_client_secret', $option ) ) { 
            unset( $option['strava_client_id'] );
            unset( $option['strava_client_secret'] );

            // Usage::write_log( 'Removed' );
        } else {
            // Usage::write_log( 'Failed' );
        }

        return update_option( 'strava', $option );
    }

    // ! not using in future
    public function fixed_something_wrong() {
        $option = get_option('strava');

        if ( $option ) {
            $option['strava_id'] = '';

            return update_option('strava', $option);
        }
        return false;
    }
}