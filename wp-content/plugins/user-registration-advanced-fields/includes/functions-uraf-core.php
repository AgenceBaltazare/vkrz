<?php
/**
 * UserRegistrationAdvancedField Functions.
 *
 * General functions available on both the front-end and admin.
 *
 * @package UserRegistrationAdvancedField/Functions
 */

/**
 * Get advanced fields list.
 */
function user_registration_list_advanced_fields() {
		return apply_filters(
			'user_registration_advanced_fields',
			array(
				'section_title',
				'html',
				'timepicker',
				'phone',
				'wysiwyg',
				'select2',
				'multi_select2',
				'profile_picture',
				'range',
			)
		);
}

/**
 * Check advanced field compatibility
 */
function uraf_is_compatible() {

	$plugins_path = WP_PLUGIN_DIR . URAF_DS . 'user-registration' . URAF_DS . 'user-registration.php';

	if ( ! file_exists( $plugins_path ) ) {
		return __( 'Please install <code>user-registration</code> plugin to use <code>user-registration-advanced_fields</code> addon.', 'user-registration-advanced-fields' );
	}

	$plugin_file_path = 'user-registration/user-registration.php';

	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( ! is_plugin_active( $plugin_file_path ) ) {
		return __( 'Please activate <code>user-registration</code> plugin to use <code>user-registration-advanced_fields</code> addon.', 'user-registration-advanced-fields' );
	}

	if ( function_exists( 'UR' ) ) {
		$user_registration_version = UR()->version;
	} else {
		$user_registration_version = get_option( 'user_registration_version' );
	}

	if ( version_compare( $user_registration_version, '1.4.1', '<' ) ) {
		return __( 'Please update your <code>user registration</code> plugin to at least 1.4.1 version to use <code>user-registration-advanced-fields</code> addon.', 'user-registration-advanced-fields' );
	}

	return 'YES';

}

/**
 * Checks Plugin Compatibility.
 */
function uraf_check_plugin_compatibility() {
	add_action( 'admin_notices', 'user_registration_advanced_fields_admin_notice', 10 );
}

/**
 * Advanced Field Admin notices.
 */
