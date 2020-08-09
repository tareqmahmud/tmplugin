<?php

namespace TMPlugin;

/**
 * Handle ajax request
 *
 * @package TMPlugin
 */
class Ajax {

	/**
	 * Ajax constructor.
	 */
	public function __construct() {
		$action = "tmplugin_wp_enquiry_nonce";
		add_action( "wp_ajax_{$action}", [ $this, 'submit_enquiry' ] );
	}

	public function submit_enquiry() {
		// Check is nonce valid or not
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'tmplugin-wp-enquiry-nonce' ) ) {
			wp_send_json_error( [
				'message' => 'Sorry the request has been failed'
			] );
		}

		// Send success json
		wp_send_json_success( [
			'message' => 'The request successfully forward'
		] );

		exit;
	}
}
