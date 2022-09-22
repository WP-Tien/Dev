<?php 
/**
 * @package APIs plugi
 */

namespace Inc\Strava;

use Inc\Setting\Pages\AdminPage;

class AuthRefresh extends Auth {

    public function register() {
        // $this->hook();

		parent::hook();
	}

    // public function hook() {
    //     parent::hook();
    // }

	/**
	 * Authorize URL for new style refresh token auth.
	 *
	 * @param int $client_id Strava API Client ID.
	 * @return string URL to authorize against.
	 */
	protected function get_authorize_url( $client_id ) {
		return add_query_arg(
			array(
				'client_id'       => $client_id,
				'redirect_uri'    => $this->get_redirect_param(),
				'approval_prompt' => 'auto',
				'scope'           => 'read,activity:read',
			),
			$this->auth_url
		);
	}

	/**
	 * Add 'Authorization_code' grand type to first API request (when authenticating a new user).
	 * 
	 * @param array $data Request array ffor the Strava API.
	 * @return array Data array 'grant_type' => 'authorization_code' added.
	 */
	protected function add_initial_params($data){
		$data['grant_type']	= 'authorization_code';
		return $data;
	}
}