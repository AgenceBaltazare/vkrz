<?php
/**
 * URFV_Setting_User_Login.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_User_Login Class.
 */
class URFV_Setting_User_Login extends URFV_Setting_Base {

	/**
	 * URFV_Setting_User_Login class constructor.
	 */
	public function __construct() {
		$this->field_id = 'user_login_advance_setting';
		parent::__construct();

		unset( $this->fields['read_only'] );
	}
}

return new URFV_Setting_User_Login();
