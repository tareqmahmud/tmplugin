<?php

namespace TMPlugin\Admin;


class Menu {

	/**
	 * Menu constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	public function admin_menu() {
		$capability = 'manage_options';

		add_menu_page(
			__( 'TMPlugin', 'tmplugin' ),
			__( 'TMPlugin', 'tmplugin' ),
			$capability,
			'tmplugin',
			[ $this, 'tmplugin_display_menu' ],
			'dashicons-welcome-learn-more'
		);

		add_submenu_page(
			'tmplugin',
			__( 'Contact', 'tmplugin' ),
			__( 'Contact', 'tmplugin' ),
			$capability,
			'tmplugin2',
			[ $this, 'tmplugin_display_submenu' ]
		);
	}


	public function tmplugin_display_menu() {
		echo "Hello World";
	}

	public function tmplugin_display_submenu() {
		echo "From Submenu";
	}
}
