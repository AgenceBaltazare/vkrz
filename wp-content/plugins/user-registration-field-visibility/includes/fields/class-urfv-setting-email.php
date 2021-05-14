<?php
/**
 * URFV_Setting_Email.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Email Class.
 */
class URFV_Setting_Email extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Email class constructor.
	 */
	public function __construct() {
		$this->field_id = 'email_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Email();
