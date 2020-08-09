<?php

namespace TMPlugin;

use const http\Client\Curl\VERSIONS;

class Assets {

	/**
	 * Assets constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Load all the styles
	 */
	public function get_styles() {
		return array(
			'admin-menu-css' => array(
				'file'    => TMPLUGIN_ASSETS . '/admin/css/admin-menu.css',
				'version' => filemtime( TMPLUGIN_PATH . '/assets/admin/css/admin-menu.css' )
			),
			'bootstrap-css'  => array(
				'file'    => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css',
				'version' => TMPLUGIN_VERSION
			),
			'enquiry-css'    => array(
				'file'    => TMPLUGIN_ASSETS . '/public/css/enquiry.css',
				'version' => filemtime( TMPLUGIN_PATH . '/assets/public/css/enquiry.css' )
			),
		);
	}

	/**
	 * Load all the scripts
	 */
	public function get_scripts() {
		return array(
			'admin-menu-js' => array(
				'file'    => TMPLUGIN_ASSETS . '/admin/js/admin-menu.js',
				'version' => filemtime( TMPLUGIN_PATH . '/assets/admin/js/admin-menu.js' ),
				'deps'    => array( 'jquery' )
			),

			'enquiry-js' => array(
				'file'    => TMPLUGIN_ASSETS . '/public/js/enquiry.js',
				'version' => filemtime( TMPLUGIN_PATH . '/assets/public/js/enquiry.js' ),
				'deps'    => array( 'jquery' )
			),
		);
	}

	/**
	 * Enqueue all the scripts
	 */
	public function enqueue_scripts() {
		// Register all the style
		$styles = $this->get_styles();

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : array();
			wp_register_style( $handle, $style['file'], $deps, $style['version'] );
		}

		// Register all the script
		$scripts = $this->get_scripts();
		foreach ( $scripts as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : array();
			wp_register_script( $handle, $script['file'], $deps, $script['version'], true );
		}

		// Pass data to the JS
		wp_localize_script( 'enquiry-js', 'tmplugin', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' )
		) );

		// Pass data to the admin js
		wp_localize_script( 'admin-menu-js', 'tmplugin', array(
			'nonce'   => wp_create_nonce( 'tmplugin-delete-address-nonce' ),
			'action' => 'tmplugin_delete_address',
			'ajaxUrl' => admin_url( 'admin-ajax.php' )
		) );
	}
}
