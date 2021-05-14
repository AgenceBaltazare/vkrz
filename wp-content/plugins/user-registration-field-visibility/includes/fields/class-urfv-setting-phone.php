<?php
/**
 * URFV_Setting_Phone.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Phone Class.
 */
class URFV_Setting_Phone extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Phone class constructor.
	 */
	public function __construct() {
		$this->field_id = 'phone_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Phone();
