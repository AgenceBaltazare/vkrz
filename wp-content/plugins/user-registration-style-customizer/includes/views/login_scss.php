<?php
/**
 * UserRegistration Style Customizer SCSS
 *
 * @package User_Registration_Style_Customizer
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Get values.
$styles = get_option( 'user_registration_login_styles' );

// Filter empty values.
$styles = array_map( 'array_filter', $styles );
$styles = array_filter( $styles );

$values = array_replace_recursive( $this->defaults, $styles ); // phpcs:ignore PHPCompatibility.PHP.NewFunctions.array_replace_recursiveFound

// Font styles.
$font_styles         = array(
	'font-weight'     => 'bold',
	'font-style'      => 'italic',
	'text-decoration' => 'underline',
	'text-transform'  => 'uppercase',
);
$font_styles_default = array(
	'font-weight'     => 'normal',
	'font-style'      => 'normal',
	'text-decoration' => 'none',
	'text-transform'  => 'none',
);
?>

// Form Wrapper variables.
$wrapper_width: <?php echo absint( $values['wrapper']['width'] ); ?>;
$wrapper_border_type: <?php echo ur_clean( $values['wrapper']['border_type'] ); ?>;
$wrapper_border_color: <?php echo ur_clean( $values['wrapper']['border_color'] ); ?>;

// Field Label variables.
<?php if ( ! empty( $values['field_label']['font_color'] ) ) : ?>
$field_label_font_color: <?php echo ur_clean( $values['field_label']['font_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['field_label']['font_size'] ) ) : ?>
$field_label_font_size: <?php echo ur_clean( $values['field_label']['font_size'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['field_label']['line_height'] ) ) : ?>
$field_label_line_height: <?php echo ur_clean( $values['field_label']['line_height'] ); ?>;
<?php endif; ?>
$field_label_text_alignment: <?php echo ur_clean( $values['field_label']['text_alignment'] ); ?>;

// Field styles variables.
<?php if ( ! empty( $values['field_styles']['font_color'] ) ) : ?>
$field_styles_font_color: <?php echo ur_clean( $values['field_styles']['font_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['field_styles']['placeholder_font_color'] ) ) : ?>
$field_styles_placeholder_font_color: <?php echo ur_clean( $values['field_styles']['placeholder_font_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['field_styles']['font_size'] ) ) : ?>
$field_styles_font_size: <?php echo ur_clean( $values['field_styles']['font_size'] ); ?>;
<?php endif; ?>
$field_styles_alignment: <?php echo ur_clean( $values['field_styles']['alignment'] ); ?>;
$field_styles_border_type: <?php echo ur_clean( $values['field_styles']['border_type'] ); ?>;
<?php if ( ! empty( $values['field_styles']['border_color'] ) ) : ?>
$field_styles_border_color: <?php echo ur_clean( $values['field_styles']['border_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['field_styles']['border_focus_color'] ) ) : ?>
$field_styles_border_focus_color: <?php echo ur_clean( $values['field_styles']['border_focus_color'] ); ?>;
<?php endif; ?>

// Field Checkbox variables.
$checkbox_styles_alignment: <?php echo ur_clean( $values['checkbox_radio_styles']['alignment'] ); ?>;
<?php if ( ! empty( $values['checkbox_radio_styles']['font_size'] ) ) : ?>
$checkbox_styles__font_size: <?php echo ur_clean( $values['checkbox_radio_styles']['font_size'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['checkbox_radio_styles']['font_color'] ) ) : ?>
$checkbox_styles__font_color: <?php echo ur_clean( $values['checkbox_radio_styles']['font_color'] ); ?>;
<?php endif; ?>
$checkbox_styles__inline_styles: <?php echo ur_clean( $values['checkbox_radio_styles']['inline_style'] ); ?>;
$checkbox_styles__size: <?php echo ur_clean( $values['checkbox_radio_styles']['size'] ); ?>;
$checkbox_styles_color: <?php echo ur_clean( $values['checkbox_radio_styles']['color'] ); ?>;
$checkbox_styles_checked_color: <?php echo ur_clean( $values['checkbox_radio_styles']['checked_color'] ); ?>;

// Button styles variables.
$button_alignment: <?php echo ur_clean( $values['button']['alignment'] ); ?>;
<?php if ( ! empty( $values['button']['font_color'] ) ) : ?>
$button_font_color: <?php echo ur_clean( $values['button']['font_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['button']['hover_font_color'] ) ) : ?>
$button_hover_font_color: <?php echo ur_clean( $values['button']['hover_font_color'] ); ?>;
<?php endif; ?>
$button_font_size: <?php echo ur_clean( $values['button']['font_size'] ); ?>;
$button_line_height: <?php echo ur_clean( $values['button']['line_height'] ); ?>;
<?php if ( ! empty( $values['button']['border_type'] ) ) : ?>
$button_border_type: <?php echo ur_clean( $values['button']['border_type'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['button']['border_color'] ) ) : ?>
$button_border_color: <?php echo ur_clean( $values['button']['border_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['button']['border_hover_color'] ) ) : ?>
$button_border_hover_color: <?php echo ur_clean( $values['button']['border_hover_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['button']['background_color'] ) ) : ?>
$button_background_color: <?php echo ur_clean( $values['button']['background_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['button']['hover_background_color'] ) ) : ?>
$button_hover_background_color: <?php echo ur_clean( $values['button']['hover_background_color'] ); ?>;
<?php endif; ?>

// Error Message styles variables.
$message_error_font_size : <?php echo ur_clean( $values['messages']['error_font_size'] ); ?>;
$message_error_font_color : <?php echo ur_clean( $values['messages']['error_font_color'] ); ?>;
$message_error_border_type : <?php echo ur_clean( $values['messages']['error_border_type'] ); ?>;
$message_error_border_color : <?php echo ur_clean( $values['messages']['error_border_color'] ); ?>;
$message_error_line_height : <?php echo ur_clean( $values['messages']['error_line_height'] ); ?>;

/**
 * Imports.
 */
