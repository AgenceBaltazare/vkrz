<?php
/**
 * URFV_Setting_Base.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Base Class.
 */
class URFV_Setting_Base extends UR_Field_Settings {

	/**
	 * Default Fields for Field Visibility
	 *
	 * @var array
	 */
	protected $fields = array();
	/**
	 * URFV_Setting_Base class constructor.
	 */
	public function __construct() {
		$this->fields = array(
			'field_visibility' => array(
				'label'       => __( 'Show on', 'user-registration-field-visibility' ),
				'data-id'     => $this->field_id . '_field_visibility',
				'name'        => $this->field_id . '[field_visibility]',
				'class'       => $this->default_class . ' ur-settings-field-visibility',
				'type'        => 'select',
				'required'    => false,
				'default'     => 'both',
				'placeholder' => __( 'Show on', 'user-registration-field-visibility' ),
				'options'     => array(
					'reg_form'  => __( 'Registration Form', 'user-registration-field-visibility' ),
					'edit_form' => __( 'Profile Details', 'user-registration-field-visibility' ),
					'both'      => __( 'Registration Form & Profile Details', 'user-registration-field-visibility' ),
				),
				'tip'         => __( 'Places to show this field for a user.', 'user-registration-field-visibility' ),
			),
			'read_only'        => array(
				'label'       => __( 'Enable Read-Only', 'user-registration-field-visibility' ),
				'data-id'     => $this->field_id . '_read_only',
				'name'        => $this->field_id . '[read_only]',
				'class'       => $this->default_class . ' ur-settings-read-only',
				'type'        => 'select',
				'required'    => false,
				'default'     => 'none',
				'placeholder' => __( 'Enable Read-only', 'user-registration-field-visibility' ),
				'options'     => array(
					'none'      => __( 'Disabled', 'user-registration-field-visibility' ),
					'reg_form'  => __( 'Registration Form', 'user-registration-field-visibility' ),
					'edit_form' => __( 'Profile Details', 'user-registration-field-visibility' ),
					'both'      => __( 'Registration Form & Profile Details', 'user-registration-field-visibility' ),
				),
				'tip'         => __( 'Whether to make it readonly or not.', 'user-registration-field-visibility' ),
			),
		);
	}

	/**
	 * Return's the output of settings.
	 *
	 * @param array $field_data Field Data.
	 *
	 * @return string
	 */
	public function output( $field_data = array() ) {
		$this->field_data = $field_data;
		$this->register_fields();
		$field_html = $this->fields_html;

		return $field_html;
	}

	/**
	 * Register Fields to be rendered.
	 */
	public function register_fields() {
		$this->render_html( $this->fields );
	}
}
