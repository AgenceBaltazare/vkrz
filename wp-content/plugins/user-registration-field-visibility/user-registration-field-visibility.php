<?php
/**
 * Plugin Name: User Registration Field Visibility
 * Plugin URI: https://wpeverest.com/wordpress-plugins/user-registration/field-visibility
 * Description: Allows you to add field visibility option for specific roles and in specific location.
 * Version: 1.1.1
 * Author: WPEverest
 * UR requires at least: 1.6.0
 * UR tested up to: 1.8.6
 * Copyright: © 2017 WPEverest.
 * Author URI: https://wpeverest.com
 * Text Domain: user-registration-field-visibility
 * Domain Path: /languages/
 *
 * @package User_Registration_Field_Visibility
 */

defined( 'ABSPATH' ) || exit;

// Define UR_FIELD_VISIBILITY_PLUGIN_FILE.
if ( ! defined( 'UR_FIELD_VISIBILITY_PLUGIN_FILE' ) ) {
	define( 'UR_FIELD_VISIBILITY_PLUGIN_FILE', __FILE__ );
}

// Include the main User_Registration_Field_Visibility class.
if ( ! class_exists( 'User_Registration_Field_Visibility' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-user-registration-field-visibility.php';
}

// Initialize the plugin.
add_action( 'plugins_loaded', array( 'User_Registration_Field_Visibility', 'get_instance' ) );
