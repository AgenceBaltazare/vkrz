<?php
/**
 * URFV_Setting_User_Confirm_Password.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_User_Confirm_Password Class.
 */
class URFV_Setting_User_Confirm_Password extends URFV_Setting_Base {

	/**
	 * URFV_Setting_User_Confirm_Password class constructor.
	 */
	public function __construct() {
		$this->field_id = 'user_confirm_password_advance_setting';
		parent::__construct();

		unset( $this->fields['field_visibility']['options']['edit_form'] );
		unset( $this->fields['read_only'] );
	}
}

return new URFV_Setting_User_Confirm_Password();
