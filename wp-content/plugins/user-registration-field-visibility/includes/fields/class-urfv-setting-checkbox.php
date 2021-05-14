<?php
/**
 * URFV_Setting_Checkbox.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Checkbox Class.
 */
class URFV_Setting_Checkbox extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Checkbox class constructor.
	 */
	public function __construct() {
		$this->field_id = 'checkbox_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Checkbox();
