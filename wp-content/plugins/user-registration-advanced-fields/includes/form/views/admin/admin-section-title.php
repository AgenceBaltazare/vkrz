<?php
/**
 * Form View: Section Title
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$default_heading = isset( $this->field_defaults['default_header_attribute'] ) ? $this->field_defaults['default_header_attribute'] : 'h3';
$heading         = isset( $this->admin_data->general_setting->header_attribute ) ? $this->admin_data->general_setting->header_attribute : $default_heading;
?>
<div class="ur-input-type-section-title ur-admin-template">

	<div class="ur-label">
		<<?php echo $heading; ?>><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></<?php echo $heading; ?>>

	</div>
	<div class="ur-field" data-field-key="section_title">
	</div>
	<?php

	UR_Form_Field_Section_Title::get_instance()->get_setting();

	?>
</div>
