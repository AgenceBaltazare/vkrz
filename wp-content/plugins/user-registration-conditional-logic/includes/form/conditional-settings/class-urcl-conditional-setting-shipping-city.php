<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Conditional_Setting_Shipping_City Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Shipping_City extends URCL_Field_Settings {

	public $form_id;

	public function __construct() {
		$this->field_id = 'shipping_city_advance_setting';
	}
}

return new URCL_Conditional_Setting_Shipping_City();
