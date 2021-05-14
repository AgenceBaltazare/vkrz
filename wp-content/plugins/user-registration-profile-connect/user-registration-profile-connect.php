<?php
/**
 * Plugin Name: User Registration Profile Connect
 * Plugin URI: https://wpeverest.com/wordpress-plugins/user-registration/profile-connect/
 * Description: Connect users registered with other means to forms created with user registration
 * Version: 1.0.1
 * Author: WPEverest
 * UR requires at least: 1.1.0
 * UR tested up to: 1.4.1
 * Copyright: © 2017 WPEverest.
 * Author URI: https://wpeverest.com
 * Text Domain: user-registration-profile-connect
 * Domain Path: /languages/
 *
 * @package User_Registration_Profile_Connect
 */

defined( 'ABSPATH' ) || exit;

// Define UR_Profile_Connect_PLUGIN_FILE.
if ( ! defined( 'UR_PROFILE_CONNECT_PLUGIN_FILE' ) ) {
	define( 'UR_PROFILE_CONNECT_PLUGIN_FILE', __FILE__ );
}

// Include the main User_Registration_Profile_Connect class.
if ( ! class_exists( 'User_Registration_Profile_Connect' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-user-registration-profile-connect.php';
}

// Initialize the plugin.
add_action( 'plugins_loaded', array( 'User_Registration_Profile_Connect', 'get_instance' ) );
