<?php
/**
 * Add extra profile fields for users in WordPress Profile Page
 *
 * @author   WPEverest
 * @category Admin
 * @package  UserRegistration/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'URAF_Admin_Profile', false ) ) :

	/**
	 * UR_Admin_Profile Class.
	 */
	class URAF_Admin_Profile {

		/**
		 * Constructor
		 */
		public function __construct() {

			add_filter( 'user_registration_profile_field_filter_html', array( $this, 'profile_fields_data' ), 10, 1 );
			add_filter( 'user_registration_profile_field_filter_wysiwyg', array( $this, 'profile_fields_data' ), 10, 1 );
			add_filter( 'user_registration_profile_field_filter_section_title', array( $this, 'profile_fields_data' ), 10, 1 );
			add_filter( 'user_registration_profile_field_filter_select2', array( $this, 'profile_fields_data' ), 10, 1 );
			add_filter( 'user_registration_profile_field_filter_multi_select2', array( $this, 'profile_fields_data' ), 10, 1 );
			add_filter( 'user_registration_profile_field_filter_range', array( $this, 'profile_fields_data' ), 10, 1 );

			add_action( 'user_registration_profile_field_html', array( $this, 'render_advanced_fields' ), 10, 1 );
			add_action( 'user_registration_profile_field_wysiwyg', array( $this, 'render_advanced_fields' ), 10, 1 );
			add_action( 'user_registration_profile_field_select2', array( $this, 'render_advanced_fields' ), 10, 1 );
			add_action( 'user_registration_profile_field_multi_select2', array( $this, 'render_advanced_fields' ), 10, 1 );
			add_action( 'user_registration_profile_field_range', array( $this, 'render_advanced_fields' ), 10, 1 );

			add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
		}

		/**
		 * Register and Equeuing Script and Style.
		 */
		public function load_scripts() {
			$screen    = get_current_screen();
			$screen_id = $screen ? $screen->id : '';
			$suffix    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_register_script( 'user-registration-time-picker', URAF()->plugin_url() . '/assets/js/jquery-timepicker/jquery.timepicker' . $suffix . '.js', array( 'jquery' ), URAF_VERSION, true );
			wp_register_script( 'user-registration-advanced-fields-frontend', URAF()->plugin_url() . '/assets/js/frontend/uraf-frontend' . $suffix . '.js', array( 'jquery', 'user-registration-time-picker', 'selectWoo' ), URAF_VERSION, true );

			if ( 'user-edit' === $screen_id || 'profile' === $screen_id ) {
				wp_enqueue_script( 'user-registration-advanced-fields-frontend' );
			}
		}

		/**
		 * Hook field type for access in profile page
		 *
		 * @param  mixed $filter_data Filter Data.
		 * @return mixed
		 */
		public function profile_fields_data( $filter_data ) {
			$field       = $filter_data['field'];
			$field_name  = isset( $field->general_setting->field_name ) ? $field->general_setting->field_name : '';
			$field_index = 'user_registration_' . $field_name;
			$field_key   = isset( $field->field_key ) ? $field->field_key : '';
			switch ( $field_key ) {
				case 'html':
					$field_index                                   = 'user_registration_' . $field_name;
					$field_key                                     = isset( $field->field_key ) ? $field->field_key : '';
					$filter_data['fields'][ $field_index ]['type'] = 'html';
					$filter_data['fields'][ $field_index ]['html'] = isset( $field->general_setting->html ) ? $field->general_setting->html : '';
					break;
				case 'wysiwyg':
					$filter_data['fields'][ $field_index ]['type'] = 'wysiwyg';
					break;
				case 'section_title':
					$field_index                                   = 'user_registration_' . $field_name;
					$field_key                                     = isset( $field->field_key ) ? $field->field_key : '';
					$filter_data['fields'][ $field_index ]['type'] = 'section_title';
					break;
				case 'select2':
					$filter_data['fields'][ $field_index ]['class']   = 'ur-field-profile-select2';
					$filter_data['fields'][ $field_index ]['type']    = 'select2';
					$filter_data['fields'][ $field_index ]['options'] = isset( $field->general_setting->options ) ? $field->general_setting->options : array();
					break;
				case 'multi_select2':
					$filter_data['fields'][ $field_index ]['class']   = 'ur-field-profile-select2';
					$filter_data['fields'][ $field_index ]['type']    = 'multi_select2';
					$filter_data['fields'][ $field_index ]['options'] = isset( $field->general_setting->options ) ? $field->general_setting->options : array();
					break;
				case 'range':
					$field_index                                   = 'user_registration_' . $field_name;
					$field_key                                     = isset( $field->field_key ) ? $field->field_key : '';
					$filter_data['fields'][ $field_index ]['type'] = 'range';
					$filter_data['fields'][ $field_index ]['range_min']  = ( isset( $field->advance_setting->range_min ) && "" !== $field->advance_setting->range_min ) ? $field->advance_setting->range_min : "0";
					$filter_data['fields'][ $field_index ]['range_max']  = ( isset( $field->advance_setting->range_max ) && "" !== $field->advance_setting->range_max ) ? $field->advance_setting->range_max : "10";
					$filter_data['fields'][ $field_index ]['range_step'] = isset( $field->advance_setting->range_step ) ? $field->advance_setting->range_step : "1";

					if ( "true" === $field->advance_setting->enable_prefix_postfix ) {

						if ( "true" === $field->advance_setting->enable_text_prefix_postfix ) {
							$filter_data['fields'][ $field_index ]['range_prefix']  = isset( $field->advance_setting->range_prefix ) ? $field->advance_setting->range_prefix : "";
							$filter_data['fields'][ $field_index ]['range_postfix'] = isset( $field->advance_setting->range_postfix ) ? $field->advance_setting->range_postfix : "";
						} else {

							$filter_data['fields'][ $field_index ]['range_prefix']  = $filter_data['fields'][ $field_index ]['range_min'];
							$filter_data['fields'][ $field_index ]['range_postfix'] = $filter_data['fields'][ $field_index ]['range_max'];
						}
					}
					break;
			}
			return $filter_data;

		}

		/**
		 * Render advanced fields in WP Profile page
		 *
		 * @param  array $data Data.
		 */
		public function render_advanced_fields( $data ) {
			extract( $data );
			switch ( $data['field']['type'] ) {
				case 'html':
					echo $field['html'];  // @codingStandardsIgnoreLine
					break;
				case 'wysiwyg':
					$pos = strpos( $key, 'user_registration_' );
					if ( false !== $pos ) {
						$id = substr_replace( $key, '', $pos, strlen( 'user_registration_' ) );
					}

					$settings = array(
						'media_buttons' => false,
						'textarea_name' => $key,
					);
					wp_editor( $value, $id, $settings );

					break;
				case 'select2':
					echo '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" class="' . esc_attr( $field['class'] ) . '" style="width: 25em;">';
					echo '<option value="">' . esc_html__( 'Select', 'user-registration' ) . '</option>';
					foreach ( $field['options'] as $option_value ) {
						$selected = selected( $option_value, $value, false );
						echo '<option value="' . esc_attr( trim( $option_value ) ) . '" ' . $selected . '>' . esc_attr( trim( $option_value ) ) . '</option>';
					}
					echo '</select>';
					break;
				case 'multi_select2':
					echo '<select name="' . esc_attr( $key ) . '[]" id="' . esc_attr( $key ) . '" class="' . esc_attr( $field['class'] ) . '" multiple="multiple" style="width: 25em;">';
					foreach ( $field['options'] as $option_value ) {
						$selected = ( $value && is_array( $value ) && in_array( $option_value, $value, true ) ) ? 'selected="selected"' : '';
						echo '<option value="' . esc_attr( trim( $option_value ) ) . '" ' . $selected . '>' . esc_attr( trim( $option_value ) ) . '</option>';
					}
					echo '</select>';
					break;
				case 'range':
					echo ' <input type="number" class="ur-range-input" min="' . esc_attr( $field['range_min'] ) . '" max="' . esc_attr( $field['range_max'] ) . '" step="' . esc_attr( $field['range_step'] ) . '"  value="' . esc_attr( $value ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '"/>';
				    break;
			}
		}
	}

endif;

return new URAF_Admin_Profile();
