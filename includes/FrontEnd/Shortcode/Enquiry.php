<?php

namespace TMPlugin\FrontEnd\Shortcode;

class Enquiry {

	/**
	 * Enquiry constructor.
	 */
	public function __construct() {
		add_shortcode( 'enquiry', [ $this, 'enquiry_form' ] );
	}

	public function enquiry_form() {
		// Load this shortcode specific assets
		wp_enqueue_style( 'enquiry-css' );
		wp_enqueue_script( 'enquiry-js' );


		ob_start();
		include __DIR__ . '/views/enquiry-view.php';

		return ob_get_clean();
	}
}
