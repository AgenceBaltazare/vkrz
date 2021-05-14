<?php
/**
 * URFV_Setting_Country.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Country Class.
 */
class URFV_Setting_Country extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Country class constructor.
	 */
	public function __construct() {
		$this->field_id = 'country_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Country();
