<?php
/**
 * Plugin Name: User Registration Style Customizer
 * Plugin URI: https://wpeverest.com/wordpress-plugins/user-registration/style-customizer
 * Description: Customize your User Registration elements with the WordPress Customizer.
 * Version: 1.0.3
 * Author: WPEverest
 * UR requires at least: 1.7.0
 * UR tested up to: 1.9.5
 * Copyright: © 2017 WPEverest.
 * Author URI: https://wpeverest.com
 * Text Domain: user-registration-style-customizer
 * Domain Path: /languages/
 *
 * @package User_Registration_Style_Customizer
 */

defined( 'ABSPATH' ) || exit;

// Define UR_STYLE_CUSTOMIZER_PLUGIN_FILE.
if ( ! defined( 'UR_STYLE_CUSTOMIZER_PLUGIN_FILE' ) ) {
	define( 'UR_STYLE_CUSTOMIZER_PLUGIN_FILE', __FILE__ );
}

// Include the main User_Registration_Two_Factor_Auth_Totp class.
if ( ! class_exists( 'User_Registration_Style_Customizer' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-user-registration-style-customizer.php';
}

// Initialize the plugin.
add_action( 'plugins_loaded', array( 'User_Registration_Style_Customizer', 'get_instance' ), 5 );
