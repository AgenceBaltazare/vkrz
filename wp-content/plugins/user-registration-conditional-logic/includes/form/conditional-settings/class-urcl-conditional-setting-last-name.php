<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract URCL Setting Last_Name Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Last_Name extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'last_name_advance_setting';
	}
}

return new URCL_Conditional_Setting_Last_Name();
