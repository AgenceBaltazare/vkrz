<?php
/**
 * Plugin Name: User Registration Extras
 * Plugin URI: https://wpeverest.com/wordpress-plugins/user-registration/extras
 * Description: Extras addon for user registration plugin.
 * Version: 1.0.6
 * Author: WPEverest
 * Author URI: https://wpeverest.com
 * Text Domain: user-registration-extras
 * Domain Path: /languages/
 * UR requires at least: 1.8.5
 * UR tested up to: 1.9.7
 *
 * Copyright: © 2017 WPEverest.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package User_Registration_Extras
 */

defined( 'ABSPATH' ) || exit;


if ( ! defined( 'USER_REGISTRATION_EXTRAS_VERSION' ) ) {
	define( 'USER_REGISTRATION_EXTRAS_VERSION', '1.0.6' );
}

// Define USER_REGISTRATION_EXTRAS_FILE.
if ( ! defined( 'USER_REGISTRATION_EXTRAS_FILE' ) ) {
	define( 'USER_REGISTRATION_EXTRAS_FILE', __FILE__ );
}

// Include the main User_Registration_Extras class.
if ( ! class_exists( 'User_Registration_Extras' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-user-registration-extras.php';
}

if ( ! defined( 'USER_REGISTRATION_EXTRAS_DIR' ) ) {
	define( 'USER_REGISTRATION_EXTRAS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'USER_REGISTRATION_EXTRAS_URL' ) ) {
	define( 'USER_REGISTRATION_EXTRAS_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'USER_REGISTRATION_EXTRAS_TEMPLATE_PATH' ) ) {
	define( 'USER_REGISTRATION_EXTRAS_TEMPLATE_PATH', USER_REGISTRATION_EXTRAS_DIR . 'templates' );
}

if ( ! defined( 'USER_REGISTRATION_EXTRAS_ASSETS_URL' ) ) {
	define( 'USER_REGISTRATION_EXTRAS_ASSETS_URL', USER_REGISTRATION_EXTRAS_URL . 'assets' );
}
// Initialize the plugin.
add_action( 'plugins_loaded', array( 'User_Registration_Extras', 'get_instance' ) );
