<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * URAF_Setting_Profile_Picture Class
 *
 * @package  UserRegistrationAdvancedFields/Form/Settings
 * @category Abstract Class
 * @author   WPEverest
 */
class UR_Setting_Profile_Picture extends UR_Field_Settings {


	public function __construct() {
		$this->field_id = 'profile_pic_advance_setting';
	}

	public function output( $field_data = array() ) {

		$this->field_data = $field_data;
		$this->register_fields();
		$field_html = $this->fields_html;

		return $field_html;
	}

	public function register_fields() {
		$fields = array(

			'custom_class' => array(
				'label'       => esc_html__( 'Custom Class', 'user-registration-advanced-fields' ),
				'data-id'     => $this->field_id . '_custom_class',
				'name'        => $this->field_id . '[custom_class]',
				'class'       => $this->default_class . ' ur-settings-custom-class',
				'type'        => 'text',
				'required'    => false,
				'default'     => '',
				'placeholder' => esc_html__( 'Custom Class', 'user-registration' ),
				'tip'         => __( 'Custom css class to embed in this field.', 'user-registration-advanced-fields' ),
			),
		);

		$this->render_html( $fields );
	}
}

return new UR_Setting_Profile_Picture();
