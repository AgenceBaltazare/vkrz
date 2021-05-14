<?php
/**
 * Frontend class
 *
 * @package User Registration Customize My Account
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'URCMA_Frontend' ) ) {
	/**
	 * Frontend class.
	 * The class manage all the frontend behaviors.
	 *
	 * @since 1.0.0
	 */
	class URCMA_Frontend {

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = URCMA_VERSION;

		/**
		 * Page templates
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_is_myaccount = false;

		/**
		 * Boolean to check if account have menu
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_my_account_have_menu = false;

		/**
		 * Menu Shortcode
		 *
		 * @var string
		 */
		protected $_shortcode_name = 'urcma-menubar';

		/**
		 * My account endpoint
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_menu_endpoints = array();

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// plugin frontend init.
			add_action( 'init', array( $this, 'init' ), 100 );

			// enqueue scripts and styles.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 15 );

			// check if is shortcode my-account.
			add_action( 'template_redirect', array( $this, 'check_myaccount' ), 1 );
			// redirect to the default endpoint.
			add_action( 'template_redirect', array( $this, 'redirect_to_default' ), 150 );
			// add new navigation.
			add_action( 'user_registration_account_navigation', array( $this, 'add_my_account_menu' ), 10 );
			// manage account content.
			add_action( 'user_registration_account_content', array( $this, 'manage_account_content' ), 1 );
			// change title.
			add_action( 'template_redirect', array( $this, 'manage_account_title' ), 10 );

			// shortcode for print my account sidebar.
			add_shortcode( $this->_shortcode_name, array( $this, 'my_account_menu' ) );

			// shortcode to print default dashboard.
			add_shortcode( 'default_dashboard_content', array( $this, 'print_default_dashboard_content' ) );

			// mem if is my account page.
			add_action( 'shutdown', array( $this, 'save_is_my_account' ) );

		}

		/**
		 * Init plugins variable
		 *
		 * @since 1.0.0
		 */
		public function init() {

			$this->_menu_endpoints = URCMA()->items->get_items();

			// get current user and set user role.
			$current_user = wp_get_current_user();
			$user_role    = (array) $current_user->roles;

			// first register string for translations then remove disable.
			foreach ( $this->_menu_endpoints as $endpoint => &$options ) {

				// check if master is active.
				if ( isset( $options['active'] ) && ! $options['active'] ) {
					unset( $this->_menu_endpoints[ $endpoint ] );
					continue;
				}

				// check master by user roles.
				if ( isset( $options['usr_roles'] ) && $this->hide_by_usr_roles( $options['usr_roles'], $user_role ) ) {
					unset( $this->_menu_endpoints[ $endpoint ] );
					continue;
				}

				$payment_method = get_user_meta( get_current_user_id(), 'ur_payment_method', true );

				// Check if user is registered through any payment method.
				if ( 'payment' === $endpoint && '' === $payment_method ) {
					unset( $this->_menu_endpoints[ $endpoint ] );
					continue;
				}
			}

			// also remove the my-account template.
			$my_account_id = ur_get_page_id( 'myaccount' );
			if ( 'my-account.php' == get_post_meta( $my_account_id, '_wp_page_template', true ) ) {
					update_post_meta( $my_account_id, '_wp_page_template', 'default' );
			}

			// remove standard user_registration menu bar.
			if ( ( $priority = has_action( 'user_registration_account_navigation', 'user_registration_account_navigation' ) ) !== false ) {
				remove_action( 'user_registration_account_navigation', 'user_registration_account_navigation' );
			}
		}

		/**
		 * Add plugin menu to My Account shortcode
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_my_account_menu() {

			if ( apply_filters( 'urcma_my_account_have_menu', $this->_my_account_have_menu ) ) {
				return;
			}

			ob_start();
			remove_action( 'user_registration_account_navigation', 'user_registration_account_navigation' );
			echo do_shortcode( '[' . $this->_shortcode_name . ']' );

			echo ob_get_clean();

			// set my account menu variable. This prevent double menu.
			$this->_my_account_have_menu = true;
		}

		/**
		 * Manage endpoint account content based on plugin option
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function manage_account_content() {

			// search for active endpoints.
			$active = urcma_get_current_endpoint();
			// get active endpoint options by slug.
			$endpoint = urcma_get_endpoint_by( $active, 'key', $this->_menu_endpoints );

			if ( empty( $endpoint ) || ! is_array( $endpoint ) ) {
				return;
			}
			// get key.
			$key = key( $endpoint );

			/**
			 * Check if override endpoint content option is enabled.
			 *
			 * @since 1.1.1
			 */
			if( isset( $endpoint[ $key ]['override_content'] ) && "on" === $endpoint[ $key ]['override_content'] ) {
				remove_action( 'user_registration_account_content', 'user_registration_account_content' );

				// check in custom content.
				if ( ! empty( $endpoint[ $key ]['content'] ) ) {
					echo do_shortcode( $endpoint[ $key ]['content'] );
				}
			} else {
				if ( ! empty( $endpoint[ $key ]['content'] ) ) {
					$content = $endpoint[ $key ]['content'];
					add_action("user_registration_account_content", function( $endpoint_content )  use ( $content ) {
						echo do_shortcode( $content );
					});
				}
			}

		}

		/**
		 * Change my account page title based on endpoint
		 *
		 * @since 1.0.0
		 */
		public function manage_account_title() {

			global $wp, $post;

			// search for active endpoints.
			$active = urcma_get_current_endpoint();
			// get active endpoint options by slug.
			$endpoint = urcma_get_endpoint_by( $active, 'slug', $this->_menu_endpoints );

			if ( empty( $endpoint ) || ! is_array( $endpoint ) ) {
				return;
			}

			// get key.
			$key = key( $endpoint );

			if ( ! empty( $endpoint[ $key ]['label'] ) && 'dashboard' != $active ) {
				$post->post_title = stripslashes( $endpoint[ $key ]['label'] );
			}
		}

		/**
		 * Hide field based on current user role
		 *
		 * @since 1.0.0
		 * @param array $roles Retrieves the all the roles applicaple to user.
		 * @param array $current_user_role Retrieves the role of current user.
		 * @return boolean
		 */
		protected function hide_by_usr_roles( $roles, $current_user_role ) {
			// return if $roles is empty.
			if ( empty( $roles ) || current_user_can( 'administrator' ) ) {
				return false;
			}

			// check if current user can.
			foreach ( $current_user_role as $current_role ) {

				if ( in_array( $current_role, $roles ) ) {
						return true;
				}
			}

			return false;
		}

		/**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {

			if ( ! $this->_is_myaccount ) {
				return;
			};

			// font awesome.
			wp_register_style( 'font-awesome', URCMA_ASSETS_URL . '/css/font-awesome.min.css' );
			wp_register_style( 'urcma-frontend', URCMA_ASSETS_URL . '/css/urcma-frontend.css' );

			wp_enqueue_style( 'font-awesome' );
			wp_enqueue_style( 'urcma-frontend' );

			/**
			 * Enqueue styles from customizer.
			 *
			 * @since 1.1.0
			 */
			$upload_dir = wp_upload_dir( null, false );

			// Enqueue shortcode styles.
			if ( file_exists( trailingslashit( $upload_dir['basedir'] ) . 'user_registration_customize_my_account/user-registration-customize-my-account.css' ) ) {
				wp_enqueue_style( 'user-registration-customize-my-account', trailingslashit( $upload_dir['baseurl'] ) . 'user_registration_customize_my_account/user-registration-customize-my-account.css', array(), filemtime( trailingslashit( $upload_dir['basedir'] ) . 'user_registration_customize_my_account/user-registration-customize-my-account.css' ), 'all' );
			}

		}

		/**
		 * Check if is page my-account and set class variable
		 *
		 * @since 1.0.0
		 */
		public function check_myaccount() {
			global $post;
			if ( ! is_null( $post ) && strpos( $post->post_content, 'user_registration_my_account' ) !== false && is_user_logged_in() ) {
				$this->_is_myaccount = true;
			}

			$this->_is_myaccount = apply_filters( 'urcma_is_my_account_page', $this->_is_myaccount );
		}

		/**
		 * Redirect to default endpoint
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function redirect_to_default() {

			// exit if not my account.
			if ( ! $this->_is_myaccount || ! is_array( $this->_menu_endpoints ) ) {
				return;
			}

			$current_endpoint = urcma_get_current_endpoint();
			$url              = ur_get_page_permalink( 'myaccount' );

			if ( 'dashboard' === $current_endpoint && empty( $this->_menu_endpoints[ $current_endpoint ] ) ) {
				$slug = array_values( $this->_menu_endpoints )[0]['slug'];
				wp_safe_redirect( $url . '/' . $slug );
			} elseif ( empty( $this->_menu_endpoints[ $current_endpoint ] ) ) {
				wp_safe_redirect( $url );
			}
			// if a specific endpoint is required return.
			if ( 'dashboard' != $current_endpoint || apply_filters( 'urcma_no_redirect_to_default', false ) ) {
				return;
			}
		}

		/**
		 * Output my-account shortcode
		 *
		 * @since 1.0.0
		 */
		public function my_account_menu() {

			$args = apply_filters(
				'urcma-myaccount-menu-template-args',
				array(
					'endpoints'      => $this->_menu_endpoints,
					'my_account_url' => get_permalink( ur_get_page_id( 'myaccount' ) ),
				)
			);

			ob_start();

			ur_get_template( 'urcma-myaccount-menu.php', $args, '', URCMA_DIR . 'templates/' );

			return ob_get_clean();

		}

		/**
		 * Print default dashboard content
		 *
		 * @since 1.0.0
		 */
		public function print_default_dashboard_content() {

			$content       = '';
			$template_name = 'myaccount/dashboard.php';
			$template      = apply_filters( 'urcma_dashboard_shortcode_template', $template_name );

			ob_start();
			ur_get_template(
				$template,
				array(
					'current_user' => get_user_by( 'id', get_current_user_id() ),
				)
			);
			$content = ob_get_clean();

			return $content;
		}

		/**
		 * Save an option to check if the page is myaccount
		 *
		 * @since 1.0.0
		 */
		public function save_is_my_account() {
			update_option( 'urcma_is_my_account', $this->_is_myaccount );
		}

		/**
		 * Retrieve the complete list of endpoints
		 *
		 * @return string
		 */
		public function get_menu_endpoints() {
			return $this->_menu_endpoints;
		}

	}
}
