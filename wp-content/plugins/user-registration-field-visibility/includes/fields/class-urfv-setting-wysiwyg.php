<?php
/**
 * URFV_Setting_Wysiwyg.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Wysiwyg Class.
 */
class URFV_Setting_Wysiwyg extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Wysiwyg class constructor.
	 */
	public function __construct() {
		$this->field_id = 'wysiwyg_advance_setting';
		parent::__construct();

		unset( $this->fields['read_only'] );
	}
}

return new URFV_Setting_Wysiwyg();
