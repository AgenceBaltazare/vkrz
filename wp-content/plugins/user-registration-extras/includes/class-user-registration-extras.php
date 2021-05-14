<?php
/**
 * User_Registration_Extras setup
 *
 * @package User_Registration_Extras
 * @since  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'User_Registration_Extras' ) ) :

	/**
	 * Main User_Registration_Extras Class
	 *
	 * @class User_Registration_Extras
	 */
	final class User_Registration_Extras {


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
		const VERSION = USER_REGISTRATION_EXTRAS_VERSION;

		/**
		 * Admin class instance
		 *
		 * @var \User_Registration_Extras_Admin
		 * @since 1.0.0
		 */
		public $admin = null;

		/**
		 * Frontend class instance
		 *
		 * @var \User_Registration_Extras_Frontend
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
			if ( defined( 'UR_VERSION' ) && version_compare( UR_VERSION, '1.8.5', '>=' ) ) {

				add_action( 'init', array( $this, 'create_post_type' ), 0 );

				$this->includes();
				add_action( 'init', array( 'User_Registration_Extras_Shortcodes', 'init' ) );

				// add actions and filters.
				add_filter( 'user_registration_get_settings_pages', array( $this, 'add_user_registration_extras_setting' ), 10, 1 );

				add_action( 'user_registration_init', array( $this, 'plugin_updater' ) );
				add_filter( 'plugin_action_links_' . plugin_basename( USER_REGISTRATION_EXTRAS_FILE ), array( $this, 'plugin_action_links' ) );

			} else {
				add_action( 'admin_notices', array( $this, 'user_registration_missing_notice' ) );
			}
		}

		/**
		 * Plugin Updater.
		 */
		public function plugin_updater() {
			if ( function_exists( 'ur_addon_updater' ) ) {
				ur_addon_updater( USER_REGISTRATION_EXTRAS_FILE, 61895, self::VERSION );
			}
		}

		/**
		 * Includes.
		 */
		private function includes() {
			require_once 'functions-ur-extras.php';
			include_once 'class-ur-extras-shortcodes.php';
			include_once 'class-ur-extras-ajax.php';

			// Class admin.
			if ( $this->is_admin() ) {
				// require file.
				require_once 'class-ur-extras-admin.php';
				include_once dirname( __FILE__ ) . '/class-ur-extras-popup-table-list.php';
				include_once dirname( __FILE__ ) . '/class-ur-extras-dashboard-analytics.php';
				$this->admin = new User_Registration_Extras_Admin();
			} else {
				// require file.
				require_once 'class-ur-extras-frontend.php';
				$this->frontend = new User_Registration_Extras_Frontend();
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
		 * User Registration fallback notice.
		 */
		public function user_registration_missing_notice() {
			/* translators: %s: user-registration plugin link */
			echo '<div class="error notice is-dismissible"><p>' . sprintf( esc_html__( 'User Registration Extras requires %s version 1.8.5 or greater to work!', 'user-registration-extras' ), '<a href="https://wpeverest.com/wordpress-plugins/user-registration/" target="_blank">' . esc_html__( 'User Registration', 'user-registration-extras' ) . '</a>' ) . '</p></div>';
		}

		/**
		 * Deprecates old plugin missing notice.
		 *
		 * @deprecated 1.0.2
		 *
		 * @return void
		 */
		public function user_registation_missing_notice() {
			ur_deprecated_function( 'User_Registration_Extras::user_registation_missing_notice', '1.0.2', 'User_Registration_Extras::user_registration_missing_notice' );
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
				'settings' => '<a href="' . admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras' ) . '" title="' . esc_attr( __( 'View User Registration Extras Settings', 'user-registration-extras' ) ) . '">' . __( 'Settings', 'user-registration-extras' ) . '</a>',
			);

			return array_merge( $new_actions, $actions );
		}

		/**
		 * Adds settings for extra features.
		 *
		 * @param array $settings Displays settings for extra features.
		 *
		 * @return array $settings
		 */
		public function add_user_registration_extras_setting( $settings ) {
			if ( class_exists( 'UR_Settings_Page' ) ) {
				$settings[] = include_once dirname( __FILE__ ) . '/admin/settings/class-ur-extras-settings.php';
			}

			return $settings;
		}



		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}


		// Register Custom Post Type
		function create_post_type() {

			register_post_type(
				'ur_extras_popup',
				apply_filters(
					'user_registration_extras_popup_post_type',
					array(
						'labels'              => array(
							'name'               => __( 'Popups', 'user-registration-extras' ),
							'singular_name'      => __( 'Popup', 'user-registration-extras' ),
							'menu_name'          => _x( 'Popups', 'Admin Popup name', 'user-registration-extras' ),
							'add_new'            => __( 'Add popups', 'user-registration-extras' ),
							'add_new_item'       => __( 'Add popups', 'user-registration-extras' ),
							'edit'               => __( 'Edit', 'user-registration-extras' ),
							'edit_item'          => __( 'Edit popup', 'user-registration-extras' ),
							'new_item'           => __( 'New popup', 'user-registration-extras' ),
							'view'               => __( 'View popups', 'user-registration-extras' ),
							'view_item'          => __( 'View popup', 'user-registration-extras' ),
							'search_items'       => __( 'Search popups', 'user-registration-extras' ),
							'not_found'          => __( 'No popups found', 'user-registration-extras' ),
							'not_found_in_trash' => __( 'No popups found in trash', 'user-registration-extras' ),
							'parent'             => __( 'Parent popup', 'user-registration-extras' ),
						),
						'public'              => false,
						'show_ui'             => true,
						'capability_type'     => 'post',
						'map_meta_cap'        => true,
						'publicly_queryable'  => false,
						'exclude_from_search' => true,
						'show_in_menu'        => false,
						'hierarchical'        => false,
						'rewrite'             => false,
						'query_var'           => false,
						'supports'            => false,
						'show_in_nav_menus'   => false,
						'show_in_admin_bar'   => false,
					)
				)
			);

		}
	}
endif;

/**
 * Main instance of User_Registration_Extras.
 *
 * @since  1.0.0
 * @return User_Registration_Extras
 */
function User_Registration_Extras() {
	return User_Registration_Extras::get_instance();
}