@import "bourbon";

/**
 * Responsive.
 */
@mixin responsive-media( $property, $device, $values ) {
	@if $device == "desktop" {
		@include _directional-property( $property, null, $values );
	} @else if $device == "tablet" {
		@media only screen and (max-width: 768px) {
			@include _directional-property( $property, null, $values);
		}
	} @else if $device == "mobile" {
		@media only screen and (max-width: 500px) {
			@include _directional-property( $property, null, $values);
		}
	}
}

/**
 * Styling begins.
 */
#ur-frontend-form {
	&.login {
		width: $wrapper_width + '%';
		<?php if ( '' !== $values['wrapper']['font_family'] ) : ?>
			font-family: <?php echo ur_clean( $values['wrapper']['font_family'] ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $values['wrapper']['background_color'] ) ) : ?>
			background-color: <?php echo ur_clean( $values['wrapper']['background_color'] ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $values['wrapper']['background_image'] ) ) : ?>
			<?php printf( "background-image: url('%s');", esc_url( $values['wrapper']['background_image'] ) ); ?>
			<?php if ( '' !== $values['wrapper']['background_size'] ) : ?>
				background-size: <?php echo ur_clean( $values['wrapper']['background_size'] ); ?>;
			<?php endif; ?>
			<?php if ( isset( $values['wrapper']['background_position_x'], $values['wrapper']['background_position_y'] ) ) : ?>
				<?php printf( 'background-position: %s %s;', ur_clean( $values['wrapper']['background_position_x'] ), ur_clean( $values['wrapper']['background_position_y'] ) ); ?>
			<?php endif; ?>
			<?php foreach ( array( 'background_repeat', 'background_attachment' ) as $background_prop ) : ?>
				<?php if ( '' !== $values['wrapper'][ $background_prop ] ) : ?>
					<?php printf( '%s: %s;', str_replace( '_', '-', $background_prop ), ur_clean( $values['wrapper'][ $background_prop ] ) ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if ( isset( $values['wrapper']['border_type'] ) ) : ?>
			border-style: $wrapper_border_type;
			<?php if ( 'none' !== $values['wrapper']['border_type'] ) : ?>
				<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['wrapper']['border_width'], 'px' ) ); ?>
				border-color: $wrapper_border_color;
			<?php endif; ?>
		<?php endif; ?>
		<?php foreach ( $values['wrapper']['border_radius'] as $prop => $value ) : ?>
			<?php if ( 'unit' !== $prop && ! empty( $value ) ) : ?>
				<?php printf( '@include border-%s-radius(%s);', $prop, ur_clean( $value . $values['wrapper']['border_radius']['unit'] ) ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php foreach ( array( 'margin', 'padding' ) as $type ) : ?>
			<?php foreach ( $values['wrapper'][ $type ] as $device => $value ) : ?>
				<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
					<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endforeach; ?>

		.user-registration-form-row {
			> label {
				<?php if ( ! empty( $values['field_label']['font_color'] ) ) : ?>
				color: $field_label_font_color;
				<?php endif; ?>
				<?php if ( ! empty( $values['field_label']['font_size'] ) ) : ?>
				font-size: $field_label_font_size + 'px';
				<?php endif; ?>
				<?php foreach ( $font_styles as $prop => $value ) : ?>
					<?php if ( 'yes' === ur_bool_to_string( $values['field_label']['font_style'][ $value ] ) ) : ?>
						<?php printf( '%s: %s;', $prop, ur_clean( $value ) ); ?>
					<?php else : ?>
						<?php printf( '%s: %s;', $prop, ur_clean( $font_styles_default[ $prop ] ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
				text-align: $field_label_text_alignment;
				<?php if ( ! empty( $values['field_label']['line_height'] ) ) : ?>
				line-height: $field_label_line_height;
				<?php endif; ?>
				<?php foreach ( array( 'margin', 'padding' ) as $type ) : ?>
					<?php foreach ( $values['field_label'][ $type ] as $device => $value ) : ?>
						<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
							<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}

			input.input-text {
				<?php if ( ! empty( $values['field_styles']['font_color'] ) ) : ?>
				color: $field_styles_font_color;
				<?php endif; ?>
				<?php if ( ! empty( $values['field_styles']['font_size'] ) ) : ?>
				font-size: $field_styles_font_size + 'px';
				<?php endif; ?>
				<?php foreach ( $font_styles as $prop => $value ) : ?>
					<?php if ( 'yes' === ur_bool_to_string( $values['field_styles']['font_style'][ $value ] ) ) : ?>
						<?php printf( '%s: %s;', $prop, ur_clean( $value ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
				text-align: $field_styles_alignment;
				<?php if ( '' !== $values['field_styles']['background_color'] ) : ?>
					background-color: <?php echo ur_clean( $values['field_styles']['background_color'] ); ?>;
				<?php endif; ?>
				<?php if ( isset( $values['field_styles']['border_type'] ) ) : ?>
					border-style: $field_styles_border_type;
					<?php if ( 'none' !== $values['field_styles']['border_type'] ) : ?>
						<?php if ( ! empty( $values['field_styles']['border_color'] ) ) : ?>
						border-color: $field_styles_border_color;
						<?php endif; ?>
						<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['field_styles']['border_width'], 'px' ) ); ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php foreach ( $values['field_styles']['border_radius'] as $prop => $value ) : ?>
					<?php if ( 'unit' !== $prop && ! empty( $value ) ) : ?>
						<?php printf( '@include border-%s-radius(%s);', $prop, ur_clean( $value . $values['field_styles']['border_radius']['unit'] ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php foreach ( array( 'margin', 'padding' ) as $type ) : ?>
					<?php foreach ( $values['field_styles'][ $type ] as $device => $value ) : ?>
						<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
							<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>

				&:focus {
					<?php if ( 'none' !== $values['field_styles']['border_type'] ) : ?>
						<?php if ( ! empty( $values['field_styles']['border_focus_color'] ) ) : ?>
						border-color: $field_styles_border_focus_color;
						<?php endif; ?>
					<?php endif; ?>
				}
			}
		}

		.user-registration-form__label-for-checkbox {
			<?php if ( ! empty( $values['checkbox_radio_styles']['font_size'] ) ) : ?>
			font-size: $checkbox_styles__font_size + 'px';
			<?php endif; ?>
			<?php if ( ! empty( $values['checkbox_radio_styles']['font_color'] ) ) : ?>
			color: $checkbox_styles__font_color;
			<?php endif; ?>
			<?php foreach ( $font_styles as $prop => $value ) : ?>
				<?php if ( 'yes' === ur_bool_to_string( $values['checkbox_radio_styles']['font_style'][ $value ] ) ) : ?>
					<?php printf( '%s: %s;', $prop, ur_clean( $value ) ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php foreach ( array( 'margin', 'padding' ) as $type ) : ?>
					<?php foreach ( $values['checkbox_radio_styles'][ $type ] as $device => $value ) : ?>
						<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
							<?php
							if ( 'margin' === $type && 'two_columns' === $values['checkbox_radio_styles']['inline_style'] ) {
								$value['right'] = 0;
								$value['left']  = 0;
							}
							?>
							<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>

			input[type=checkbox] {
				<?php if ( 'default' === $values['checkbox_radio_styles']['style_variation'] ) { ?>
				<?php } elseif ( 'outline' === $values['checkbox_radio_styles']['style_variation'] ) { ?>
					width : $checkbox_styles__size + 'px';
					height : $checkbox_styles__size + 'px';
					display : inline-block;
					text-align : center;
					-webkit-appearance : none;
					border: 1px solid $checkbox_styles_color;

					&:checked {
						border-color: $checkbox_styles_checked_color;

						&::before {
							width: 25%;
							display: inline-block;
							border: solid $checkbox_styles_checked_color;
							border-width: 0 2px 2px 0;
							transform: rotate(45deg);
							margin-top: 12.5%;
						}
					}

				<?php } elseif ( 'filled' === $values['checkbox_radio_styles']['style_variation'] ) { ?>
					width : $checkbox_styles__size + 'px';
					height : $checkbox_styles__size + 'px';
					display : inline-block;
					text-align : center;
					-webkit-appearance : none;
					background-color : $checkbox_styles_color;

					&:checked {
						background-color: $checkbox_styles_checked_color;

						&::before {
							width: 25%;
							display: inline-block;
							border: solid #fff;
							border-width: 0 2px 2px 0;
							transform: rotate(45deg);
							margin-top: 12.5%;
						}
					}
				<?php } ?>

				&:checked {
					&::before {
						content: '';
						height: 50%;
					}
				}
			}
		}

		.form-row {
			input[type=submit].user-registration-Button {
				<?php if ( ! empty( $values['button']['font_color'] ) ) : ?>
				color: $button_font_color;
				<?php endif; ?>
				font-size: $button_font_size + 'px';
				<?php if ( ! empty( $values['button']['background_color'] ) ) : ?>
				background-color: $button_background_color;
				<?php endif; ?>
				line-height: $button_line_height;
				<?php foreach ( $font_styles as $prop => $value ) : ?>
					<?php if ( 'yes' === ur_bool_to_string( $values['button']['font_style'][ $value ] ) ) : ?>
						<?php printf( '%s: %s;', $prop, ur_clean( $value ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if ( isset( $values['button']['border_type'] ) ) : ?>
					<?php if ( ! empty( $values['button']['border_type'] ) ) : ?>
					border-style: $button_border_type;
					<?php endif; ?>
					<?php if ( 'none' !== $values['button']['border_type'] ) : ?>
						<?php if ( ! empty( $values['button']['border_color'] ) ) : ?>
						border-color: $button_border_color;
						<?php endif; ?>
						<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['button']['border_width'], 'px' ) ); ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php foreach ( $values['button']['border_radius'] as $prop => $value ) : ?>
					<?php if ( 'unit' !== $prop && ! empty( $value ) ) : ?>
						<?php printf( '@include border-%s-radius(%s);', $prop, ur_clean( $value . $values['button']['border_radius']['unit'] ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php foreach ( array( 'margin', 'padding' ) as $type ) : ?>
					<?php foreach ( $values['button'][ $type ] as $device => $value ) : ?>
						<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
							<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>

				&:hover,
				&:active {
					<?php if ( ! empty( $values['button']['hover_font_color'] ) ) : ?>
					color: $button_hover_font_color;
					<?php endif; ?>
					<?php if ( ! empty( $values['button']['hover_background_color'] ) ) : ?>
					background-color: $button_hover_background_color;
					<?php endif; ?>
					<?php if ( 'none' !== $values['button']['border_type'] ) : ?>
						<?php if ( ! empty( $values['button']['border_hover_color'] ) ) : ?>
						border-color: $button_border_hover_color;
						<?php endif; ?>
					<?php endif; ?>
				}
			}
		}
	}
}

#user-registration {
	> .user-registration-error {
		width: $wrapper_width + '%';
		color: $message_error_font_color;
		<?php if ( ! empty( $values['messages']['error_background_color'] ) ) : ?>
			background-color: <?php echo ur_clean( $values['messages']['error_background_color'] ); ?>;
		<?php endif; ?>
		font-size: $message_error_font_size + 'px';
		<?php if ( isset( $values['messages']['error_border_type'] ) ) : ?>
			border-style: $message_error_border_type;
			<?php if ( 'none' !== $values['messages']['error_border_type'] ) : ?>
				<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['messages']['error_border_width'], 'px' ) ); ?>
				border-color: $message_error_border_color;
			<?php endif; ?>
		<?php endif; ?>
		<?php foreach ( $values['messages']['error_border_radius'] as $prop => $value ) : ?>
			<?php if ( 'unit' !== $prop && ! empty( $value ) ) : ?>
				<?php printf( '@include border-%s-radius(%s);', $prop, ur_clean( $value . $values['messages']['error_border_radius']['unit'] ) ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
		line-height: $message_error_line_height;
	}
}
