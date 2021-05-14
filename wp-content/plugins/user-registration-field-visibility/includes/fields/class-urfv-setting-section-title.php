<?php
/**
 * URFV_Setting_Section_Title.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Section_Title Class.
 */
class URFV_Setting_Section_Title extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Section_Title class constructor.
	 */
	public function __construct() {
		$this->field_id = 'section_title_advance_setting';
		parent::__construct();

		unset( $this->fields['read_only'] );
	}
}

return new URFV_Setting_Section_Title();
