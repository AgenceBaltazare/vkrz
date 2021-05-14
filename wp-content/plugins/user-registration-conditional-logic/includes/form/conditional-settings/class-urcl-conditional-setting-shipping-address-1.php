<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Conditional_Setting_Shipping_Address_1 Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Shipping_Address_1 extends URCL_Field_Settings {

	public $form_id;

	public function __construct() {

		$this->form_id = isset( $_GET['edit-registration'] ) ? $_GET['edit-registration'] : '';

		$this->field_id = 'shipping_address_1_advance_setting';
	}
}

return new URCL_Conditional_Setting_Shipping_Address_1();
