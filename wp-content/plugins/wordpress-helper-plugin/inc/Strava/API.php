<?php 
/**
 * @package APIs plugin
 */

namespace Inc\Strava; 

use Inc\Init;

class API {    
    const STRAVA_V3_API = 'https://www.strava.com/api/v3/';

    private $client_id = null;

    /**
     * Constructor
     * 
     * @param int $client_id Strava API Client ID repesenting
     */
    public function __construct( $client_id = null ) {
        $this->client_id = $client_id;
    }

    /**
     * POST something to the Strava API
     * 
     * @param string $uri Path within the Strava API
     * @param array $data Data to POST
     */    
    public function post( $uri, $data = null ) {
        $url = self::STRAVA_V3_API;

		$args = array(
			'body'      => http_build_query( $data ),
			'sslverify' => false,
			'headers'   => array(),
			'timeout'   => 30,
		);   

        $this->get_access_token();

        // !
        // if ( $access_token ) {
		// 	$args['headers']['Authorization'] = 'Bearer ' . $access_token;
		// }

        $response = wp_remote_post( $url . $uri, $args );

        if ( is_wp_error($response) ) {
            $error_msg = $response->get_error_message();

            echo '<div class="error">'. $error_msg .'</div>';
        }

        if ( 200 != $response['response']['code'] ) {
            $body = json_decode( $response['body'] );
            $error = '';

            if ( ! empty( $body->error ) ) {
                $error = $body->error;
            } else {
                $error = print_r( $response, true );
            }
        }

        return json_decode( $response['body'] );
    }  

    /**
     * Get the (ever changing) access token based on current Client ID.
     * 
     * @return string|null String for access token, null if not found.
     */
    private function get_access_token() {
        // If client_id not set (OAuth set-up), don't even look
        // if ( ! $this->client_id ) {
        //     return null;
        // }

        // $settings = Init::get_instance()->settings;

        // echo "<pre style='color: blue; margin-left: 300px;'>";
        // print_r( get_option( $settings->info ) );
        // echo "</pre>";
    }    
}