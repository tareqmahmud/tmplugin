<?php

/**
 * Helper function for insert address
 *
 * @param array $attrs
 *
 * @return int|WP_Error
 */
function tmplugin_insert_address( $attrs = [] ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'ac_addresses';

	// Check is name delivered from the user or not
	// If not then throw an error
	if ( empty( $attrs['name'] ) ) {
		return new \WP_Error( 'name-error', __( 'Please provide the name', 'tmplugin' ) );
	}

	// Default schema
	$default = array(
		'name'       => '',
		'address'    => '',
		'phone'      => '',
		'created_by' => get_current_user_id(),
		'created_at' => current_time( 'mysql' )
	);

	// Merger passed argument attrs and default
	$data = wp_parse_args( $attrs, $default );

	// if attrs have id then execute update command otherwise execute insert command
	$id = isset( $attrs['id'] ) && $attrs['id'] != 0 ? $attrs['id'] : 0;

	if ( $id ) {
		unset( $attrs['id'] );

		// Update the address
		$updated = $wpdb->update(
			$table_name,
			$data,
			[ "id" => $id ],
			array( '%s', '%s', '%s', '%d', '%s' ),
			array( "%d" )
		);

		// If inserted failed then throw an error
		if ( ! $updated ) {
			return new \WP_Error( 'db-failed', __( 'Sorry the data doesn\'t save', 'tmplugin' ) );
		}

		// If successfully save the data then return the inserted id
		return $wpdb->insert_id;

	} else {
		// Wp Insert
		$inserted = $wpdb->insert(
			$table_name,
			array(
				'name'       => $data["name"],
				'address'    => $data["address"],
				'phone'      => $data["phone"],
				'created_by' => $data["created_by"],
				'created_at' => $data["created_at"],
			),
			array( '%s', '%s', '%s', '%d', '%s' )
		);

		// If inserted failed then throw an error
		if ( ! $inserted ) {
			return new \WP_Error( 'db-failed', __( 'Sorry the data doesn\'t save', 'tmplugin' ) );
		}

		// If successfully save the data then return the inserted id
		return $wpdb->insert_id;
	}
}

/**
 * Fetch all the addresses
 *
 * @param $args
 *
 * @return array|object|null
 */
function tmplugin_get_addresses( $args = [] ) {
	global $wpdb;

	// Generate table by prefix
	$table_name = $wpdb->prefix . 'ac_addresses';

	// Default query parameter
	$default = array(
		'number'  => 20,
		'offset'  => 0,
		'orderby' => 'id',
		'order'   => 'ASC'
	);

	// Merge default and args parameter
	$option = wp_parse_args( $args, $default );

	// Extract all the option
	$orderby = $option['orderby'];
	$order   = $option['order'];
	$number  = $option['number'];
	$offset  = $option['offset'];

	// Prepare the query
	$prepare_query = $wpdb->prepare(
		"SELECT * from {$table_name}  ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d",
		$number, $offset
	);


	// Fetch the result and return
	return $wpdb->get_results( $prepare_query );
}

/**
 * Helper function to get the
 *
 * @return int|null
 */
function tmplugin_address_count() {
	global $wpdb;

	// Generate table by prefix
	$table_name = $wpdb->prefix . 'ac_addresses';

	return (int) $wpdb->get_var( "SELECT count(id) FROM {$table_name}" );
}


/**
 * Fetch a single address from the database
 *
 * @param int $id
 *
 * @return object
 */
function tmplugin_get_address( $id ) {
	global $wpdb;

	// Generate table by prefix
	$table_name = $wpdb->prefix . 'ac_addresses';

	$prepare_query = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE id=%d", $id );

	return $wpdb->get_row( $prepare_query );
}

/**
 * Delete a single address
 *
 * @param int $id
 *
 * @return int|WP_Error
 */
function tmplugin_delete_address( $id ) {
	global $wpdb;

	// Generate table by prefix
	$table_name = $wpdb->prefix . 'ac_addresses';

	// Delete the row
	return $wpdb->delete(
		$table_name,
		[ 'id' => $id ],
		[ '%d' ]
	);
}
