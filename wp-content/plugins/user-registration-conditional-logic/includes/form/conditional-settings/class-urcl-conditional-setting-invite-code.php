<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Abstract URCL Setting Invite Code Class
 *
 * @since  1.1.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Invite_code extends URCL_Field_Settings {
	public function __construct() {
		$this->field_id = 'invite_code_advance_setting';
	}
}
return new URCL_Conditional_Setting_Invite_code();
