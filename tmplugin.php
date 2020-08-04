<?php
/**
 * Plugin Name: TMPlugin
 * Description: Boilerplate plugin for WordPress plugin development
 * Plugin URI: https://tareqmahmud.com/tmplugin
 * Author: Tareq Mahmud
 * Author URI: https://tareqmahmud.com
 * Version: 0.0.1
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent access this file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include composer vendor autoload for auto import
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class TMPlugin - Is a base or main initialize plugin
 */
final class TMPlugin {
	/**
	 * Plugin Version
	 */
	const version = '0.0.1';

	/**
	 * TMPlugin constructor.
	 * Using private for prevent duplicate instance using constructor
	 */
	private function __construct() {
		// Execute all the defined constant
		$this->define_constants();

		// What will happen after the activate the plugin
		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		// What will happen after all the plugins is loaded
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}


	/**
	 * Initialize a singleton instance
	 * So that on this plugin there is only one class instance
	 *
	 * @return TMPlugin
	 */
	public static function init() {
		$instance = false;

		// If there isn't any instance available yet then
		// Create a new instance of this class
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define repeatable constants for use later
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'TMPLUGIN_VERSION', self::version );
		define( 'TMPLUGIN_FILE', __FILE__ );
		define( 'TMPLUGIN_PATH', __DIR__ );
		define( 'TMPLUGIN_URL', plugin_dir_url( TMPLUGIN_FILE ) );
		define( 'TMPLUGIN_ASSETS', TMPLUGIN_URL . '/assets' );
	}

	/**
	 * The things will do after plugin activated
	 *
	 * @return void
	 */
	public function activate() {
		// Add plugin version to the database
		update_option( 'tmplugin_version', TMPLUGIN_VERSION );

		// Add time to the db when the plugin is installed
		$installed = get_option( 'tmplugin_installed' );
		if ( ! $installed ) {
			update_option( 'tmplugin_installed', time() );
		}
	}

	/**
	 * The things will do after all the plugin is loaded
	 *
	 * @return void
	 */
	public function init_plugin() {
		if ( is_admin() ) {
			new TMPlugin\Admin();
		} else {
			new TMPlugin\FrontEnd();
		}
	}
}

/**
 * Initialize the main plugin
 *
 * @return TMPlugin
 */
function tmplugin() {
	return TMPlugin::init();
}

// Fire up or kick-off the plugin
tmplugin();
