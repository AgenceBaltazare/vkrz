<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract URCL Setting User_Url Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_User_Url extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'user_url_advance_setting';
	}
}

return new URCL_Conditional_Setting_User_Url();
