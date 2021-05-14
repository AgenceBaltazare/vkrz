<?php
/**
 * URFV_Setting_Select.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Select Class.
 */
class URFV_Setting_Select extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Select class constructor.
	 */
	public function __construct() {
		$this->field_id = 'select_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Select();
