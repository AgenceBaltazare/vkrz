<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract URCL Setting Mailchimp Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Mailchimp extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'mailchimp_advance_setting';
	}
}

return new URCL_Conditional_Setting_Mailchimp();
