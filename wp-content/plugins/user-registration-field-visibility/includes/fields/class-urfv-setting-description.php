<?php
/**
 * URFV_Setting_Description.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Description Class.
 */
class URFV_Setting_Description extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Description class constructor.
	 */
	public function __construct() {
		$this->field_id = 'description_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Description();
