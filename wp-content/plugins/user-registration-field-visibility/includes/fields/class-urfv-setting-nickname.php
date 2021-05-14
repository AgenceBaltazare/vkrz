<?php
/**
 * URFV_Setting_Nickname.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Nickname Class.
 */
class URFV_Setting_Nickname extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Nickname class constructor.
	 */
	public function __construct() {
		$this->field_id = 'nickname_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Nickname();
