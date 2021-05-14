<?php
/**
 * Installation related functions and actions.
 *
 * @version 1.0.0
 * @package UserRegistrationConditionalLogic/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Install Class.
 */
class URCL_Install {

	/**
	 * Hook in tabs.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
		add_action( 'admin_init', array( __CLASS__, 'install_actions' ) );
		add_filter( 'plugin_action_links_' . URCL_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
	}

	/**
	 * Check UserRegistration version and run the updater is required.
	 *
	 * This check is done on all requests and runs if the versions do not match.
	 */
	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 'user_registration_conditional_logic' ) !== URCL()->version ) {
			self::install();
			do_action( 'user_registration_conditional_logic_updated' );
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
	 * Install UR.
	 */
	public static function install() {
		global $wpdb;

		if ( ! is_blog_installed() ) {
			return;
		}

		if ( ! defined( 'URCL_INSTALLING' ) ) {
			define( 'URCL_INSTALLING', true );
		}

		self::update_ur_version();

		// Trigger action
		do_action( 'user_registration_conditional_logic_installed' );

		set_transient( '_urcl_activation_redirect', 1, 30 );

	}

	/**
	 * Update UR version to current.
	 */
	private static function update_ur_version() {
		delete_option( 'user_registration_conditional_logic' );
		add_option( 'user_registration_conditional_logic', URCL()->version );
	}

	/**
	 * Display action links in the Plugins list table.
	 *
	 * @param  array $actions
	 *
	 * @return array
	 */
	public static function plugin_action_links( $actions ) {
		$message = urcl_is_compatible();

		if ( 'YES' !== $message ) {
			return $actions;
		}

		$new_actions = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=user-registration-settings&tab=conditional-logic' ) . '" title="' . esc_attr( __( 'View User Registration Conditional Logic Settings', 'user-registration-conditional-logic' ) ) . '">' . __( 'Settings', 'user-registration-conditional-logic' ) . '</a>',
		);

		return array_merge( $new_actions, $actions );
	}

	public static function plugin_row_meta( $plugin_meta, $plugin_file ) {
		die;
		if ( $plugin_file == URCL_PLUGIN_BASENAME ) {
			$new_plugin_meta = array(
				'docs'    => '<a href="' . esc_url( apply_filters( 'user_registration_conditional_logic_docs_url', 'https://docs.wpeverest.com/docs/user-registration/user-registration-add-ons/user-registration-conditional-logic/' ) ) . '" title="' . esc_attr( __( 'View User Registration Conditional Logic Documentation', 'user-registration-conditional-logic' ) ) . '">' . __( 'Docs', 'user-registration-conditional-logic' ) . '</a>',
			);

			return array_merge( $plugin_meta, $new_plugin_meta );
		}

		return (array) $plugin_meta;
	}
}

URCL_Install::init();
