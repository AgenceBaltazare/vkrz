<?php
/**
 * URFV_Setting_User_Url.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_User_Url Class.
 */
class URFV_Setting_User_Url extends URFV_Setting_Base {

	/**
	 * URFV_Setting_User_Url class constructor.
	 */
	public function __construct() {
		$this->field_id = 'user_url_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_User_Url();
