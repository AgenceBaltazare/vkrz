<?php
/**
 * Plugins Functions and Hooks
 *
 * @package User Registration Extras
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

add_action( 'user_registration_validate_email_whitelist', 'user_registration_extras_validate_email', 10, 2 );

if ( ! function_exists( 'user_registration_extras_validate_email' ) ) {

	/**
	 * Validate user entered email against whitelisted email domain
	 *
	 * @since 1.0.0
	 * @param email                                           $user_email email entered by user.
	 * @param $filter_hook Filter for validation error message.
	 */
	function user_registration_extras_validate_email( $user_email, $filter_hook ) {
		$option = get_option( 'user_registration_extras_domain_restriction_settings', '' );

		if ( ! empty( $option ) ) {
			$whitelist = array_map( 'trim', explode( PHP_EOL, $option ) );
			$email     = explode( '@', $user_email );

			if ( ! in_array( $email[1], $whitelist ) ) {

				$blacklisted_email = $email[1];
				$message           = sprintf( __( 'The email domain %s is restricted. Please try another email address.', 'user-registration-extras' ), $blacklisted_email );
				if ( '' !== $filter_hook ) {
					add_filter(
						$filter_hook,
						function ( $msg ) use ( $message ) {
							return $message;
						}
					);
				} else {
					// Check if ajax fom submission on edit profile is on.
					if ( 'yes' === get_option( 'user_registration_ajax_form_submission_on_edit_profile', 'no' ) ) {
						wp_send_json_error(
							array(
								'message' => $message,
							)
						);
					} else {
						ur_add_notice( $message, 'error' );
					}
				}
			}
		}
	}

	/**
	 * Handles all settings action.
	 *
	 * @return void.
	 */
	function user_registration_extras_popup_settings_handler() {

		if ( ! empty( $_POST ) ) {

			// Nonce Check.
			if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'user-registration-settings' ) ) {
				die( __( 'Action failed. Please refresh the page and retry.', 'user-registration-extras' ) );
			}

			// Update the popups for add new functionality
			if ( ( isset( $_POST['user_registration_extras_popup_title'] ) && ! empty( $_POST['user_registration_extras_popup_title'] ) ) || ( isset( $_REQUEST['edit-popup'] ) && ! empty( $_REQUEST['edit-popup'] ) ) ) {
				$active       = isset( $_POST['user_registration_extras_enable_popup'] ) ? $_POST['user_registration_extras_enable_popup'] : '';
				$popup_type   = isset( $_POST['user_registration_extras_popup_type'] ) ? $_POST['user_registration_extras_popup_type'] : '';
				$popup_title  = isset( $_POST['user_registration_extras_popup_title'] ) ? $_POST['user_registration_extras_popup_title'] : '';
				$popup_header = isset( $_POST['user_registration_extras_popup_header_content'] ) ? $_POST['user_registration_extras_popup_header_content'] : '';
				$form         = isset( $_POST['user_registration_extras_popup_registration_form'] ) ? $_POST['user_registration_extras_popup_registration_form'] : '';
				$popup_footer = isset( $_POST['user_registration_extras_popup_footer_content'] ) ? $_POST['user_registration_extras_popup_footer_content'] : '';
				$popup_size   = isset( $_POST['user_registration_extras_popup_size'] ) ? $_POST['user_registration_extras_popup_size'] : 'default';

				$post_data = array(
					'popup_type'   => $popup_type,
					'popup_title'  => $popup_title,
					'popup_status' => $active,
					'popup_header' => $popup_header,
					'popup_footer' => $popup_footer,
					'popup_size'   => $popup_size,
				);

				if ( 'registration' === $popup_type ) {
					$post_data['form'] = $form;
				}

				$post_data = array(
					'post_type'      => 'ur_extras_popup',
					'post_title'     => ur_clean( $popup_title ),
					'post_content'   => wp_json_encode( $post_data, JSON_UNESCAPED_UNICODE ),
					'post_status'    => 'publish',
					'comment_status' => 'closed',   // if you prefer
					'ping_status'    => 'closed',      // if you prefer
				);

				if ( isset( $_REQUEST['edit-popup'] ) ) {
					$post_data['ID'] = $_REQUEST['edit-popup'];
					$post_id         = wp_update_post( wp_slash( $post_data ), true );
				} else {
					$post_id = wp_insert_post( wp_slash( $post_data ), true );
				}
				return true;
			}
		}

	}
}

add_filter( 'user_registration_add_form_field_data', 'user_registration_form_honeypot_field_filter', 10, 2 );

