<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Conditional_Setting_Section_Title Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Section_Title extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'section_title_advance_setting';
	}
}

return new URCL_Conditional_Setting_Section_Title();
