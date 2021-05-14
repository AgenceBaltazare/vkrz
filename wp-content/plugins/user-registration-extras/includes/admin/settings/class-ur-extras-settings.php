<?php
/**
 * UserRegistration Extras Settings class.
 *
 * @version  1.0.0
 * @package  UserRegistration/Admin
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'User_Registration_Extras_Settings' ) ) :

	/**
	 * User_Registration_Extras_Settings Setting
	 */
	class User_Registration_Extras_Settings extends UR_Settings_Page {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id    = 'user-registration-extras';
			$this->label = esc_html__( 'Extras', 'user-registration-extras' );

			add_filter( 'user_registration_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
			add_action( 'user_registration_sections_' . $this->id, array( $this, 'output_sections' ) );
			add_action( 'user_registration_settings_' . $this->id, array( $this, 'output' ) );
			add_action( 'user_registration_settings_save_' . $this->id, array( $this, 'save' ) );
			add_filter( 'wp_editor_settings', array( $this, 'user_registration_extras_editor_settings' ) );
			add_filter( 'show_user_registration_setting_message', array( $this, 'filter_notice' ) );
			add_filter( 'user-registration-setting-save-label', array( $this, 'filter_label' ) );
		}

		/**
		 * Add this page to settings.
		 *
		 * @param  array $pages Pages.
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
				''       => __( 'General', 'user-registration-extras' ),
				'popups' => __( 'Popups', 'user-registration-extras' ),
			);

			return apply_filters( 'user_registration_get_sections_' . $this->id, $sections );
		}

		/**
		 * Change tinymce editor settings.
		 *
		 * @param  array $settings All settings.
		 * @return mixed
		 */
		public function user_registration_extras_editor_settings( $settings ) {

			// Check if the tab is of user registration extras addon and handle text editor separately.
			if ( isset( $_GET['tab'] ) && 'user-registration-extras' === $_GET['tab'] ) {
				$settings['media_buttons'] = false;
				$settings['textarea_rows'] = 4;
			}
			return $settings;
		}

		/**
		 * Get General Settings.
		 *
		 * @return array.
		 */
		public function get_general_settings() {

			$all_forms = ur_get_all_user_registration_form();
			$settings  = apply_filters(
				'user_registration_get_general_settings',
				array(

					array(
						'title' => __( 'Extras Registration Settings', 'user-registration-extras' ),
						'type'  => 'title',
						'desc'  => '',
						'id'    => 'user_registration_extras_general_setting_restrict_domain',
					),
					array(
						'title'       => __( 'Whitelisted Domains', 'user-registration-extras' ),
						'desc'        => __( 'This option lets you limit from which email domains you are willing to accept registration.', 'user-registration-extras' ),
						'id'          => 'user_registration_extras_domain_restriction_settings',
						'placeholder' => 'for eg. gmail.com',
						'default'     => '',
						'type'        => 'textarea',
						'css'         => 'min-width: 350px; min-height: 100px;',
						'desc_tip'    => true,
					),
					array(
						'title'    => __( 'Activate Spam Protection By Honeypot', 'user-registration-extras' ),
						'desc'     => __( 'Select forms where you want to enable this feature.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_spam_protection_by_honeypot_enabled_forms',
						'default'  => array_values( $all_forms )[0],
						'type'     => 'multiselect',
						'class'    => 'ur-enhanced-select',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
						'options'  => $all_forms,
					),
					array(
						'type' => 'sectionend',
						'id'   => 'user_registration_extras_general_setting_restrict_domain',
					),
					array(
						'title' => __( 'Auto Generated Password', 'user-registration-extras' ),
						'type'  => 'title',
						'desc'  => '',
						'id'    => 'user_registration_extras_general_setting_auto_generated_password',
					),
					array(
						'title'    => __( 'Activate Auto Generated Password On', 'user-registration-extras' ),
						'desc'     => __( 'Select forms where you want to enable this feature.', 'user-registration-extras' ),
						'id'       => 'user_registration_auto_password_activated_forms',
						'default'  => array_values( $all_forms )[0],
						'type'     => 'multiselect',
						'class'    => 'ur-enhanced-select',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
						'options'  => $all_forms,
					),
					array(
						'title'    => __( 'Password Length', 'user-registration-extras' ),
						'desc'     => __( 'The length of password you want to generate.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_auto_generated_password_length',
						'type'     => 'number',
						'default'  => 10,
						'desc_tip' => true,
					),
					array(
						'type' => 'sectionend',
						'id'   => 'user_registration_extras_general_setting_auto_generated_password',
					),
					array(
						'title' => __( 'Delete Account Settings', 'user-registration-extras' ),
						'type'  => 'title',
						'desc'  => '',
						'id'    => 'user_registration_extras_general_delete_account_settings',
					),
					array(
						'title'    => __( 'Delete Account Action ', 'user-registration' ),
						'desc'     => __( 'This option lets you choose option that user can delete thier account or not and need to prompt password popup or not.', 'user-registration' ),
						'id'       => 'user_registration_extras_general_setting_delete_account',
						'default'  => 'disable',
						'type'     => 'select',
						'class'    => 'ur-enhanced-select',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
						'options'  => array(
							'disable'         => __( 'Disable', 'user-registration-extras' ),
							'direct_delete'   => __( 'Direct Delete', 'user-registration-extras' ),
							'prompt_password' => __( 'Prompt password popup before delete account.', 'user-registration-extras' ),
						),
					),
					array(
						'type' => 'sectionend',
						'id'   => 'user_registration_extras_general_delete_account_settings',
					),
				)
			);

			return apply_filters( 'user_registration_get_general_settings_' . $this->id, $settings );
		}

		/**
		 * Get Add New Popup Settings.
		 *
		 * @return array.
		 */
		public function get_add_new_popup_settings() {
			$all_forms = ur_get_all_user_registration_form();

			$popup_id = isset( $_REQUEST['edit-popup'] ) ? $_REQUEST['edit-popup'] : '';

			$args   = array(
				'post_type'   => 'ur_extras_popup',
				'post_status' => array( 'publish', 'trash' ),
			);
			$popups = new WP_Query( $args );

			foreach ( $popups->posts as  $item ) {

				if ( $popup_id == $item->ID ) {
					$popup_content = json_decode( $item->post_content );
				}
			}

			$popup_type = array(
				'registration' => 'Registration',
				'login'        => 'Login',
			);

			if ( isset( $popup_content ) ) {
				echo '<h1 class="wp-heading-inline">' . sprintf( __( '%s', 'user-registration-extras' ), ucfirst( $popup_content->popup_title ) ) . '</h1>';
			} else {
				echo '<h1 class="wp-heading-inline">' . __( 'Add new Popup', 'user-registration-extras' ) . '</h1>';
			}

			echo '<a href="' . esc_url( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups' ) ) . '" class="page-title-action">' . __( 'Back to all Popups', 'user-registration-extras' ) . '</a>';
			echo '<hr class="wp-header-end">';
			echo '<br class="clear">';

			$settings = apply_filters(
				'user_registration_get_add_new_popup_settings',
				array(
					array(
						'card_title' => __( 'Display Popup', 'user-registration-extras' ),
						'type'       => 'cardheader',
						'desc'       => '',
						'id'         => 'edit_popup_display_settings',
					),
					array(
						'title'    => __( 'Enable this popup', 'user-registration-extras' ),
						'desc'     => __( 'Enable', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_enable_popup',
						'type'     => 'checkbox',
						'desc_tip' => __( 'Check to enable popup.', 'user-registration-extras' ),
						'css'      => 'min-width: 350px;',
						'default'  => isset( $popup_content ) && 1 == $popup_content->popup_status ? 'yes' : 'no',
					),
					array(
						'title'    => __( 'Select popup type', 'user-registration-extras' ),
						'desc'     => __( 'Select either the popup is registration or login type.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_popup_type',
						'type'     => 'select',
						'class'    => 'ur-enhanced-select user-registration-extras-select-popup-type',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
						'options'  => $popup_type,
						'default'  => isset( $popup_content ) ? $popup_content->popup_type : array_values( $popup_type )[0],
					),
					array(
						'type' => 'cardend',
						'id'   => 'edit_popup_display_settings',
					),
					array(
						'card_title' => __( 'Popup Content', 'user-registration-extras' ),
						'type'       => 'cardheader',
						'desc'       => '',
						'id'         => 'edit_popup_content',
					),
					array(
						'title'    => __( 'Popup Name', 'user-registration-extras' ),
						'desc'     => __( 'Enter the title of popup.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_popup_title',
						'type'     => 'text',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
						'default'  => isset( $popup_content ) ? $popup_content->popup_title : '',
					),
					array(
						'title'    => __( 'Popup Header Content', 'user-registration-extras' ),
						'desc'     => __( 'Here you can put header content.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_popup_header_content',
						'type'     => 'tinymce',
						'default'  => isset( $popup_content ) ? $popup_content->popup_header : '',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'title'     => __( 'Select form', 'user-registration-extras' ),
						'desc'      => __( 'Select which registration form to render in popup.', 'user-registration-extras' ),
						'id'        => 'user_registration_extras_popup_registration_form',
						'type'      => 'select',
						'row_class' => 'single-registration-select',
						'class'     => 'ur-enhanced-select user-registration-extras-select-registration-form',
						'css'       => 'min-width: 350px;',
						'desc_tip'  => true,
						'options'   => $all_forms,
						'default'   => isset( $popup_content->form ) ? $popup_content->form : array_values( $all_forms )[0],
					),
					array(
						'title'    => __( 'Popup Footer Content', 'user-registration-extras' ),
						'desc'     => __( 'Here you can put footer content.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_popup_footer_content',
						'type'     => 'tinymce',
						'default'  => isset( $popup_content ) ? $popup_content->popup_footer : '',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'type' => 'cardend',
						'id'   => 'edit_popup_content',
					),
					array(
						'card_title' => __( 'Popup Appearance', 'user-registration-extras' ),
						'type'       => 'cardheader',
						'desc'       => '',
						'id'         => 'edit_popup_appearance',
					),
					array(
						'title'    => __( 'Select Popup Size', 'user-registration-extras' ),
						'desc'     => __( 'Select which size of popup you want.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_popup_size',
						'type'     => 'select',
						'class'    => 'ur-enhanced-select',
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
						'options'  => array(
							'default'     => 'Default',
							'large'       => 'Large',
							'extra_large' => 'Extra Large',
						),
						'default'  => isset( $popup_content->popup_size ) ? $popup_content->popup_size : 'default',
					),
					array(
						'type' => 'cardend',
						'id'   => 'edit_popup_appearance',
					),
				)
			);

			return apply_filters( 'user_registration_get_add_new_code_settings_' . $this->id, $settings );
		}

		/**
		 * Output sections.
		 */
		public function output_sections() {
			global $current_section;

			$sections = $this->get_sections();

			if ( empty( $sections ) ) {
				return;
			}

			echo '<ul class="subsubsub">';

			$array_keys = array_keys( $sections );

			foreach ( $sections as $id => $label ) {
				if ( 'add-new-popup' === $current_section && 'popups' === $id ) {
					echo '<li><a href="' . admin_url( 'admin.php?page=user-registration-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) . '" class="current">' . $label . '</a> ' . ' </li>';
				} else {
					echo '<li><a href="' . admin_url( 'admin.php?page=user-registration-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ' </li>';
				}
			}
		}

		/**
		 * Outputs Extras Page
		 *
		 * @return void
		 */
		public function output() {
			global $current_section;

			switch ( $current_section ) {
				case '':
					$settings = (object) $this->get_general_settings();
					UR_Admin_Settings::output_fields( (array) $settings );
					break;
				case 'popups':
					global $user_registration_extras_popup_table_list;
					$GLOBALS['hide_save_button']               = true;
					$user_registration_extras_popup_table_list = new User_Registration_Extras_Popup_Table_List();

					// Add screen option.
					add_screen_option(
						'per_page',
						array(
							'default' => 20,
							'option'  => 'user_registration_extras_popups_per_page',
						)
					);
					if ( isset( $_REQUEST['success'] ) ) {
						if ( 'popup-created' === ( $_REQUEST['success'] ) ) {
							echo '<div id="message" class="inline updated"><p><strong>' . __( 'Popup successfully generated.', 'user-registration-extras' ) . '</strong></p></div>';
						} else {
							echo '<div id="message" class="inline updated"><p><strong>' . __( 'Popup successfully updated.', 'user-registration-extras' ) . '</strong></p></div>';
						}
					}
					echo '</form>';
					User_Registration_Extras_Admin::user_registration_extras_popup_list_table_output();
					break;
				case 'add-new-popup':
					$handle_action = user_registration_extras_popup_settings_handler();

					if ( $handle_action === true ) {

						if ( ! isset( $_REQUEST['edit-popup'] ) ) {
							$success = 'popup-created';
						} else {
							$success = 'popup-edited';
						}
						wp_redirect( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups&success=' . $success ) );
					}

					$settings = $this->get_add_new_popup_settings();
					UR_Admin_Settings::output_fields( $settings );

					return;
				break;
			}
		}

			/**
			 * Filter Notice for extras tab.
			 *
			 * @return bool
			 */
		public function filter_notice() {
			global $current_tab;

			if ( 'user-registration-extras' === $current_tab ) {
				return false;
			}

			return true;
		}

		/**
		 * Filter submit button label for certain tabs and sections.
		 *
		 * @param  string $label Label
		 * @return string        Label
		 */
		public function filter_label( $label ) {
			global $current_tab;
			global $current_section;

			if ( 'user-registration-extras' === $current_tab && 'add-new-popup' === $current_section ) {

				if ( ! isset( $_REQUEST['edit-popup'] ) ) {
					return __( 'Add Popup', 'user-registration-extras' );
				} else {
					return __( 'Update Popup', 'user-registration-extras' );
				}
			}

			return $label;
		}

			/**
			 * Save settings
			 */
		public function save() {

			global $current_section;

			// Check current section and handle save action accordingly.
			if ( '' === $current_section ) {
				$settings = $this->get_general_settings();
			} elseif ( 'add-new-popup' === $current_section ) {
				$settings = $this->get_add_new_popup_settings();
			}

			UR_Admin_Settings::save_fields( $settings );
		}
	}
	endif;
return new User_Registration_Extras_Settings();
