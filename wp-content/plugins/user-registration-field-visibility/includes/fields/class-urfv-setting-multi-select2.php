<?php
/**
 * URFV_Setting_Multi_Select2.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Multi_Select2 Class.
 */
class URFV_Setting_Multi_Select2 extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Multi_Select2 class constructor.
	 */
	public function __construct() {
		$this->field_id = 'multi_select2_advance_setting';
		parent::__construct();
	}
}

return new URFV_Setting_Multi_Select2();
