<?php
/**
 * Plugin Name: User Registration Advanced Fields
 * Plugin URI: https://wpeverest.com/wordpress-plugins/user-registration/advanced-fields
 * Description: Advanced Fields for User Registration
 * Version: 1.4.1
 * Author: WPEverest
 * Author URI: https://wpeverest.com
 * Text Domain: user-registration-advanced-fields
 * Domain Path: /languages/
 * UR requires at least: 1.4.0
 * UR tested up to: 1.9.5
 * Copyright: © 2017 WPEverest.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package User_Registration_Advanced_Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'UserRegistrationAdvancedFields' ) ) :

	/**
	 * Main UserRegistrationAdvancedFields Class.
	 *
	 * @class   UserRegistrationAdvancedFields
	 * @version 1.0.0
	 */
	final class UserRegistrationAdvancedFields {

		/**
		 * Plugin version.
		 *
		 * @var string
		 */
		public $version = '1.4.1';

		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $_instance = null;

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function instance() {
			// If the single instance hasn't been set, set it now.
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 *
		 * @since 1.0
		 */
		public function __clone() {
			ur_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'user-registration-advanced-fields' ), '1.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 1.0
		 */
		public function __wakeup() {
			ur_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'user-registration-advanced-fields' ), '1.0' );
		}

		/**
		 * UserRegistrationAdvancedFields Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'user_registration_advanced_fields_loaded' );
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, array( 'URAF_Install', 'install' ) );
			add_action( 'user_registration_loaded', array( $this, 'plugin_updater' ) );
			add_action( 'init', array( $this, 'init' ), 0 );
		}

		/**
		 * Plugin Updater.
		 */
		public function plugin_updater() {
			if ( function_exists( 'ur_addon_updater' ) ) {

				/* @TODO Need to change the ID of the addon */
				ur_addon_updater( __FILE__, 2572, $this->version );

			}
		}

		/**
		 * Define Constants.
		 */
		private function define_constants() {

			$this->define( 'URAF_VERSION', $this->version );
			$this->define( 'URAF_PLUGIN_FILE', __FILE__ );
			$this->define( 'URAF_DS', DIRECTORY_SEPARATOR );
			$this->define( 'URAF_ABSPATH', dirname( __FILE__ ) . URAF_DS );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param string      $name Name.
		 * @param string|bool $value Value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin, ajax, cron or frontend.
		 *
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin':
					return is_admin();
				case 'ajax':
					return defined( 'DOING_AJAX' );
				case 'cron':
					return defined( 'DOING_CRON' );
				case 'frontend':
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		/**
		 * Includes.
		 */
		private function includes() {

			/**
			 * Core classes.
			 */
			include_once URAF_ABSPATH . 'includes/class-uraf-autoloader.php';
			include_once URAF_ABSPATH . 'includes/class-uraf-install.php';
			include_once URAF_ABSPATH . 'includes/functions-uraf-core.php';
			include_once URAF_ABSPATH . 'includes/class-uraf-ajax.php';

			if ( $this->is_request( 'admin' ) ) {
				include_once URAF_ABSPATH . 'includes/admin/class-uraf-admin.php';
				include_once URAF_ABSPATH . 'includes/admin/class-uraf-admin-profile.php';
			}

			$message = uraf_is_compatible();

			if ( $this->is_request( 'frontend' ) && 'YES' == $message ) {

				include_once URAF_ABSPATH . 'includes/class-uraf-frontend.php';
			}

		}

		/**
		 * Init UserRegistrationWooCommerce when WordPress Initialises.
		 */
		public function init() {
			// Before init action.
			do_action( 'before_user_registration_advanced_fields_init' );

			// Set up localisation.
			$this->load_plugin_textdomain();

			// Init action.
			do_action( 'user_registration_advanced_fields_init' );
		}

		/**
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 *
		 * Locales found in:
		 *      - WP_LANG_DIR/user-registration-advanced-fields/user-registration-advanced-fields-LOCALE.mo
		 *      - WP_LANG_DIR/plugins/user-registration-advanced-fields-LOCALE.mo
		 */
		public function load_plugin_textdomain() {
			$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
			$locale = apply_filters( 'plugin_locale', $locale, 'user-registration-advanced-fields' );

			unload_textdomain( 'user-registration-advanced-fields' );
			load_textdomain( 'user-registration-advanced-fields', WP_LANG_DIR . '/user-registration-woocommerce/user-registration-advanced-fields-' . $locale . '.mo' );
			load_plugin_textdomain( 'user-registration-advanced-fields', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

	}

endif;

/**
 * Main instance of UserRegistrationAdvancedFields.
 *
 * @since  1.0.0
 * @return UserRegistrationAdvancedFields
 */
function URAF() {
	return UserRegistrationAdvancedFields::instance();
}

// Global for backwards compatibility.
$GLOBALS['user-registration-advanced-fields'] = URAF();
