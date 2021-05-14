<?php
/**
 * Form View: Phone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ur-input-type-phone ur-admin-template">

	<div class="ur-label">
		<label><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></label>

	</div>
	<div class="ur-field" data-field-key="phone">

		<input type="phone" id="ur-input-type-phone" placeholder="<?php echo esc_attr( $this->get_general_setting_data( 'placeholder' ) ); ?>" disabled />

	</div>

	<?php

	UR_Form_Field_Phone::get_instance()->get_setting();

	?>
</div>
