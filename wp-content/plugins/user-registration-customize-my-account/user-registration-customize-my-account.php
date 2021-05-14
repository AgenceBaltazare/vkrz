<?php
/**
 * Plugin Name: User Registration Customize My Account
 * Plugin URI: https://wpeverest.com/wordpress-plugins/user-registration/customize-my-account
 * Description: Customize My Account addon for user registration plugin.
 * Version: 1.1.1
 * Author: WPEverest
 * Author URI: https://wpeverest.com
 * Text Domain: user-registration-customize-my-account
 * Domain Path: /languages/
 * UR requires at least: 1.7.5
 * UR tested up to: 1.9.6
 *
 * Copyright: © 2017 WPEverest.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package User_Registration_Customize_My_Account
 */

defined( 'ABSPATH' ) || exit;


if ( ! defined( 'URCMA_VERSION' ) ) {
	define( 'URCMA_VERSION', '1.1.1' );
}

// Define UR_CUSTOMIZE_MY_ACCOUNT_PLUGIN_FILE.
if ( ! defined( 'UR_CUSTOMIZE_MY_ACCOUNT_PLUGIN_FILE' ) ) {
	define( 'UR_CUSTOMIZE_MY_ACCOUNT_PLUGIN_FILE', __FILE__ );
}

// Include the main User_Registration_Customize_My_Account class.
if ( ! class_exists( 'User_Registration_Customize_My_Account' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-user-registration-customize-my-account.php';
}

if ( ! defined( 'URCMA_DIR' ) ) {
	define( 'URCMA_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'URCMA_URL' ) ) {
	define( 'URCMA_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'URCMA_TEMPLATE_PATH' ) ) {
	define( 'URCMA_TEMPLATE_PATH', URCMA_DIR . 'templates' );
}

if ( ! defined( 'URCMA_ASSETS_URL' ) ) {
	define( 'URCMA_ASSETS_URL', URCMA_URL . 'assets' );
}
// Initialize the plugin.
add_action( 'plugins_loaded', array( 'User_Registration_Customize_My_Account', 'get_instance' ) );
