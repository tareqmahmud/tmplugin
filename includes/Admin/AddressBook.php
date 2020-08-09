<?php

namespace TMPlugin\Admin;

use TMPlugin\Traits\FormError;

/**
 * AddressBook Handler
 * @package TMPlugin\Admin
 */
class AddressBook {
	// Use formerror traits
	use FormError;

	/**
	 * AddressBook constructor.
	 */
	public function __construct() {
		$action = "tmplugin_delete_address";
		add_action( "wp_ajax_{$action}", [ $this, 'delete_address' ] );
	}


	/**
	 * Show specific page on the settings page based on route
	 */
	public function plugin_page() {
		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

		switch ( $action ) {
			case 'new':
				$template = __DIR__ . '/views/address-new.php';
				break;
			case 'edit':
				$address  = tmplugin_get_address( $id );
				$template = __DIR__ . '/views/address-edit.php';
				break;
			case 'view':
				$template = __DIR__ . '/views/address-view.php';
				break;
			default:
				$template = __DIR__ . '/views/address-list.php';
		}

		if ( file_exists( $template ) ) {
			include $template;
		}
	}

	/**
	 * Handler for handle the form
	 */
	public function form_handler() {
		// Check is the submit_address form or not
		// If not the stop execute this method
		if ( ! isset( $_POST['submit_address'] ) ) {
			return;
		}

		// Check is nonce valid or not
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-address' ) ) {
			wp_die( __( 'Are you cheating?', 'tmplugin' ) );
		}

		// Check submitted person have permission to add new address
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'Are you cheating?', 'tmplugin' ) );
		}

		// Data validation
		// For name
		if ( ! isset( $_POST['name'] ) || empty( $_POST['name'] ) ) {
			$this->errors['name'] = __( 'Please provide the name', 'tmplugin' );
		}

		// If there is error then stop inserted the data
		if ( ! empty( $this->errors ) ) {
			return;
		}

		// Sanitize all the data
		$id      = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
		$name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
		$address = isset( $_POST['address'] ) ? sanitize_textarea_field( $_POST['address'] ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';

		// If all validation passed then insert the data
		$inserted_id = tmplugin_insert_address( array(
			'id'      => $id,
			'name'    => $name,
			'address' => $address,
			'phone'   => $phone
		) );

		// If inserted failed then throw an error
		if ( is_wp_error( $inserted_id ) ) {
			wp_die( $inserted_id->get_error_message() );
		}

		/**
		 * If id available then redirect to the edit page after update
		 * Otherwise redirect to the list page
		 */
		if ( $id ) {
			$redirect_to = admin_url( "admin.php?page=tmplugin&action=edit&success=edit-address&id={$id}" );
		} else {
			// Other wise redirect to the list page with success message
			$redirect_to = admin_url( 'admin.php?page=tmplugin&action=list&success=new-address' );
		}

		wp_redirect( $redirect_to );
		exit;
	}

	/**
	 * Delete an existing address
	 *
	 * @return void
	 */
	public function delete_address() {
		// Check is nonce valid or not
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'tmplugin-delete-address-nonce' ) ) {
			wp_send_json_error( [
				"message" => "Are you cheating?"
			] );
		}

		// Check submitted person have permission to add new address
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [
				"message" => "Are you cheating?"
			] );
		}

		/**
		 * Grab the id from address
		 */
		$id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : 0;

		if ( tmplugin_delete_address( $id ) ) {
			// Otherwise return to the list page
			$redirect_to = admin_url( 'admin.php?page=tmplugin&action=list&success=delete-address' );
		} else {
			$redirect_to = admin_url( 'admin.php?page=tmplugin&action=list' );
		}

		wp_send_json_success( [
			"message" => "Successfully deleted the address"
		] );

		wp_redirect( $redirect_to );
		exit;
	}
}

