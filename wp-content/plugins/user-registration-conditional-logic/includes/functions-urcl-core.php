<?php
/**
 * UserRegistrationConditionalLogic Functions.
 *
 * General core functions available on both the front-end and admin.
 *
 * @author   WPEverest
 * @category Core
 * @package  UserRegistrationConditionalLogic/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check whether plugin compatiple.
 *
 * @return string
 */
function urcl_is_compatible() {

	$plugins_path = WP_PLUGIN_DIR . URCL_DS . 'user-registration' . URCL_DS . 'user-registration.php';

	if ( ! file_exists( $plugins_path ) ) {

		return __( 'Please install <code>user-registration</code> plugin to use <code>user-registration-conditional-logic</code> addon.', 'user-registration-conditional-logic' );
	}
	$plugin_file_path = 'user-registration/user-registration.php';

	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( ! is_plugin_active( $plugin_file_path ) ) {

		return __( 'Please activate <code>user-registration</code> plugin to use <code>user-registration-conditional-logic</code> addon.', 'user-registration-conditional-logic' );

	}
	if ( function_exists( 'UR' ) ) {

		$user_registration_version = UR()->version;

	} else {

		$user_registration_version = get_option( 'user_registration_version' );

	}

	if ( version_compare( $user_registration_version, '1.4.2', '<' ) ) {

		return __( 'Please update your <code>user-registration</code> plugin to at least version 1.4.2 to use <code>user-registration-conditional-logic</code> addon.', 'user-registration-conditional-logic' );

	}

	return 'YES';

}

/**
 * Check Plugin Compatibility.
 */
function urcl_check_plugin_compatibility() {

	add_action( 'admin_notices', 'user_registration_conditional_logic_admin_notice', 10 );

}

/**
 * Print Admin Notice.
 */
function user_registration_conditional_logic_admin_notice() {

	$class = 'notice notice-error';

	$message = urcl_is_compatible();

	if ( 'YES' !== $message ) {

		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}
}

/**
 * Deprecate plugin missing notice.
 *
 * @deprecated 1.2.4
 *
 * @return void
 */
function urcl_admin_notices() {
	ur_deprecated_function( 'urcl_admin_notices', '1.2.4', 'user_registration_conditional_logic_admin_notice' );
}

/**
 * Get form fields by form id
 *
 * @param int    $form_id Form ID.
 * @param string $selected_field_key Field Key.
 */
function get_conditional_fields_by_form_id( $form_id, $selected_field_key ) {
	$args          = array(
		'post_type'   => 'user_registration',
		'post_status' => 'publish',
		'post__in'    => array( $form_id ),
	);
		$post_data = get_posts( $args );
	// wrap all fields in array.
	$fields = array();
	if ( isset( $post_data[0]->post_content ) ) {
		$post_content_array = json_decode( $post_data[0]->post_content );

		if ( ! is_null( $post_content_array ) ) {
			foreach ( $post_content_array as $data ) {
				foreach ( $data as $single_data ) {
					foreach ( $single_data as $field_data ) {
						if ( isset( $field_data->general_setting->field_name )
							&& isset( $field_data->general_setting->label ) ) {

							$strip_fields = array(
								'section_title',
								'html',
								'wysiwyg',
								'billing_address_title',
								'shipping_address_title',
							);

							if ( in_array( $field_data->field_key, $strip_fields, true ) ) {
								continue;
							}

							$fields[ $field_data->general_setting->field_name ] = array(
								'label'     => $field_data->general_setting->label,
								'field_key' => $field_data->field_key,
							);
						}
					}
				}
			}
		}
	}
	// Unset selected meta key.
	unset( $fields[ $selected_field_key ] );
	return $fields;
}

/**
 * Get all fields data
 *
 * @param  int    $form_id    Form ID.
 * @param  string $field_name Field Name.
 * @return array    $field_data.
 */
function ur_get_field_data( $form_id, $field_name ) {
	$args      = array(
		'post_type'   => 'user_registration',
		'post_status' => 'publish',
		'post__in'    => array( $form_id ),
	);
	$post_data = get_posts( $args );

	if ( isset( $post_data[0]->post_content ) ) {
		$post_content_array = json_decode( $post_data[0]->post_content );

		foreach ( $post_content_array as $data ) {
			foreach ( $data as $single_data ) {
				foreach ( $single_data as $field_data ) {
					isset( $field_data->general_setting->field_name ) ? $field_data->general_setting->field_name : '';
					if ( $field_data->general_setting->field_name === $field_name ) {
							return $field_data;
					}
				}
			}
		}
	}
}

/**
 * Get Select and Checkbox Fields Choices
 *
 * @param int    $form_id Form ID.
 * @param string $field_name Field Name.
 * @return array $choices
 */
function get_checkbox_choices( $form_id, $field_name ) {

	$form_data = ur_get_field_data( $form_id, $field_name );
	/* Backward Compatibility. Modified since 1.5.7. To be removed later. */
		$advance_setting_choices = isset( $form_data->advance_setting->choices ) ? $form_data->advance_setting->choices : '';
		$advance_setting_options = isset( $form_data->advance_setting->options ) ? $form_data->advance_setting->options : '';
	/* Bacward Compatibility end.*/

	$choices = isset( $form_data->general_setting->options ) ? $form_data->general_setting->options : '';

	/* Backward Compatibility. Modified since 1.5.7. To be removed later. */
	if ( ! empty( $advance_setting_choices ) ) {
		$choices = explode( ',', $advance_setting_choices );
	} elseif ( ! empty( $advance_setting_options ) ) {
		$choices = explode( ',', $advance_setting_options );
		/* Backward Compatibility end. */

	} elseif ( 'country' === $form_data->field_key ) {
		$country = new UR_Form_Field_Country();
		$country->get_country();
		$choices = $country->get_country();
	}

	return $choices;
}

/**
 * Get label as array value and meta keys as array index.
 *
 * @param object $field_data Field Data.
 *
 * @return array $output
 */
function get_conditional_fields_meta_key( $field_data ) {

	$output = array();
	$output[ $field_data->general_setting->field_name ] = $field_data->general_setting->label;
	return $output;
}
