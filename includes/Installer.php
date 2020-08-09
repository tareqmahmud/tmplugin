<?php

namespace TMPlugin;


class Installer {
	/**
	 * Runnable method to execute this class
	 */
	public function run() {
		$this->create_version();
		$this->create_database();
	}

	/**
	 * Create database table after activate the plugin
	 */
	public function create_database() {
		global $wpdb;

		$db_prefix = $wpdb->prefix;
		$charset   = $wpdb->get_charset_collate();

		$database_query = "CREATE TABLE IF NOT EXISTS `{$db_prefix}ac_addresses` (
  					`id` int unsigned NOT NULL AUTO_INCREMENT,
  					`name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  					`address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  					`phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  					`created_by` bigint NOT NULL,
  					`created_at` DATETIME NOT NULL,
  					PRIMARY KEY (`id`)
					) {$charset}";

		// If dbDelta doesn't require yet then require it
		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}

		// Execute the database query
		dbDelta( $database_query );
	}

	/**
	 * Add version and timestamp after activate the plugin
	 */
	public function create_version() {
		// Add plugin version to the database
		update_option( 'tmplugin_version', TMPLUGIN_VERSION );

		// Add time to the db when the plugin is installed
		$installed = get_option( 'tmplugin_installed' );
		if ( ! $installed ) {
			update_option( 'tmplugin_installed', time() );
		}
	}
}
