<?php
/**
 * Form View: Multi Select2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$default_options = isset( $this->field_defaults['default_options'] ) ? $this->field_defaults['default_options'] : array();
$options         = isset( $this->admin_data->general_setting->options ) ? $this->admin_data->general_setting->options : $default_options;
$default_value   = isset( $this->admin_data->general_setting->default_value ) ? $this->admin_data->general_setting->default_value : array();
$options         = array_map( 'trim', $options );

?>
<div class="ur-input-type-multi-select2 ur-admin-template">

	<div class="ur-label">
		<label><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></label>
	</div>

	<div class="ur-field" data-field-key="multi_select2">
		<select id="ur-input-type-multi-select2" disabled multiple="multiple" >
			<?php
			foreach ( $options as $option ) {
				$selected = in_array( $option, $default_value, true ) ? "selected='selected'" : '';
				echo sprintf( '<option value="%1$s" %2$s >%1$s</option>', esc_attr( trim( $option ) ), esc_attr( $selected ) );
			}
			?>
		</select>
	</div>

	<?php
		UR_Form_Field_Multi_Select2::get_instance()->get_setting();
	?>
</div>
