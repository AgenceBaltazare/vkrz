<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Conditional_Setting_Separate_Shipping Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Separate_Shipping extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'separate_shipping_advance_setting';
	}
}

return new URCL_Conditional_Setting_Separate_Shipping();
