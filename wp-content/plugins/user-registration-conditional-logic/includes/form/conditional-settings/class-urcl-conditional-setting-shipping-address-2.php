<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Conditional_Setting_Shipping_Address_2 Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Shipping_Address_2 extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'shipping_address_2_advance_setting';
	}
}

return new URCL_Conditional_Setting_Shipping_Address_2();
