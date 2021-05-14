<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract URCL Setting Multiselect2 Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Multi_Select2 extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'multi_select2_advance_setting';
	}
}

return new URCL_Conditional_Setting_Multi_Select2();
