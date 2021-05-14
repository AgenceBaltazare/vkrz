<?php
/**
 * URFV_Setting_User_Confirm_Email.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_User_Confirm_Email Class.
 */
class URFV_Setting_User_Confirm_Email extends URFV_Setting_Base {

	/**
	 * URFV_Setting_User_Confirm_Email class constructor.
	 */
	public function __construct() {
		$this->field_id = 'user_confirm_email_advance_setting';
		parent::__construct();

		unset( $this->fields['field_visibility']['options']['edit_form'] );
		unset( $this->fields['read_only'] );
	}
}

return new URFV_Setting_User_Confirm_Email();
