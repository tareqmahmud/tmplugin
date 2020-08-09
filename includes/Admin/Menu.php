<?php

namespace TMPlugin\Admin;


class Menu {
	private $addressbook;

	/**
	 * Menu constructor.
	 *
	 * @param $addressbook
	 */
	public function __construct( $addressbook ) {
		// Fetch the addressbook instance from the Admin class
		$this->addressbook = $addressbook;

		// Dispatch all the action
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	/**
	 * Load all the assets for menu page specifically
	 */
	public function load_admin_menu_assets() {
		wp_enqueue_style( 'admin-menu-css' );
		wp_enqueue_script( 'admin-menu-js' );
	}

	/**
	 * Register menu settings page - Callback
	 */
	public function admin_menu() {
		$capability  = 'manage_options';
		$parent_slug = 'tmplugin';

		$hook = add_menu_page(
			__( 'TMPlugin', 'tmplugin' ),
			__( 'TMPlugin', 'tmplugin' ),
			$capability,
			$parent_slug,
			[ $this, 'menu_page' ],
			'dashicons-welcome-learn-more'
		);

		// Load specific menu page assets
		add_action( "admin_head-{$hook}", [ $this, 'load_admin_menu_assets' ] );

		add_submenu_page(
			$parent_slug,
			__( 'Address Book', 'tmplugin' ),
			__( 'Address Book', 'tmplugin' ),
			$capability,
			$parent_slug,
			[ $this, 'addressbook_page' ]
		);

		add_submenu_page(
			$parent_slug,
			__( 'Settings', 'tmplugin' ),
			__( 'Settings', 'tmplugin' ),
			$capability,
			'tmplugin-settings',
			[ $this, 'settings_page' ]
		);
	}

	/**
	 * Dummy menu page for main menu
	 */
	public function menu_page() {
	}

	/**
	 * Callback for addressbook submenu page
	 */
	public function addressbook_page() {
		$this->addressbook->plugin_page();
	}

	/**
	 * Callback for settings page
	 */
	public function settings_page() {
		echo 'From Settings';
	}
}
