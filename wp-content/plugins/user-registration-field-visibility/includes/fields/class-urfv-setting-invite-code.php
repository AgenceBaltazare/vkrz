<?php
/**
 * URFV_Setting_Invite_Code.
 *
 * @since  1.0.2
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 *  URFV_Setting_Invite_Code Class.
 */
class  URFV_Setting_Invite_Code extends URFV_Setting_Base {

	/**
	 *  URFV_Setting_Invite_Code class constructor.
	 */
	public function __construct() {
		$this->field_id = 'invite_code';
		parent::__construct();

		unset( $this->fields['read_only'] );
		unset( $this->fields['field_visibility']['options']['edit_form'] );

	}
}

return new  URFV_Setting_Invite_Code();
