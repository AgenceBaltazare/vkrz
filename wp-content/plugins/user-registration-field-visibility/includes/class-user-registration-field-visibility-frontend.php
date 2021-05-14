<?php
/**
 * User_Registration_Field_Visibility_Frontend
 *
 * @package  User_Registration_Field_Visibility_Frontend
 * @since  1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @class User_Registration_Field_Visibility_Frontend
 */
class User_Registration_Field_Visibility_Frontend {

	/**
	 * User_Registration_Field_Visibility_Frontend Constructor
	 */
	public function __construct() {
		add_filter( 'user_registration_before_registration_form_template', array( $this, 'modify_registration_form' ), 10, 2 );
		add_filter( 'user_registration_profile_account_filter_all_fields', array( $this, 'modify_edit_profile_form' ), 10, 2 );
	}

	/**
	 * Modify Form fields.
	 *
	 * @param array $form_data_array   Form Data array.
	 * @param int   $form_id           Form ID.
	 *
	 * @return array
	 */
	public function modify_registration_form( $form_data_array, $form_id ) {
		foreach ( $form_data_array as $row_key => $row_data ) {
			foreach ( $row_data as $column_key => $column_data ) {
				foreach ( $column_data as $field_key => $field_data ) {
					if ( isset( $field_data->advance_setting->field_visibility ) && 'reg_form' !== $field_data->advance_setting->field_visibility && 'both' !== $field_data->advance_setting->field_visibility ) {
						unset( $form_data_array[ $row_key ][ $column_key ][ $field_key ] );
					}
					if ( isset( $field_data->advance_setting->read_only ) && ( 'reg_form' === $field_data->advance_setting->read_only || 'both' === $field_data->advance_setting->read_only ) ) {
						$form_data_array[ $row_key ][ $column_key ][ $field_key ]->general_setting->custom_attributes['readonly'] = 'readonly';
						$form_data_array[ $row_key ][ $column_key ][ $field_key ]->general_setting->custom_attributes['disabled'] = 'disabled';
					}
				}
			}
		}
		return $form_data_array;
	}

	/**
	 * Modify Form fields.
	 *
	 * @param array $form_data_array   Form Data array.
	 * @param int   $form_id           Form ID.
	 *
	 * @return array
	 */
	public function modify_edit_profile_form( $form_data_array, $form_id ) {
		foreach ( $form_data_array as $row_key => $row_data ) {
			foreach ( $row_data as $column_key => $column_data ) {
				foreach ( $column_data as $field_key => $field_data ) {
					if ( isset( $field_data->advance_setting->field_visibility ) && 'edit_form' !== $field_data->advance_setting->field_visibility && 'both' !== $field_data->advance_setting->field_visibility ) {
						unset( $form_data_array[ $row_key ][ $column_key ][ $field_key ] );
					}
					if ( isset( $field_data->advance_setting->read_only ) && ( 'edit_form' === $field_data->advance_setting->read_only || 'both' === $field_data->advance_setting->read_only ) ) {
						$form_data_array[ $row_key ][ $column_key ][ $field_key ]->general_setting->custom_attributes['readonly'] = 'readonly';
						$form_data_array[ $row_key ][ $column_key ][ $field_key ]->general_setting->custom_attributes['disabled'] = 'disabled';
					}
				}
			}
		}
		return $form_data_array;
	}
}

new User_Registration_Field_Visibility_Frontend();
