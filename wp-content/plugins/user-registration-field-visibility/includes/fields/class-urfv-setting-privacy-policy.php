<?php
/**
 * URFV_Setting_Privacy_Policy.
 *
 * @version  1.0.0
 * @package  UserRegistrationFieldVisibility/Fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * URFV_Setting_Privacy_Policy Class.
 */
class URFV_Setting_Privacy_Policy extends URFV_Setting_Base {

	/**
	 * URFV_Setting_Privacy_Policy class constructor.
	 */
	public function __construct() {
		$this->field_id = 'privacy_policy_advance_setting';
		parent::__construct();

		unset( $this->fields['field_visibility'] );
		unset( $this->fields['read_only']['options']['both'] );
		unset( $this->fields['read_only']['options']['reg_form'] );
	}
}

return new URFV_Setting_Privacy_Policy();
