<?php
/**
 * Form View: Time Picker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="ur-input-type-timepicker ur-admin-template">

	<div class="ur-label">
		<label><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></label>

	</div>
	<div class="ur-field" data-field-key="timepicker">

		<input type="timepicker" id="ur-input-type-timepicker" placeholder="<?php echo esc_attr( $this->get_general_setting_data( 'placeholder' ) ); ?>" disabled/>

	</div>
	<?php

	UR_Form_Field_Timepicker::get_instance()->get_setting();

	?>
</div>
