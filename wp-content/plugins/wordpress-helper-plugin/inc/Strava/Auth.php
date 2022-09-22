<?php 
/**
 * @package APIs plugin
 */

namespace Inc\Strava; 

use Inc\Init;
use Inc\Base\Usage;
use Inc\Strava\API;

// use Inc\Setting\Pages\AdminPage;

abstract class Auth {
   
    protected $auth_url = 'https://www.strava.com/oauth/authorize?response_type=code';

    abstract protected function get_authorize_url( $client_id );

    public function hook() {
        if ( is_admin() ) {
            add_filter( 'pre_set_transient_settings_errors', [ $this, 'maybe_oauth' ] );
            add_action( 'admin_init', [ $this, 'init' ] );    
        }

        // $strava = get_option( 'strava' );
        // echo "<pre style='color: red; margin-left: 300px;'>";
        // print_r( $strava );
        // echo "</pre>";
    }
    
    /**
     * This runs after options are saved
     */
    public function maybe_oauth( $value ) {
        $settings = Init::get_instance()->settings;

        if ( $_POST['strava'] ) {
            $post = $_POST['strava'];
        } else {
            return;
        }
    
        $sanitize_client_id = filter_var( $post['strava_client_id'], FILTER_SANITIZE_NUMBER_INT );
        $sanitize_client_secret = filter_var( $post['strava_client_secret'], FILTER_SANITIZE_STRING );
      
        // Redirect only if all the right options are in place.
        if ( $settings->is_settings_updated( $value ) && $settings->is_strava_options_page() ) {
            // 
            $flag = true;
            
            if( ! empty( $sanitize_client_id ) && ! empty( $sanitize_client_secret ) ) {
                wp_redirect( $this->get_authorize_url( $sanitize_client_id ) );
				exit();
            }
        }

        return $value;
    }

    protected function get_redirect_param() {
		$page_name = Init::get_instance()->settings->get_strava_page_name();

		return rawurlencode( admin_url( "admin.php?page={$page_name}" ) );
	}

    public function init() {
        $settings = Init::get_instance()->settings;

        $input_args = [
            'settings-updated'  => FILTER_SANITIZE_STRING,
            'code'             => FILTER_SANITIZE_STRING,
        ];

        $input = filter_input_array( INPUT_GET, $input_args );

        // only update when redirected back from strava
        if ( ! isset( $input['settings-updated'] ) && $settings->is_strava_settings_page() ) {
            if ( isset( $input['code'] ) ) {

                $info = $this->token_exchange_initial( $input['code'] );

            } elseif ( isset( $_GET['error'] ) ) {
                add_settings_error( 'strava_token', 'strava_token', sprintf( __( 'Error authenticating at Strava: %s', 'apis' ), str_replace( '_', ' ', $_GET['error'] ) ) );
            }
        }
    }

    // Was fetch_token();
    private function token_exchange_initial( $code ) {
        $settings = Init::get_instance()->settings;
        $client_id = $settings->client_id;
        $client_secret = $settings->client_secret;

        $settings->delete_id_secret();

        if ( $client_id && $client_secret ) {
            $data = [
                'client_id'         => $client_id,
                'client_secret'     => $client_secret,
                'code'              => $code
            ];

            $data = $this->add_initial_params( $data );

            try {
                $strava_info = $this->token_request( $data );
            } catch( Exception $e ) {
                Usage::write_log( $e );
            }

            $settings->add_id( $client_id );
            
            if ( isset( $strava_info->access_token ) ) {
                $settings->add_id( $client_id );
                $settings->save_info( $client_id, $client_secret, $strava_info );
            }
        }   
    }

    protected function token_request( $data ) {
        $api = new API;
        return $api->post( 'oauth/token', $data );
    }

    protected function add_initial_params( $data ) {
        return $data;
    }
}