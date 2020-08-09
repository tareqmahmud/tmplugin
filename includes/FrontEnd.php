<?php

namespace TMPlugin;

use TMPlugin\FrontEnd\Shortcode\Enquiry;

class FrontEnd {

	/**
	 * FrontEnd constructor.
	 */
	public function __construct() {
		// Call all the frontend class
		new Enquiry();

		add_action( 'wp_enqueue_scripts', [ $this, 'load_all_the_frontend_assets' ] );
	}

	public function load_all_the_frontend_assets() {
		wp_enqueue_style( 'bootstrap-css' );
	}
}
