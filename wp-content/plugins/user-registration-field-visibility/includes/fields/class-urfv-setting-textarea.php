<?php
/**
 * URFV_Setting_Textarea.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Textarea Class.
 */
class URFV_Setting_Textarea extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Textarea class constructor.
	 */
	public function __construct() {
		$this->field_id = 'textarea_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Textarea();
