<?php

namespace TMPlugin;

use TMPlugin\Admin\AddressBook;
use TMPlugin\Admin\Menu;

class Admin {
	private $addressbook;

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		// Instance of addressbook for maintain the singleton pattern
		$this->addressbook = new Admin\AddressBook();

		// Call all the admin class
		new Menu( $this->addressbook );
		// Dispatch all the form action
		$this->dispatch_action();
	}

	/**
	 * Dispatch all the form action
	 */
	public function dispatch_action() {
		add_action( 'admin_init', [ $this->addressbook, 'form_handler' ] );
		add_action( 'admin_post_delete_address', [ $this->addressbook, 'delete_address' ] );
	}
}
