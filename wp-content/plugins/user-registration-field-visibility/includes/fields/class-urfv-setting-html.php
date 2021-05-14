<?php
/**
 * URFV_Setting_Html.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Html Class.
 */
class URFV_Setting_Html extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Html class constructor.
	 */
	public function __construct() {
		$this->field_id = 'html_advance_setting';
		parent::__construct();

		unset( $this->fields['read_only'] );
	}
}

return new URFV_Setting_Html();
