<?php
/**
 * URFV_Setting_Timepicker.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Timepicker Class.
 */
class URFV_Setting_Timepicker extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Timepicker class constructor.
	 */
	public function __construct() {
		$this->field_id = 'timepicker_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Timepicker();
