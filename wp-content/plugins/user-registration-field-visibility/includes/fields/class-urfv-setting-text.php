<?php
/**
 * URFV_Setting_Text.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Text Class.
 */
class URFV_Setting_Text extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Text class constructor.
	 */
	public function __construct() {
		$this->field_id = 'text_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Text();
