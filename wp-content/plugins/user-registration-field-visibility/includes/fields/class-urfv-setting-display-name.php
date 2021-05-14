<?php
/**
 * URFV_Setting_Display_Name.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Display_Name Class.
 */
class URFV_Setting_Display_Name extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Display_Name class constructor.
	 */
	public function __construct() {
		$this->field_id = 'display_name_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Display_Name();
