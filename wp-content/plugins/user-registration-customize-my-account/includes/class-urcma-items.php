<?php
/**
 * Plugin menu items class
 *
 * @package User Registration Customize My Account
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'URCMA_Items' ) ) {
	/**
	 * Items class.
	 * The class manage all plugin endpoints items.
	 *
	 * @since 1.0.0
	 */
	class URCMA_Items {

		/**
		 * Items array
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private $_items = array();

		/**
		 * Default items array
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private $_default_items = array();

		/**
		 * Plugin items array
		 *
		 * @var array
		 * @since 1.0.0
		 */
		private $_plugin_items = array();

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {}

		/**
		 * Get items method
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function get_items() {
			return apply_filters( 'urcma_get_endpoints', $this->_items );
		}

		/**
		 * Get default items method
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function get_default_items() {
			return apply_filters( 'urcma_get_default_items', $this->_default_items );
		}

		/**
		 * Get plugin items method
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function get_plugin_items() {
			return apply_filters( 'urcma_get_plugin_items', $this->_plugin_items );
		}

		/**
		 * Init default items
		 *
		 * @since 1.0.0
		 */
		protected function init_default_items() {

			$endpoints_slugs = array(
				'edit-password'    => get_option( 'user_registration_myaccount_change_password_endpoint', 'edit-password' ),
				'edit-profile'     => get_option( 'user_registration_myaccount_edit_profile_endpoint', 'edit-profile' ),
				'ur-lost-password' => get_option( 'user_registration_myaccount_lost_password_endpoint', 'lost-password' ),
				'user-logout'      => get_option( 'user_registration_logout_endpoint', 'user-logout' ),
			);

			$endpoints = array(
				'dashboard'     => __( 'Dashboard', 'user-registration-customize-my-account' ),
				'edit-profile'  => __( 'Edit Profile', 'user-registration-customize-my-account' ),
				'edit-password' => __( 'Edit Password', 'user-registration-customize-my-account' ),
				'user-logout'   => __( 'User Logout', 'user-registration-customize-my-account' ),
			);

			$menu_items_endpoint = apply_filters( 'user_registration_account_menu_items', $endpoints, $endpoints_slugs );

			! is_array( $menu_items_endpoint ) && $menu_items_endpoint = array();
			$endpoints = array_merge( $endpoints, $menu_items_endpoint );

			$registered_endpoint  = UR()->query->get_query_vars();
			$this->_default_items = array();

			// populate endpoints array with options.
			foreach ( $endpoints as $endpoint_key => $endpoint_label ) {

				// always exclude endpoint not in menu if are not ur default.
				if ( ( 'dashboard' != $endpoint_key && ! array_key_exists( $endpoint_key, $registered_endpoint ) ) ) {
					continue;
				}

				$slug    = isset( $registered_endpoint[ $endpoint_key ] ) ? $registered_endpoint[ $endpoint_key ] : $endpoint_key;
				$options = urcma_get_default_endpoint_options( $slug );
				// set label.
				$options['label'] = $endpoint_label;

				switch ( $endpoint_key ) {
					case 'dashboard':
						$options['icon'] = 'tachometer';
						break;
					case 'edit-profile':
						$options['icon'] = 'user';
						break;
					case 'edit-password':
						$options['icon'] = 'user-secret';
						break;
					case 'user-logout':
						$options['icon'] = 'sign-out';
						break;
					default:
						break;
				}

				$this->_default_items[ $endpoint_key ] = $options;
			}
		}

		/**
		 * Maybe init default items
		 *
		 * @since 1.0.0
		 */
		protected function maybe_init_default_items() {
			empty( $this->_default_items ) && $this->init_default_items();
		}

		/**
		 * Init Plugin items
		 *
		 * @since 1.0.0
		 */
		protected function init_plugin_items() {
			$endpoints = array();

			if ( function_exists( 'URWC' ) ) {
				$endpoints = array(
					'orders'       => array(
						'slug'    => 'orders',
						'active'  => true,
						'label'   => __( 'Orders', 'user-registration-customize-my-account' ),
						'icon'    => 'first-order',
						'content' => '',
					),
					'downloads'    => array(
						'slug'    => 'downloads',
						'active'  => true,
						'label'   => __( 'Downloads', 'user-registration-customize-my-account' ),
						'icon'    => 'download',
						'content' => '',
					),
					'edit-address' => array(
						'slug'    => 'edit-address',
						'active'  => true,
						'label'   => __( 'Edit Address', 'user-registration-customize-my-account' ),
						'icon'    => 'location-arrow',
						'content' => '',
					),
				);

				/**
				 * Added woocommerce subscription support
				 *
				 * @since 1.0.1
				 */
				if ( class_exists( 'WC_Subscription' ) && class_exists( 'URWC_WC_Subscriptions' ) ) {
					$endpoints['subscriptions'] = array(
						'slug'    => get_option( 'woocommerce_myaccount_subscriptions_endpoint', 'subscriptions' ),
						'active'  => true,
						'label'   => __( 'Subscriptions', 'user-registration-customize-my-account' ),
						'icon'    => 'shopping-cart',
						'content' => '',
					);
				}

				/**
				 * Added woocommerce membership support
				 *
				 * @since 1.0.1
				 */
				if ( class_exists( 'URWC_WC_Memberships' ) && class_exists( 'WC_Memberships' ) ) {
					$endpoints['membership'] = array(
						'slug'    => get_option( 'woocommerce_myaccount_members_area_endpoint', 'members-area' ),
						'active'  => true,
						'label'   => __( 'Membership', 'user-registration-customize-my-account' ),
						'icon'    => 'users',
						'content' => '',
					);
				}
			}

			if ( class_exists( 'User_Registration_Learndash' ) && class_exists( 'SFWD_LMS' ) ) {
				$endpoints['learndash'] = array(
					'slug'    => 'learndash',
					'active'  => true,
					'label'   => __( 'Learndash', 'user-registration-customize-my-account' ),
					'icon'    => 'book',
					'content' => '',
				);
			}

			/**
			 * Added User Registration Payments support
			 *
			 * @since 1.0.1
			 */
			if ( class_exists( 'User_Registration_Payments' ) ) {
				$endpoints['payment'] = array(
					'slug'    => 'payment',
					'active'  => true,
					'label'   => __( 'Payment Details', 'user-registration-customize-my-account' ),
					'icon'    => 'money',
					'content' => '',
				);
			}

			/**
			 * Added User Registration Extras delete account feature support
			 *
			 * @since 1.1.0
			 */
			if ( class_exists( 'User_Registration_Extras' ) ) {
				$delete_account_option = get_option( 'user_registration_extras_general_setting_delete_account', 'disable' );

				// Check if delete account option is disabled.
				if ( 'disable' !== $delete_account_option ) {
					$endpoints['delete-account'] = array(
						'slug'    => 'delete-account',
						'active'  => true,
						'label'   => __( 'Delete Account', 'user-registration-customize-my-account' ),
						'icon'    => 'trash-o',
						'content' => '',
					);
				} else {
					if ( isset( $endpoints['delete-account'] ) ) {
						unset( $endpoints['delete-account'] );
					}
				}
			}

			$this->_plugin_items = $endpoints;
		}

		/**
		 * Maybe init default items
		 *
		 * @since 1.0.0
		 */
		protected function maybe_init_plugin_items() {
			empty( $this->_plugin_items ) && $this->init_plugin_items();
		}

		/**
		 * Get items slug
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function get_items_slug() {
			$slugs = array();
			foreach ( $this->get_items() as $key => $field ) {
				isset( $field['slug'] ) && $slugs[ $key ] = $field['slug'];
				if ( isset( $field['children'] ) ) {
					foreach ( $field['children'] as $child_key => $child ) {
						isset( $child['slug'] ) && $slugs[ $child_key ] = $child['slug'];
					}
				}
			}

			return $slugs;
		}

		/**
		 * Get items keys
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function get_items_keys() {
			$keys = array();
			foreach ( $this->get_items() as $items_key => $item ) {
				$keys[] = $items_key;
				if ( isset( $item['children'] ) ) {
					foreach ( $item['children'] as $child_key => $child ) {
						$keys[] = $child_key;
					}
				}
			}

			return $keys;
		}

		/**
		 * Init items
		 *
		 * @since 1.0.0
		 */
		public function init() {

			// get saved endpoints order.
			$fields = get_option( 'urcma_endpoint', '' );
			$fields = json_decode( $fields, true );

			// set empty array is false or null.
			( ! $fields || is_null( $fields ) ) && $fields = array();

			$this->_items = array();

			// get default endpoints.
			$this->maybe_init_default_items();
			$this->maybe_init_plugin_items();

			$defaults = array_merge( $this->_default_items, $this->_plugin_items );

			if ( empty( $fields ) ) {
				$this->_items = $defaults;
			} else {

				foreach ( $fields as $id => $field_option ) {

					// build return array.
					$this->_items[ $id ] = array();

					$options = get_option( 'urcma_endpoint_' . $id, array() );

					empty( $field_option['type'] ) && $field_option['type'] = 'endpoint';
					$options_default                                        = call_user_func( "urcma_get_default_{$field_option['type']}_options", $id );

					// is empty check on default endpoint.
					( empty( $options ) && isset( $defaults[ $id ] ) ) && $options = $defaults[ $id ];
					// always merge with default.
					$options = array_merge( $options_default, $options );

					// unset on defaults.
					unset( $defaults[ $id ] );

					$this->_items[ $id ] = $options;
				}

				// merge with defaults again.
				$this->_items = array_merge( $this->_items, $defaults );
			}
		}
	}
}
