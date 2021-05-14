<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Conditional_Setting_Html Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Html extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'html_advance_setting';
	}
}

return new URCL_Conditional_Setting_Html();
