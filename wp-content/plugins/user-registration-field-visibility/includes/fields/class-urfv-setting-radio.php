<?php
/**
 * URFV_Setting_Radio.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Radio Class.
 */
class URFV_Setting_Radio extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Radio class constructor.
	 */
	public function __construct() {
		$this->field_id = 'radio_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Radio();
