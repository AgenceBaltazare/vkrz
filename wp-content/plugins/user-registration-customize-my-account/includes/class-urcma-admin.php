<?php
/**
 * Admin class
 *
 * User_Registration_Customize_My_Account Admin
 *
 * @package User_Registration_Customize_My_Account
 * @since  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'URCMA_Admin' ) ) {
	/**
	 * Admin class.
	 * The class manage all the admin behaviors.
	 *
	 * @since 1.0.0
	 */
	class URCMA_Admin {

		/**
		 * Plugin options
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $options = array();

		/**
		 * Add endpoint action
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $add_field_action = 'urcma_add_field';

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = URCMA_VERSION;

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_action( 'user_registration_admin_field_urcma_endpoints', array( $this, 'urcma_endpoints' ), 10, 1 );
			add_filter( 'user_registration_admin_settings_sanitize_option_urcma_endpoint', array( $this, 'urcma_update_fields' ), 10, 3 );

			// add endpoint ajax.
			add_action( 'wp_ajax_' . $this->add_field_action, array( $this, 'add_field_ajax' ) );
			add_action( 'wp_ajax_nopriv_' . $this->add_field_action, array( $this, 'add_field_ajax' ) );
		}

		/**
		 * Enqueue scripts
		 *
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {

			if ( isset( $_GET['page'] ) && 'user-registration-settings' === $_GET['page'] ) {

				$min = ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) ? '.min' : '';

				wp_register_style( 'urcma', URCMA_ASSETS_URL . '/css/urcma-admin.css' );
				wp_register_script( 'urcma', URCMA_ASSETS_URL . '/js/admin/urcma-admin' . $min . '.js', array( 'jquery', 'jquery-ui-dialog', 'sweetalert2' ), $this->version, true );
				// font awesome.
				wp_register_style( 'font-awesome', URCMA_ASSETS_URL . '/css/font-awesome.min.css', array(), $this->version );

				wp_enqueue_script( 'jquery-ui' );
				wp_enqueue_script( 'jquery-ui-sortable' );
				wp_enqueue_style( 'font-awesome' );
				wp_enqueue_style( 'urcma' );
				wp_enqueue_script( 'urcma' );

				wp_localize_script(
					'urcma',
					'urcma_params',
					array(
						'ajaxurl'                      => admin_url( 'admin-ajax.php' ),
						'action_add'                   => $this->add_field_action,
						'add_new_endpoint_title'       => __( 'Add new endpoint.', 'user-registration-customize-my-account' ),
						'add_endpoint_success_message' => __( 'Endpoint Added Successfully', 'user-registration-customize-my-account' ),
						'same_slug_error_message'      => __( 'Cannot have same slug for two endpoints', 'user-registration-customize-my-account' ),
						'same_label_error_message'     => __( 'Cannot have same label for two endpoints', 'user-registration-customize-my-account' ),
						'enable_endpoint'              => __( 'Enabled', 'user-registration-customize-my-account' ),
						'disable_endpoint'             => __( 'Disabled', 'user-registration-customize-my-account' ),
						'checked'                      => '<i class="fa fa-check"></i>',
						'error_icon'                   => '<i class="fa fa-times"></i>',
						'remove_alert'                 => __( 'Are you sure that you want to delete this endpoint?', 'user-registration-customize-my-account' ),
					)
				);
			}
		}

		/**
		 * Create new User Registration admin field
		 *
		 * @param array $option Retrieves a list of options applicable to the endpoint.
		 * @return void
		 * @since 1.0.0
		 */
		public function urcma_endpoints( $option ) {

			URCMA()->items->init();

			// get endpoints.
			$args = apply_filters(
				'urcma_admin_endpoints_template',
				array(
					'option'    => $option,
					'value'     => json_decode( get_option( $option['id'], '' ), true ),
					'endpoints' => URCMA()->items->get_items(),
				)
			);

			if ( ! function_exists( 'URWC' ) ) {
				foreach ( $args['endpoints'] as $key => $endpoint ) {
					if ( in_array( $key, array( 'orders', 'downloads', 'edit-address' ) ) ) {
						unset( $args['value'][ $key ] );
						unset( $args['endpoints'][ $key ] );
					}
				}
			}

			if ( ! class_exists( 'User_Registration_Learndash' ) || ! class_exists( 'SFWD_LMS' ) ) {
				foreach ( $args['endpoints'] as $key => $endpoint ) {
					if ( in_array( $key, array( 'learndash' ) ) ) {
						unset( $args['value'][ $key ] );
						unset( $args['endpoints'][ $key ] );
					}
				}
			}

			/**
			 * Added User Registration Payments support
			 *
			 * @since 1.0.1
			 */
			if ( ! class_exists( 'User_Registration_Payments' ) ) {
				foreach ( $args['endpoints'] as $key => $endpoint ) {

					if ( in_array( $key, array( 'payment' ) ) ) {
						unset( $args['value'][ $key ] );
						unset( $args['endpoints'][ $key ] );
					}
				}
			}

			/**
			 * Added woocommerce subscription support
			 *
			 * @since 1.0.1
			 */
			if ( ! class_exists( 'WC_Subscription' ) && ! class_exists( 'URWC_WC_Subscriptions' ) ) {
				foreach ( $args['endpoints'] as $key => $endpoint ) {

					if ( in_array( $key, array( 'subscriptions' ) ) ) {
						unset( $args['value'][ $key ] );
						unset( $args['endpoints'][ $key ] );
					}
				}
			}

			/**
			 * Added woocommerce membership support
			 *
			 * @since 1.0.1
			 */
			if ( ! class_exists( 'URWC_WC_Memberships' ) && ! class_exists( 'WC_Memberships' ) ) {
				foreach ( $args['endpoints'] as $key => $endpoint ) {

					if ( in_array( $key, array( 'membership' ) ) ) {
						unset( $args['value'][ $key ] );
						unset( $args['endpoints'][ $key ] );
					}
				}
			}

			/**
			 * Added User Registration Extras delete account feature support
			 *
			 * @since 1.1.0
			 */
			$delete_account_option = get_option( 'user_registration_extras_general_setting_delete_account', 'disable' );
			if ( ! class_exists( 'User_Registration_Extras' ) ) {

				foreach ( $args['endpoints'] as $key => $endpoint ) {

					if ( in_array( $key, array( 'delete-account' ) ) ) {
						unset( $args['value'][ $key ] );
						unset( $args['endpoints'][ $key ] );
					}
				}
			}
			// Check if delete account option is disabled.
			elseif ( 'disable' === $delete_account_option ) {
				foreach ( $args['endpoints'] as $key => $endpoint ) {

					if ( in_array( $key, array( 'delete-account' ) ) ) {
						unset( $args['value'][ $key ] );
						unset( $args['endpoints'][ $key ] );
					}
				}
			}

			extract( $args );
			include URCMA_TEMPLATE_PATH . '/admin/endpoints-list.php';

		}

		/**
		 * Add a new field using ajax
		 *
		 * @since 1.0.0
		 */
		public function add_field_ajax() {

			if ( ! ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == $this->add_field_action ) || ! isset( $_REQUEST['field_name'] ) || ! isset( $_REQUEST['target'] ) ) {
				die();

			}

			// check if is endpoint.
			$request = trim( $_REQUEST['target'] );
			// build field key.
			$field          = urcma_create_field_key( $_REQUEST['field_name'] );
			$endpoint_label = urcma_build_label( $field );

			$default_options_function = "urcma_get_default_{$request}_options";
			$admin_print_function     = "urcma_admin_print_{$request}_field";

			if ( ! $field || urcma_item_already_exists( $field )
				|| ! function_exists( $default_options_function ) || ! function_exists( $admin_print_function ) ) {
				wp_send_json(
					array(
						'error' => __( 'An error has occurred or this endpoint field already exists. Please try again.', 'user-registration-customize-my-account' ),
						'field' => false,
					)
				);
			}

			// build args array.
			$args = array(
				'endpoint'  => $field,
				'options'   => $default_options_function( $field ),
				'id'        => 'urcma_endpoint',
				'icon_list' => urcma_get_icon_list(),
				'usr_roles' => urcma_get_editable_roles(),
			);

			ob_start();
			$admin_print_function( $args );
			$html = ob_get_clean();

			wp_send_json(
				array(
					'html'           => $html,
					'field'          => $field,
					'endpoint_label' => $endpoint_label,
					'type'           => $request,
				)
			);
		}

	}
}
