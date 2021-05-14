<?php
/**
 * Form View: Range
 *
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$style = "display:none;";

if ( "true" === $this->get_advance_setting_data( 'enable_prefix_postfix' ) ) {
	$style = "";
}

?>
<div class="ur-input-type-range ur-admin-template">

	<div class="ur-label">
		<label><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></label>

	</div>
	<div class="ur-field" data-field-key="range">
		<div class="ur-admin-range-row">
			<div class="ur-admin-range-field-sec">
				<span class="ur-range-slider-label ur-range-slider-prefix" style=<?php esc_attr_e( $style ); ?> ><?php echo ( "null" !== $this->get_advance_setting_data( 'range_prefix' ) && "true" === $this->get_advance_setting_data( 'enable_text_prefix_postfix' ) ) ? $this->get_advance_setting_data( 'range_prefix' ) : ( $this->get_advance_setting_data( 'range_min' ) ? $this->get_advance_setting_data( 'range_min' ) : "0" ); ?></span>
				<input type="range" id="ur-input-type-range" disabled />
				<span class="ur-range-slider-label ur-range-slider-postfix" style=<?php esc_attr_e( $style ); ?> ><?php echo ( "null" !== $this->get_advance_setting_data( 'range_postfix' ) && "true" === $this->get_advance_setting_data( 'enable_text_prefix_postfix' ) ) ? $this->get_advance_setting_data( 'range_postfix' ) : ( $this->get_advance_setting_data( 'range_max' ) ? $this->get_advance_setting_data( 'range_max' ) : "10" ); ?></span>
		    </div>
		    <div class="ur-admin-range-number">
				<input type="number" class="ur-range-input" disabled/>
				<span class="ur-range-slider-reset-icon dashicons dashicons-image-rotate"></span>
			</div>
	  	</div>
	</div>

	<?php

	UR_Form_Field_Range::get_instance()->get_setting();

	?>
</div>
