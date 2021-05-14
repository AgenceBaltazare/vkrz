<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * URAF_Setting_Range Class
 *
 * @package  UserRegistrationAdvancedFields/Form/Settings
 * @category Abstract Class
 * @author   WPEverest
 *
 * @since 1.4.0
 */
class UR_Setting_Range extends UR_Field_Settings {


	public function __construct() {
		$this->field_id = 'range_advance_setting';
	}

	public function output( $field_data = array() ) {

		$this->field_data = $field_data;
		$this->register_fields();
		$field_html = $this->fields_html;

		return $field_html;
	}

	public function register_fields() {
		$fields = array(
			'custom_class'               => array(
				'label'       => esc_html__( 'Custom Class', 'user-registration-advanced-fields-advanced-fields' ),
				'data-id'     => $this->field_id . '_custom_class',
				'name'        => $this->field_id . '[custom_class]',
				'class'       => $this->default_class . ' ur-settings-custom-class',
				'type'        => 'text',
				'required'    => false,
				'default'     => '',
				'placeholder' => esc_html__( 'Custom Class', 'user-registration-advanced-fields-advanced-fields' ),
				'tip'         => __( 'Custom css class to embed in this field.', 'user-registration-advanced-fields-advanced-fields' ),
			),
			'range_min'                  => array(
				'label'       => __( 'Minimum Value', 'user-registration-advanced-fields' ),
				'data-id'     => $this->field_id . '_range_min',
				'name'        => $this->field_id . '[range_min]',
				'class'       => $this->default_class . ' ur-settings-min',
				'type'        => 'number',
				'required'    => false,
				'default'     => '',
				'placeholder' => __( 'Min Value', 'user-registration-advanced-fields' ),
				'tip'         => __( 'Minimum allowed number.', 'user-registration-advanced-fields' ),
			),
			'range_max'                  => array(
				'label'       => __( 'Maximum Value', 'user-registration-advanced-fields' ),
				'data-id'     => $this->field_id . '_range_max',
				'name'        => $this->field_id . '[range_max]',
				'class'       => $this->default_class . ' ur-settings-max',
				'type'        => 'number',
				'required'    => false,
				'default'     => '',
				'placeholder' => __( 'Max Value', 'user-registration-advanced-fields' ),
				'tip'         => __( 'Maximum allowed number.', 'user-registration-advanced-fields' ),
			),
			'range_step'                 => array(
				'label'       => __( 'Step', 'user-registration-advanced-fields' ),
				'data-id'     => $this->field_id . '_range_step',
				'name'        => $this->field_id . '[range_step]',
				'class'       => $this->default_class . ' ur-settings-step',
				'type'        => 'number',
				'required'    => false,
				'default'     => 1,
				'placeholder' => __( 'Legal Range Intervals', 'user-registration-advanced-fields' ),
				'tip'         => __( 'Allows users to enter specific legal number intervals.', 'user-registration-advanced-fields' ),
			),
			'enable_prefix_postfix'      => array(
				'type'     => 'select',
				'data-id'  => $this->field_id . '_enable_prefix_postfix',
				'label'    => __( 'Display Slider Prefix/Postfix', 'user-registration-advanced-fields' ),
				'name'     => $this->field_id . '[enable_prefix_postfix]',
				'class'    => $this->default_class . ' ur-settings-enable-prefix-postfix',
				'default'  => 'false',
				'required' => false,
				'options'  => array(
					'true'  => 'Yes',
					'false' => 'No',
				),
				'tip'      => __( 'Enable this if you want to show Prefix/Postfix of this Range Slider field.', 'user-registration-advanced-fields' ),
			),
			'enable_text_prefix_postfix' => array(
				'type'     => 'select',
				'data-id'  => $this->field_id . '_enable_text_prefix_postfix',
				'label'    => __( 'Use Text Prefix/Postfix', 'user-registration-advanced-fields' ),
				'name'     => $this->field_id . '[enable_text_prefix_postfix]',
				'class'    => $this->default_class . ' ur-settings-enable-text-prefix-postfix',
				'default'  => 'false',
				'required' => false,
				'options'  => array(
					'true'  => 'Yes',
					'false' => 'No',
				),
				'tip'      => __( 'Enable this if you want use text Prefix/Postfix of this Range Slider field.', 'user-registration-advanced-fields' ),
			),
			'range_prefix'               => array(
				'label'    => __( 'Prefix Text', 'user-registration-advanced-fields' ),
				'data-id'  => $this->field_id . '_range_prefix',
				'name'     => $this->field_id . '[range_prefix]',
				'class'    => $this->default_class . ' ur-settings-range-prefix',
				'type'     => 'text',
				'required' => false,
				'default'  => '',
				'tip'      => __( 'Enter texts to show in prefix.', 'user-registration-advanced-fields' ),
			),
			'range_postfix'              => array(
				'label'    => __( 'Postfix Text', 'user-registration-advanced-fields' ),
				'data-id'  => $this->field_id . '_range_postfix',
				'name'     => $this->field_id . '[range_postfix]',
				'class'    => $this->default_class . ' ur-settings-range-postfix',
				'type'     => 'text',
				'required' => false,
				'default'  => '',
				'tip'      => __( 'Enter texts to show in postfix.', 'user-registration-advanced-fields' ),
			),
		);

		$this->render_html( $fields );
	}
}

return new UR_Setting_Range();
