<?php
/**
 * Installation related functions and actions.
 *
 * @class    URAF_Install
 * @version  1.0.0
 * @package  UserRegistrationAdvancedFields/Classes
 * @category Admin
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URAF_Install Class.
 */
class URAF_Install {

	/**
	 * Initiate
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
		add_action( 'admin_init', array( __CLASS__, 'install_actions' ) );

	}

	/**
	 * Check UserRegistration version and run the updater is required.
	 *
	 * This check is done on all requests and runs if the versions do not match.
	 */
	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 'user_registration_advanced_fields' ) !== URAF()->version ) {
			self::install();
			do_action( 'user_registration_advanced_fields_updated' );
		}
	}

	/**
	 * Install actions when a update button is clicked within the admin area.
	 *
	 * This function is hooked into admin_init to affect admin only.
	 */
	public static function install_actions() {

	}

	/**
	 * Install URAF.
	 */
	public static function install() {
		global $wpdb;

		if ( ! is_blog_installed() ) {
			return;
		}

		if ( ! defined( 'URAF_INSTALLING' ) ) {
			define( 'URAF_INSTALLING', true );
		}

		self::update_uraf_version();

		// Trigger action.
		do_action( 'user_registration_advanced_fields_installed' );

		set_transient( '_uraf_activation_redirect', 1, 30 );

	}

	/**
	 * Update UR version to current.
	 */
	private static function update_uraf_version() {
		delete_option( 'user_registration_advanced_fields' );
		add_option( 'user_registration_advanced_fields', URAF()->version );
	}

}
