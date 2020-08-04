<?php

namespace TMPlugin;

use TMPlugin\FrontEnd\Shortcode;

class FrontEnd {

	/**
	 * FrontEnd constructor.
	 */
	public function __construct() {
		// Call all the frontend class
		new Shortcode();
	}
}
