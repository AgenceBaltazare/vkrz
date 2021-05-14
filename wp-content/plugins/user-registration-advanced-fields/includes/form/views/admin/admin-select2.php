<?php
/**
 * Form View: Select2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$default_options = isset( $this->field_defaults['default_options'] ) ? $this->field_defaults['default_options'] : array();
$options         = isset( $this->admin_data->general_setting->options ) ? $this->admin_data->general_setting->options : $default_options;
$default_value   = isset( $this->admin_data->general_setting->default_value ) ? $this->admin_data->general_setting->default_value : '';
$options         = array_map( 'trim', $options );

?>
<div class="ur-input-type-select2 ur-admin-template">

	<div class="ur-label">
		<label><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></label>
	</div>

	<div class="ur-field" data-field-key="select2">
		<select id="ur-input-type-select2" disabled>
			<?php
			foreach ( $options as $option ) {
				echo "<option value='" . esc_attr( trim( $option ) ) . "' '" . selected( $option, $default_value, false ) . "'>" . esc_html( trim( $option ) ) . '</option>';
			}
			?>
		</select>
	</div>

	<?php
		UR_Form_Field_Select2::get_instance()->get_setting();
	?>
</div>
