<?php

namespace TMPlugin\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class  AddressBook_List extends \WP_List_Table {

	/**
	 * AddressBook_List constructor.
	 */
	public function __construct() {
		parent::__construct( array(
			array(
				'singular' => 'contact',
				'plural'   => 'contacts',
				'ajax'     => false
			)
		) );
	}

	/**
	 * This is a override method for define all the columns
	 *
	 * @return array|void
	 */
	public function get_columns() {
		return array(
			'cb'         => '<input type="checkbox" />',
			'name'       => __( 'Name', 'tmplugin' ),
			'address'    => __( 'Address', 'tmplugin' ),
			'phone'      => __( 'Phone', 'tmplugin' ),
			'created_at' => __( 'Date', 'tmplugin' ),
		);
	}

	/**
	 * Define how the item will be display
	 *
	 * @param object $item
	 * @param string $column_name
	 *
	 * @return string
	 */
	protected function column_default( $item, $column_name ) {
		return isset( $item->$column_name ) ? $item->$column_name : "";
	}

	/**
	 * Define which column will be sortable
	 *
	 * @return array
	 */
	protected function get_sortable_columns() {
		return array(
			'name'       => [ 'name', true ],
			'created_at' => [ 'created_at', true ]
		);
	}


	/**
	 * How the name will be display
	 *
	 * @param $item
	 *
	 * @return string
	 */
	public function column_name( $item ) {
		// Display the action after hover
		$actions = [];

		// Edit button
		$actions['edit'] = sprintf( "<a href='%s'>Edit</a>", admin_url( 'admin.php?page=tmplugin&action=edit&id=' . $item->id ) );
//		$actions['delete'] = sprintf( "<a href='%s' class='submitdelete' onclick='return confirm(\"Are you sure?\")'>Delete</a>", wp_nonce_url( admin_url( 'admin-post.php?page=tmplugin&action=delete_address&id=' . $item->id ), 'delete_address' ) );
		$actions['delete'] = sprintf( "<a href='#' data-id='{$item->id}' class='submitdelete'>Delete</a>" );

		return sprintf(
			"<a href='%s'><strong>%s</strong></a> %s",
			admin_url( admin_url( 'admin.php?page=tmplugin&action=view&id=' . $item->id ) ),
			$item->name,
			$this->row_actions( $actions )
		);
	}

	/**
	 * How to column checkbox will be display
	 *
	 * @param object $item
	 *
	 * @return string
	 */
	protected function column_cb( $item ) {
		return sprintf(
			"<input type='checkbox' name='address_id[]' value='%d' />",
			$item->id
		);
	}

	/**
	 * This is override method for
	 * prepare all the items
	 */
	public function prepare_items() {
		// Fetch all the columns
		$columns = $this->get_columns();

		// Define all the hidden value
		$hidden = [];

		// Define all the sortable item
		$sortable = $this->get_sortable_columns();

		// Execute all the columns header
		$this->_column_headers = [ $columns, $hidden, $sortable ];

		// Pagination Params
		$per_page     = 20;
		$current_page = $this->get_pagenum();
		$offset       = ( $current_page - 1 ) * $per_page;

		// Query params
		$args = array(
			'number' => $per_page,
			'offset' => $offset
		);

		// Get Order from dashboard
		if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
			$args['orderby'] = $_REQUEST['orderby'];
			$args['order']   = $_REQUEST['order'];
		}

		// Fetch all the address
		$this->items = tmplugin_get_addresses( $args );

		// Set pagination
		$this->set_pagination_args( array(
			'total_items' => tmplugin_address_count(),
			'per_page'    => $per_page
		) );

	}
}
