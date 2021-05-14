<?php
/**
 * URFV_Setting_File.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_File Class.
 */
class URFV_Setting_File extends URFV_Setting_Base {

	/**
	 * URFV_Setting_File class constructor.
	 */
	public function __construct() {
		$this->field_id = 'file_advance_setting';
		parent::__construct();

		unset( $this->fields['read_only'] );
	}
}

return new URFV_Setting_File();