if ( ! function_exists( 'user_registration_form_honeypot_field_filter' ) ) {
	/**
	 * Add honeypot field data to form data.
	 *
	 * @since 1.0.0
	 * @param array $form_data_array Form data parsed form form's post content.
	 * @param int   $form_id ID of the form.
	 */

	function user_registration_form_honeypot_field_filter( $form_data_array, $form_id ) {
		$activated_form_list = get_option( 'user_registration_extras_spam_protection_by_honeypot_enabled_forms', array() );

		if ( in_array( $form_id, $activated_form_list ) ) {
			$honeypot = (object) array(
				'field_key'       => 'honeypot',
				'general_setting' => (object) array(
					'label'       => 'Honeypot',
					'description' => '',
					'field_name'  => 'honeypot',
					'placeholder' => '',
					'required'    => 'no',
					'hide_label'  => 'no',
				),
			);
			array_push( $form_data_array, $honeypot );
		}
		return $form_data_array;
	}
}

add_action( 'user_registration_validate_honeypot_container', 'user_registration_validate_honeypot_container', 10, 4 );

if ( ! function_exists( 'user_registration_validate_honeypot_container' ) ) {

	/**
	 * Validate user honeypot to check if the field is filled with spams.
	 *
	 * @since 1.0.0
	 * @param object $data Data entered by the user.
	 * @param array  $filter_hook Filter for validation error message.
	 * @param int    $form_id ID of the form.
	 * @param array  $form_data_array All fields form data entered by user.
	 */
	function user_registration_validate_honeypot_container( $data, $filter_hook, $form_id, $form_data_array ) {
		$value = isset( $data->value ) ? $data->value : '';

		if ( '' !== $value ) {

			$form_data = array();

			foreach ( $form_data_array as $single_field_data ) {
					$form_data[ $single_field_data->field_name ] = $single_field_data->value;
			}

			// Log the spam entry.
			$logger = ur_get_logger();
			$logger->notice( sprintf( 'Spam entry for Form ID %d Response: %s', absint( $form_id ), print_r( $form_data, true ) ), array( 'source' => 'honeypot' ) );

			add_filter(
				$filter_hook,
				function ( $msg ) {
					return esc_html__( 'Registration Error. Your Registration has been blocked by Spam Protection.', 'user-registration-extras' );
				}
			);
		}
	}
}

if ( ! function_exists( 'user_registration_extras_dasboard_card' ) ) {

	/**
	 * User Registration dashboard card.
	 *
	 * @since 1.0.0
	 */
	function user_registration_extras_dasboard_card( $title, $body_class, $body ) {
		$card  = '';
		$card .= '<div class="user-registration-card ur-mb-6">';

		if ( '' !== $title ) {
			$card .= '<div class="user-registration-card__header">';
			$card .= '<h3 class="user-registration-card__title">' . esc_html( $title ) . '</h3>';
			$card .= '</div>';
		}

		$card .= '<div class="user-registration-card__body ' . esc_attr( $body_class ) . '">' . $body . '</div>';
		$card .= '</div>';

		return $card;
	}
}

if ( ! function_exists( 'user_registration_extras_approval_status_registration_overview_report' ) ) {

	/**
	 * Builds User Status card template based on form selected.
	 *
	 * @param int    $form_id ID of selected form.
	 * @param array  $overview Array of user datas at different settings.
	 * @param string $label Label for status card.
	 * @param string $approval_status Specific approval status for specific status cards .
	 * @param string $link_text View lists of specific approval status link text.
	 */
	function user_registration_extras_approval_status_registration_overview_report( $form_id, $overview, $label, $approval_status, $link_text ) {
		$ur_specific_form_user = '&ur_user_approval_status=' . $approval_status;

		if ( 'all' !== $form_id ) {
			$ur_specific_form_user .= '&ur_specific_form_user=' . $form_id;
		}

		$admin_url = admin_url( '', 'admin' ) . 'users.php?s&action=-1&new_role' . $ur_specific_form_user . '&ur_user_filter_action=Filter&paged=1&action2=-1&new_role2&ur_user_approval_status2&ur_specific_form_user2';
		$status_registration_overview_card  = '';
		$status_registration_overview_card .= '<div class="ur-col-lg-3 ur-col-md-6">';

		$body  = '';
		$body .= '<div class="ur-row ur-align-items-center">';
		$body .= '<div class="ur-col">';

		$body .= '<h4 class="ur-text-muted ur-mt-0">' . esc_html__( $label, 'user-registration-extras' ) . '</h4>';
		$body .= '<span class="ur-h2 ur-mr-1">' . esc_html( $overview ) . '</span>';
		$body .= '</div>';
		$body .= '<div class="ur-col-auto">';
		$body .= '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="23" y1="11" x2="17" y2="11"></line></svg>';
		$body .= '</div>';
		$body .= '<div class="ur-col-12">';
		$body .= '<a class="ur-d-flex ur-mb-0 ur-mt-2" href="' . esc_url( $admin_url ) . ' ">' . esc_html( $link_text ) . '</a>';
		$body .= '</div>';
		$body .= '</div>';

		$status_registration_overview_card .= user_registration_extras_dasboard_card( '', '', $body );

		$status_registration_overview_card .= '</div>';

		return $status_registration_overview_card;

	}
}
