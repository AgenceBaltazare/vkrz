<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract URCL Setting LearnDash Course Class
 *
 * @version  1.0.0
 * @package  UserRegistrationContidtionalLogic/Form/Settings
 * @author   WPEverest
 */
class URCL_Conditional_Setting_Learndash_Course extends URCL_Field_Settings {

	/**
	 * Learndash Course Class Constructor.
	 */
	public function __construct() {
		$this->field_id = 'learndash_course_advance_setting';
	}
}

return new URCL_Conditional_Setting_Learndash_Course();
