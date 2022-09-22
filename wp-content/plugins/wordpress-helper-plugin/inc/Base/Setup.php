<?php

/**
 * @package APIs plugin
 */

namespace Inc\Base;

class Setup {
    public function register() {
        $this->load_language_file();

        add_action('phpmailer_init', [ $this, 'mailtrap' ]);
    }

    /**
     * Loads a plugin's translated strings.
     */
    private function load_language_file() {
        load_plugin_textdomain('apis', false, '/languages' );
    }    
    
    /**
     *! Temp register mailtrap
     */
    public function mailtrap($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'c2b66440fbebbc';
        $phpmailer->Password = '1c1bcdb48e191f';
    }
}