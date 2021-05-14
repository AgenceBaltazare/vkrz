<?php
/**
 * URFV_Setting_Date.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Date Class.
 */
class URFV_Setting_Date extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Date class constructor.
	 */
	public function __construct() {
		$this->field_id = 'date_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Date();
