<?php
/**
 * URFV_Setting_Number.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Number Class.
 */
class URFV_Setting_Number extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Number class constructor.
	 */
	public function __construct() {
		$this->field_id = 'number_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Number();
