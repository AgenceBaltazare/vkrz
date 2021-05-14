<?php
/**
 * UserRegistration Customize My Account Settings class.
 *
 * @version  1.0.0
 * @package  UserRegistration/Admin
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'URCMA_Settings_Customize_My_Account' ) ) :

	/**
	 * URCMA_Settings_Customize_My_Account Setting
	 */
	class URCMA_Settings_Customize_My_Account extends UR_Settings_Page {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id    = 'user-registration-customize-my-account';
			$this->label = esc_html__( 'Customize My Account', 'user-registration-customize-my-account' );

			add_filter( 'user_registration_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
			add_action( 'user_registration_sections_' . $this->id, array( $this, 'output_sections' ) );
			add_action( 'user_registration_settings_' . $this->id, array( $this, 'output' ) );

		}

		/**
		 * Add this page to settings.
		 *
		 * @param  array $pages Array of settings pages.
		 * @return mixed
		 */
		public function add_settings_page( $pages ) {
			$pages[ $this->id ] = $this->label;

			return $pages;
		}

		/**
		 * Get sections.
		 *
		 * @return array
		 */
		public function get_sections() {
			$sections = array(
				''                 => __( 'Endpoint Settings', 'user-registration-customize-my-account' ),
				'advance-settings' => __( 'Advance Settings', 'user-registration-customize-my-account' ),
			);

			return apply_filters( 'user_registration_get_sections_' . $this->id, $sections );
		}

		/**
		 * Get General Settings.
		 *
		 * @return array.
		 */
		public function get_general_settings() {

			$settings = apply_filters(
				'user_registration_get_general_settings',
				array(

					array(
						'title' => __( 'Configure Endpoint Settings', 'user-registration-customize-my-account' ),
						'type'  => 'urcma_endpoints',
						'desc'  => '',
						'id'    => 'urcma_endpoint',
						'value' => '',
					),
				)
			);

			return apply_filters( 'user_registration_get_general_settings_' . $this->id, $settings );
		}

		/**
		 * Get Advance Settings.
		 *
		 * @since 1.1.0
		 * @return array.
		 */
		public function get_advance_settings() {

			$settings = apply_filters(
				'user_registration_get_general_settings',
				array(
					array(
						'title' => __( 'Advance Settings', 'user-registration-customize-my-account' ),
						'type'  => 'title',
						'desc'  => '',
						'id'    => 'user_registration_customize_my_account_advance_settings_section',
					),
					array(
						'title'    => __( 'Customize My Account Page', 'user-registration-customize-my-account' ),
						'desc'     => __( 'Make the my account page more elegant and unique. Customize the design styles for form wrapper, fields, texts, button and more.', 'user-registration-customize-my-account' ),
						'desc_tip' => __( 'Customize the design style for my account page.', 'user-registration-customize-my-account' ),
						'type'     => 'link',
						'id'       => 'urcma_advance_settings',
						'buttons'  => array(
							array(
								'title' => __( 'Customize My Account Page', 'user-registration-customize-my-account' ),
								'href'  => $this->urcma_get_customizer_url(),
								'class' => 'button-customize-login',
							),
						),
					),
					array(
						'type' => 'sectionend',
						'id'   => 'user_registration_customize_my_account_advance_settings_section',
					),
				)
			);

			return apply_filters( 'user_registration_get_general_settings_' . $this->id, $settings );
		}

		/**
		 * Outputs Customize My Account Page
		 *
		 * @return void
		 */
		public function output() {
			global $current_section;
			if ( '' === $current_section ) {
				$settings        = (object) $this->get_general_settings();
				$value           = urcma_update_fields();
				$settings->value = $value;
				UR_Admin_Settings::output_fields( (array) $settings );
			} else {
				$settings = (object) $this->get_advance_settings();
				UR_Admin_Settings::output_fields( (array) $settings );
			}
		}

		/**
		 * Get the login customizer url.
		 */
		private function urcma_get_customizer_url() {
			$customizer_url = esc_url_raw(
				add_query_arg(
					array(
						'urcma-customizer' => true,
						'return'           => rawurlencode(
							add_query_arg(
								array(
									'page'    => 'user-registration-settings',
									'tab'     => 'user-registration-customize-my-account',
									'section' => 'advance-settings',
								),
								admin_url( 'admin.php' )
							)
						),
						'url'              => ur_get_page_permalink( 'myaccount' ),
					),
					admin_url( 'customize.php' )
				)
			);

			return $customizer_url;
		}
	}
	endif;
return new URCMA_Settings_Customize_My_Account();
