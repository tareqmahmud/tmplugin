<?php

namespace TMPlugin;

use TMPlugin\Admin\Menu;

class Admin {

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		// Call all the admin class
		new Menu();
	}
}
