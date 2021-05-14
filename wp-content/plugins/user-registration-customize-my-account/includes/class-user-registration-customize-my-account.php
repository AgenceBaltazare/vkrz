<?php
/**
 * User_Registration_Customize_My_Account setup
 *
 * @package User_Registration_Customize_My_Account
 * @since  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'User_Registration_Customize_My_Account' ) ) :

	/**
	 * Main User_Registration_Customize_My_Account Class
	 *
	 * @class User_Registration_Customize_My_Account
	 */
	final class User_Registration_Customize_My_Account {


		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $_instance = null;

		/**
		 * Plugin Version
		 *
		 * @var string
		 */
		const VERSION = URCMA_VERSION;

		/**
		 * Items class instance
		 *
		 * @var \URCMA_Items
		 * @since 1.0.0
		 */
		public $items = null;

		/**
		 * Admin class instance
		 *
		 * @var \URCMA_Admin
		 * @since 1.0.0
		 */
		public $admin = null;

		/**
		 * Frontend class instance
		 *
		 * @var \URCMA_Frontend
		 * @since 1.0.0
		 */
		public $frontend = null;

		/**
		 * Return an instance of this class
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			// Checks if user registration plugin is installed.
			if ( defined( 'UR_VERSION' ) && version_compare( UR_VERSION, '1.7.5', '>=' ) ) {
				// register custom endpoints.
				add_action( 'init', array( $this, 'add_custom_endpoints' ), 21 );

				$this->includes();
				$this->configs();

				// add actions and filters.
				add_filter( 'user_registration_get_settings_pages', array( $this, 'add_customize_my_account_setting' ), 10, 1 );

				add_action( 'user_registration_init', array( $this, 'plugin_updater' ) );
				add_filter( 'plugin_action_links_' . plugin_basename( UR_CUSTOMIZE_MY_ACCOUNT_PLUGIN_FILE ), array( $this, 'plugin_action_links' ) );

				add_action( 'init', array( $this, 'init_items' ), 20 );
				// rewrite rules.
				add_action( 'init', array( $this, 'rewrite_rules' ), 22 );

			} else {
				add_action( 'admin_notices', array( $this, 'user_registration_missing_notice' ) );
			}
		}

		/**
		 * Plugin Updater.
		 */
		public function plugin_updater() {
			if ( function_exists( 'ur_addon_updater' ) ) {
				ur_addon_updater( UR_CUSTOMIZE_MY_ACCOUNT_PLUGIN_FILE, 46648, self::VERSION );
			}
		}

		/**
		 * Includes.
		 */
		private function includes() {
			require_once 'functions-urcma.php';
			require_once 'class-urcma-items.php';
			$this->items = new URCMA_Items();

			// Class admin.
			if ( $this->is_admin() ) {
				// require file.
				require_once 'class-urcma-admin.php';
				$this->admin = new URCMA_Admin();

			} else {
				// Class frontend.
				require_once 'class-urcma-frontend.php';
				$this->frontend = new URCMA_Frontend();
			}
		}

		/**
		 * Check if is admin or not and load the correct class
		 *
		 * @return bool
		 * @since 1.0.0
		 */
		public function is_admin() {
			$check_ajax    = defined( 'DOING_AJAX' ) && DOING_AJAX;
			$check_context = isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend';

			return is_admin() && ! ( $check_ajax && $check_context );
		}

		/**
		 * Configs
		 */

		private function configs() {

			// require file.
			require_once dirname( __FILE__ ) . '/admin/Customizer/Customizer.php';

			// configs
			require_once dirname( __FILE__ ) . '/admin/Customizer/Config/Wrapper.php';
			require_once dirname( __FILE__ ) . '/admin/Customizer/Config/Color.php';
			require_once dirname( __FILE__ ) . '/admin/Customizer/Config/Navigation.php';
			require_once dirname( __FILE__ ) . '/admin/Customizer/Config/Form.php';
			require_once dirname( __FILE__ ) . '/admin/Customizer/Config/Buttons.php';
		}

		/**
		 * User Registration fallback notice.
		 */
		public function user_registration_missing_notice() {
			/* translators: %s: user-registration plugin link */
			echo '<div class="error notice is-dismissible"><p>' . sprintf( esc_html__( 'User Registration Customize My Account requires %s version 1.7.5 or greater to work!', 'user-registration-customize-my-account' ), '<a href="https://wpeverest.com/wordpress-plugins/user-registration/" target="_blank">' . esc_html__( 'User Registration', 'user-registration-customize-my-account' ) . '</a>' ) . '</p></div>';
		}

		/**
		 * Deprecates old plugin missing notice.
		 *
		 * @deprecated 1.0.2
		 *
		 * @return void
		 */
		public function user_registation_missing_notice() {
			ur_deprecated_function( 'User_Registration_Customize_My_Account::user_registation_missing_notice', '1.0.2', 'User_Registration_Customize_My_Account::user_registration_missing_notice' );
		}

		/**
		 * Display action links in the Plugins list table.
		 *
		 * @param array $actions Add plugin action link.
		 *
		 * @return array
		 */
		public function plugin_action_links( $actions ) {
			$new_actions = array(
				'settings' => '<a href="' . esc_url( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-customize-my-account' ) ) . '" title="' . esc_attr( __( 'View User Registration Import Users Settings', 'user-registration-customize-my-account' ) ) . '">' . __( 'Settings', 'user-registration-customize-my-account' ) . '</a>',
			);

			return array_merge( $new_actions, $actions );
		}

		/**
		 * Adds customizable seetings for my account endpoints.
		 *
		 * @param array $settings Displays settings for customize my account.
		 *
		 * @return array $settings
		 */
		public function add_customize_my_account_setting( $settings ) {
			if ( class_exists( 'UR_Settings_Page' ) ) {
				$settings[] = include_once dirname( __FILE__ ) . '/admin/settings/class-urcma-settings-customize-my-account.php';
			}

			return $settings;
		}

		/**
		 * Init plugin items
		 *
		 * @since 1.1.0
		 */
		public function init_items() {
			$this->items->init(); // init again items.
		}

		/**
		 * Add custom endpoints to main UR array
		 *
		 * @since 1.0.0
		 */
		public function add_custom_endpoints() {
			$slugs = $this->items->get_items_slug();
			if ( empty( $slugs ) || ! is_array( $slugs ) ) {
				return;
			}

			$mask = Ur()->query->get_endpoints_mask();

			foreach ( $slugs as $key => $slug ) {
				if ( $key == 'dashboard' || isset( UR()->query->query_vars[ $key ] ) ) {
					continue;
				}

				UR()->query->query_vars[ $key ] = $slug;
				add_rewrite_endpoint( $slug, $mask );
			}
		}

		/**
		 * Rewrite rules
		 *
		 * @since 1.0.0
		 */
		public function rewrite_rules() {
			$do_flush = get_option( 'urcma-flush-rewrite-rules', 1 );

			if ( $do_flush ) {
				// change option.
				update_option( 'urcma-flush-rewrite-rules', 0 );
				// the flush rewrite rules.
				flush_rewrite_rules();
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
	}
endif;

/**
 * Main instance of User_Registration_Customize_My_Account.
 *
 * @since  1.0.0
 * @return User_Registration_Customize_My_Account
 */
function URCMA() {
	return User_Registration_Customize_My_Account::get_instance();
}
