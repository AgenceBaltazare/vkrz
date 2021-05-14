<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract URCL Setting Checkbox Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_File extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'file_advance_setting';
	}
}

return new URCL_Conditional_Setting_File();
