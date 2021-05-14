<?php
/**
 * URFV_Setting_First_Name.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_First_Name Class.
 */
class URFV_Setting_First_Name extends URFV_Setting_Base {

	/**
	 * URFV_Setting_First_Name class constructor.
	 */
	public function __construct() {
		$this->field_id = 'first_name_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_First_Name();