function user_registration_advanced_fields_admin_notice() {

	$class   = 'notice notice-error';
	$message = uraf_is_compatible();

	if ( 'YES' !== $message ) {
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
}

add_filter( 'user_registration_field_keys', 'uraf_advanced_field_keys', 10, 2 );

/**
 * Deprecate plugin missing notice.
 *
 * @deprecated 1.3.5
 *
 * @return void
 */
function uraf_admin_notices() {
	ur_deprecated_function( 'uraf_admin_notices', '1.3.5', 'user_registration_advanced_fields_admin_notice' );
}

/**
 * Hook into core to render advanced fields
 *
 * @param  string $field_type Field Type.
 * @param  string $field_key Field Key.
 * @return string
 */
function uraf_advanced_field_keys( $field_type, $field_key ) {
	switch ( $field_key ) {
		case 'section_title':
			$field_type = 'section_title';
			break;
		case 'html':
			$field_type = 'html';
			break;
		case 'wysiwyg':
			$field_type = 'wysiwyg';
			break;
		case 'timepicker':
			$field_type = 'timepicker';
			break;
		case 'phone':
			$field_type = 'phone';
			break;
		case 'select2':
			$field_type = 'select2';
			break;
		case 'multi_select2':
			$field_type = 'multi_select2';
			break;
		case 'profile_picture':
			$field_type = 'profile_picture';
			break;
		case 'range':
			$field_type = 'range';
			break;
	}

	return $field_type;
}

/**
 * Get wp editor.
 *
 * @param array $args Arguments.
 */
function uraf_get_wp_editor( $args ) {
	$value    = isset( $args['value'] ) ? $args['value'] : '';
	$settings = array(
		'media_buttons' => false,
		'editor_class'  => 'wysiwyg input-text ' . implode( ' ', $args['input_class'] ),
	);
	ob_start();
	wp_editor( $value, $args['id'], $settings );
	return ob_get_clean();
}

add_filter( 'user_registration_sanitize_field', 'uraf_sanitize_fields', 10, 2 );

/**
 * Sanitize advanced fields on frontend submit
 *
 * @param  array  $form_data Form Data.
 * @param  string $field_key Field Key.
 * @return array
 */
function uraf_sanitize_fields( $form_data, $field_key ) {
	switch ( $field_key ) {
		case 'wysiwyg':
			$form_data->value = wp_kses_post( $form_data->value );
			break;
		case 'phone':
			$form_data->value = sanitize_text_field( $form_data->value );
			break;
		case 'timepicker':
			$form_data->value = sanitize_text_field( $form_data->value );
			break;
		case 'section_title':
		case 'html':
			$form_data->value = sanitize_text_field( $form_data->value );
			break;
	}
		return $form_data;
}

add_filter( 'user_registration_profile_account_filter_html', 'uraf_profile_fields_data', 10, 2 );
add_filter( 'user_registration_profile_account_filter_phone', 'uraf_profile_fields_data', 10, 2 );
add_filter( 'user_registration_profile_account_filter_select2', 'uraf_profile_fields_data', 10, 2 );
add_filter( 'user_registration_profile_account_filter_multi_select2', 'uraf_profile_fields_data', 10, 2 );
add_filter( 'user_registration_profile_account_filter_section_title', 'uraf_profile_fields_data', 10, 2 );
add_filter( 'user_registration_profile_account_filter_profile_picture', 'uraf_profile_fields_data', 10, 2 );

/**
 * Hook field type for access in profile page
 *
 * @param  array $filter_data  Filter Data.
 * @param int   $form_id Form Id.
 */
function uraf_profile_fields_data( $filter_data, $form_id ) {
	$field       = $filter_data['field'];
	$field_name  = isset( $field->general_setting->field_name ) ? $field->general_setting->field_name : '';
	$field_index = 'user_registration_' . $field_name;
	$field_key   = isset( $field->field_key ) ? $field->field_key : '';

	if ( 'profile_picture' !== $field_key ) {
		$filter_data['fields'][ $field_index ]['description'] = ur_string_translation( $form_id, 'user_registration_' . $field_name . '_description', isset( $field->general_setting->description ) ? $field->general_setting->description : '' );
		$filter_data['fields'][ $field_index ]['type']        = $field_key;

		$filter_data['fields'][ $field_index ]['label']     = ur_string_translation( $form_id, 'user_registration_' . $field_name . '_label', isset( $field->general_setting->label ) ? $field->general_setting->label : '' );
		$filter_data['fields'][ $field_index ]['field_key'] = $field_key;
		$filter_data['fields'][ $field_index ]['required']  = isset( $field->required ) ? $field->required : '';
	}
	if ( 'html' === $field_key ) {
		$filter_data['fields'][ $field_index ]['html'] = isset( $field->general_setting->html ) ? $field->general_setting->html : '';
	} elseif ( 'select2' === $field_key || 'multi_select2' === $field_key ) {
		$filter_data['fields'][ $field_index ]['options']       = isset( $field->general_setting->options ) ? $field->general_setting->options : '';
		$filter_data['fields'][ $field_index ]['default_value'] = isset( $field->general_setting->default_value ) ? $field->general_setting->default_value : '';
	} elseif ( 'phone' === $field_key ) {
		$filter_data['fields'][ $field_index ]['input_mask'] = isset( $field->general_setting->input_mask ) ? $field->general_setting->input_mask : '(999) 999-9999';
	} elseif ( 'section_title' === $field_key ) {
		$filter_data['fields'][ $field_index ]['header_attribute'] = isset( $field->general_setting->header_attribute ) ? $field->general_setting->header_attribute : 'h3';
	}

	return $filter_data;
}

add_filter( 'user_registration_before_register_user_filter', 'strip_title_html_data_save', 10, 2 );

/**
 * Strip title and html section to save in usermeta
 *
 * @param  object $valid_form_data Form Data.
 * @param  int    $form_id Formid.
 * @return object
 */
function strip_title_html_data_save( $valid_form_data, $form_id ) {
	$strip_fields = array( 'section_title', 'html' );
	foreach ( $valid_form_data as $key => $form_data ) {
		if ( isset( $form_data->extra_params['field_key'] ) && in_array( $form_data->extra_params['field_key'], $strip_fields ) ) {
			unset( $valid_form_data[ $key ] );
		}
	}

	return $valid_form_data;
}

add_filter( 'user_registration_one_time_draggable_form_fields', 'ur_profile_picture_one_time_drag', 10, 1 );

/**
 * Make profile picture one time draggable.
 *
 * @param array $fields One time draggable fields.
 *
 * @return array One time draggable fields.
 */
function ur_profile_picture_one_time_drag( $fields ) {
	$fields[] = 'profile_picture';
	return $fields;
}
