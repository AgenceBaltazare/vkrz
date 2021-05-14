<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URCL_Conditional_Setting_Credit_Card Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Credit_Card extends URCL_Field_Settings {

	public function __construct() {
		$this->field_id = 'credit_card_advance_setting';
	}
}

return new URCL_Conditional_Setting_Credit_Card();
