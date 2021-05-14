<?php
/**
 * User Registration Customize My Account SCSS
 *
 * @package User_Registration_Customize_My_Account
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Get values.
$styles = get_option( 'user_registration_customize_my_account' );

if ( ! isset( $styles ) ) {
	$values = $defaults;
} else {
	$values = array_replace_recursive( $defaults, array_map( 'array_filter', $styles ) ); // phpcs:ignore PHPCompatibility.PHP.NewFunctions.array_replace_recursiveFound
}
?>

// Wrapper variables
$wrapper_border_type : <?php echo ur_clean( $values['wrapper']['border_type'] ); ?>;
<?php if ( ! empty( $values['wrapper']['border_color'] ) ) : ?>
$wrapper_border_color : <?php echo ur_clean( $values['wrapper']['border_color'] ); ?>;
<?php endif; ?>

//Color variables
<?php if ( ! empty( $values['color']['heading'] ) ) : ?>
$color_heading: <?php echo ur_clean( $values['color']['heading'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['color']['body'] ) ) : ?>
$color_body: <?php echo ur_clean( $values['color']['body'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['color']['link'] ) ) : ?>
$color_link: <?php echo ur_clean( $values['color']['link'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['color']['link_hover'] ) ) : ?>
$color_link-hover: <?php echo ur_clean( $values['color']['link_hover'] ); ?>;
<?php endif; ?>

// Navigation variables
$nav_wrap_width: <?php echo absint( $values['navigation']['nav_wrapper_width'] ); ?>;
$nav_wrap_border_type : <?php echo ur_clean( $values['navigation']['nav_wrapper_border_type'] ); ?>;
<?php if ( ! empty( $values['navigation']['nav_wrapper_border_color'] ) ) : ?>
$nav_wrap_border_color : <?php echo ur_clean( $values['navigation']['nav_wrapper_border_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['navigation']['nav_link_text_color'] ) ) : ?>
$nav_link_text_color: <?php echo ur_clean( $values['navigation']['nav_link_text_color'] ); ?>;
<?php endif; ?>
$nav_link_border_type : <?php echo ur_clean( $values['navigation']['nav_link_border_type'] ); ?>;
<?php if ( ! empty( $values['navigation']['nav_link_border_color'] ) ) : ?>
$nav_link_border_color : <?php echo ur_clean( $values['navigation']['nav_link_border_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['navigation']['hover_text_color'] ) ) : ?>
$nav_link_hover_text_color: <?php echo ur_clean( $values['navigation']['hover_text_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['navigation']['hover_nav_link_border_color'] ) ) : ?>
$nav_link_hover_border_color : <?php echo ur_clean( $values['navigation']['hover_nav_link_border_color'] ); ?>;
<?php endif; ?>

// Buttons variables
<?php if ( ! empty( $values['button']['button_font_size'] ) ) : ?>
$button_font_size: <?php echo ur_clean( $values['button']['button_font_size'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['button']['font_color'] ) ) : ?>
$button_font_color: <?php echo ur_clean( $values['button']['font_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['button']['button_hover_text_color'] ) ) : ?>
$button_hover_font_color: <?php echo ur_clean( $values['button']['button_hover_text_color'] ); ?>;
<?php endif; ?>

// Field Labels variables
<?php if ( ! empty( $values['form']['label_color'] ) ) : ?>
$field_label_font_color: <?php echo ur_clean( $values['form']['label_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['form']['label_font_size'] ) ) : ?>
$field_label_font_size: <?php echo ur_clean( $values['form']['label_font_size'] ); ?>;
<?php endif; ?>

// Fields input field variables
<?php if ( ! empty( $values['form']['input_text_color'] ) ) : ?>
$field_input_font_color: <?php echo ur_clean( $values['form']['input_text_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['form']['input_focus_text_color'] ) ) : ?>
$field_input_font_focus_color: <?php echo ur_clean( $values['form']['input_focus_text_color'] ); ?>;
<?php endif; ?>
$field_input_border_type : <?php echo ur_clean( $values['form']['input_border_type'] ); ?>;
<?php if ( ! empty( $values['form']['input_border_color'] ) ) : ?>
$field_input_border_color : <?php echo ur_clean( $values['form']['input_border_color'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $values['form']['input_focus_border_color'] ) ) : ?>
$field_input_border_focus_color: <?php echo ur_clean( $values['form']['input_focus_border_color'] ); ?>;
<?php endif; ?>

// Field Choices (checkbox/radio) variables
<?php if ( ! empty( $values['form']['choice_font_color'] ) ) : ?>
$field_label_choice_color: <?php echo ur_clean( $values['form']['choice_font_color'] ); ?>;
<?php endif; ?>
$field_label_choice_size: <?php echo ur_clean( $values['form']['choice_font_size'] ); ?>;

// Border radius variables parser
<?php $wrapper_border_radius_values = array(); ?>
<?php foreach ( $values['wrapper']['border_radius'] as $prop => $value ) : ?>
	<?php if ( 'unit' !== $prop ) : ?>
		<?php array_push( $wrapper_border_radius_values, $value . $values['wrapper']['border_radius']['unit'] ); ?>
	<?php endif; ?>
<?php endforeach ?>
<?php $nav_wrapper_border_radius_values = array(); ?>
<?php foreach ( $values['navigation']['nav_wrapper_border_radius'] as $prop => $value ) : ?>
	<?php if ( 'unit' !== $prop ) : ?>
		<?php array_push( $nav_wrapper_border_radius_values, $value . $values['navigation']['nav_wrapper_border_radius']['unit'] ); ?>
	<?php endif; ?>
<?php endforeach ?>
<?php $nav_link_border_radius_values = array(); ?>
<?php foreach ( $values['navigation']['nav_link_border_radius'] as $prop => $value ) : ?>
	<?php if ( 'unit' !== $prop ) : ?>
		<?php array_push( $nav_link_border_radius_values, $value . $values['navigation']['nav_link_border_radius']['unit'] ); ?>
	<?php endif; ?>
<?php endforeach ?>
<?php $form_input_border_radius_values = array(); ?>
<?php foreach ( $values['form']['input_border_radius'] as $prop => $value ) : ?>
	<?php if ( 'unit' !== $prop ) : ?>
		<?php array_push( $form_input_border_radius_values, $value . $values['form']['input_border_radius']['unit'] ); ?>
	<?php endif; ?>
<?php endforeach ?>

/**
 * Imports.
 */
@import "bourbon";
@import "../variables";

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
.logged-in.user-registration-account {
	#user-registration {
		<?php if ( '' !== $values['wrapper']['background_color'] ) : ?>
			background-color: <?php echo ur_clean( $values['wrapper']['background_color'] ); ?>;
			<?php else : ?>
				background-color: #ffffff;
		<?php endif; ?>
		<?php if ( ! empty( $values['color']['body'] ) ) : ?>
			color: $color_body;
		<?php endif; ?>
		<?php if ( isset( $values['wrapper']['border_type'] ) ) : ?>
			border-style: $wrapper_border_type;
			<?php if ( 'none' !== $values['wrapper']['border_type'] ) : ?>
				<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['wrapper']['border_width'], 'px' ) ); ?>
				<?php if ( ! empty( $values['wrapper']['border_color'] ) ) : ?>
					border-color: $wrapper_border_color;
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
		border-radius: <?php echo implode( ' ', $wrapper_border_radius_values ); ?>;
		<?php foreach ( array( 'margin' ) as $type ) : ?>
			<?php foreach ( $values['wrapper'][ $type ] as $device => $value ) : ?>
				<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
					<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endforeach; ?>

		h2, h3, h4, h5, h6 {
			<?php if ( ! empty( $values['color']['heading'] ) ) : ?>
				color: $color_heading;
			<?php endif; ?>
		}

		p {
			<?php if ( ! empty( $values['color']['body'] ) ) : ?>
				color: $color_body;
			<?php endif; ?>
		}

		a {
			<?php if ( ! empty( $values['color']['link'] ) ) : ?>
				color: $color_link;
			<?php endif; ?>

			&:hover {
				<?php if ( ! empty( $values['color']['link_hover'] ) ) : ?>
					color: $color_link-hover;
				<?php endif; ?>
			}
		}

		.user-registration-MyAccount-navigation {
			<?php if ( '' !== $values['navigation']['nav_wrapper_background_color'] ) : ?>
				background-color: <?php echo ur_clean( $values['navigation']['nav_wrapper_background_color'] ); ?>;
				<?php else : ?>
					background-color: #ffffff;
			<?php endif; ?>
			<?php if ( isset( $values['navigation']['nav_wrapper_border_type'] ) ) : ?>
				<?php if ( 'none' !== $values['navigation']['nav_wrapper_border_type'] ) : ?>
					border-style: $nav_wrap_border_type;
					<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['navigation']['nav_wrapper_border_width'], 'px' ) ); ?>
					<?php if ( ! empty( $values['navigation']['nav_wrapper_border_color'] ) ) : ?>
						border-color: $nav_wrap_border_color;
					<?php endif; ?>
				<?php endif; ?>
				<?php else : ?>
					<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( array( 0, 0, 10, 0 ), 'px' ) ); ?>
			<?php endif; ?>
			border-radius: <?php echo implode( ' ', $nav_wrapper_border_radius_values ); ?>;

			ul {
				.user-registration-MyAccount-navigation-link {
					a {
						<?php if ( '' !== $values['navigation']['nav_link_background_color'] ) : ?>
							background-color: <?php echo ur_clean( $values['navigation']['nav_link_background_color'] ); ?>;
						<?php else : ?>
							background-color: #ffffff;
						<?php endif; ?>
						<?php if ( ! empty( $values['navigation']['nav_link_text_color'] ) ) : ?>
							color: $nav_link_text_color;
						<?php endif; ?>
						<?php if ( isset( $values['navigation']['nav_link_border_type'] ) ) : ?>
							border-style: $nav_link_border_type;
							<?php if ( 'none' !== $values['navigation']['nav_link_border_type'] ) : ?>
								<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['navigation']['nav_link_border_width'], 'px' ) ); ?>
								<?php if ( ! empty( $values['navigation']['nav_link_border_color'] ) ) : ?>
									border-color: $nav_link_border_color;
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
						border-radius: <?php echo implode( ' ', $nav_link_border_radius_values ); ?>;
						<?php foreach ( array( 'padding' ) as $type ) : ?>
							<?php foreach ( $values['navigation']['padding'] as $device => $value ) : ?>
								<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
									<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endforeach; ?>

						&:hover {
							<?php if ( '' !== $values['navigation']['hover_background_color'] ) : ?>
								background-color: <?php echo ur_clean( $values['navigation']['hover_background_color'] ); ?>;
							<?php else : ?>
								background-color: #ffffff;
							<?php endif; ?>
							<?php if ( ! empty( $values['navigation']['hover_text_color'] ) ) : ?>
								color : $nav_link_hover_text_color;
							<?php endif; ?>
							<?php if ( 'none' !== $values['navigation']['nav_link_border_type'] ) : ?>
								<?php if ( ! empty( $values['navigation']['hover_nav_link_border_color'] ) ) : ?>
									border-color: $nav_link_hover_border_color;
								<?php endif; ?>
							<?php endif; ?>
						}
					}

					&.is-active {
						a {
							<?php if ( '' !== $values['navigation']['hover_background_color'] ) : ?>
								background-color: <?php echo ur_clean( $values['navigation']['hover_background_color'] ); ?>;
							<?php else : ?>
								background-color: #ffffff;
							<?php endif; ?>
							<?php if ( ! empty( $values['navigation']['hover_text_color'] ) ) : ?>
								color : $nav_link_hover_text_color;
							<?php endif; ?>
							<?php if ( 'none' !== $values['navigation']['nav_link_border_type'] ) : ?>
								<?php if ( ! empty( $values['navigation']['hover_nav_link_border_color'] ) ) : ?>
								border-color: $nav_link_hover_border_color;
								<?php endif; ?>
							<?php endif; ?>
						}
					}
				}
			}
		}

		&.vertical {
			.user-registration-MyAccount-navigation {
				width: $nav_wrap_width + '%';
				<?php if ( '' !== $values['navigation']['nav_wrapper_background_color'] ) : ?>
					background-color: <?php echo ur_clean( $values['navigation']['nav_wrapper_background_color'] ); ?>;
					<?php else : ?>
						background-color: #f0f1f5;
				<?php endif; ?>

				ul {
					.user-registration-MyAccount-navigation-link {
						a {
							<?php if ( '' !== $values['navigation']['nav_link_background_color'] ) : ?>
								background-color: <?php echo ur_clean( $values['navigation']['nav_link_background_color'] ); ?>;
							<?php else : ?>
								background-color: #f0f1f5;
							<?php endif; ?>
							<?php if ( isset( $values['navigation']['nav_link_border_type'] ) ) : ?>
								border-style: $nav_link_border_type;
								<?php if ( 'none' !== $values['navigation']['nav_link_border_type'] ) : ?>
									<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['navigation']['nav_link_border_width'], 'px' ) ); ?>
									border-color: $nav_link_border_color;
								<?php endif; ?>
							<?php endif; ?>

							&:hover {
								<?php if ( '' !== $values['navigation']['hover_background_color'] ) : ?>
									background-color: <?php echo ur_clean( $values['navigation']['hover_background_color'] ); ?>;
								<?php else : ?>
									background-color: #f0f1f5;
								<?php endif; ?>
								<?php if ( ! empty( $values['navigation']['hover_text_color'] ) ) : ?>
									color : $nav_link_hover_text_color;
								<?php endif; ?>
								<?php if ( 'none' !== $values['navigation']['nav_link_border_type'] ) : ?>
									<?php if ( ! empty( $values['navigation']['hover_nav_link_border_color'] ) ) : ?>
									border-color: $nav_link_hover_border_color;
									<?php endif; ?>
								<?php endif; ?>
							}
						}

						&.is-active {
							a {
								<?php if ( '' !== $values['navigation']['hover_background_color'] ) : ?>
									background-color: <?php echo ur_clean( $values['navigation']['hover_background_color'] ); ?>;
								<?php else : ?>
									background-color: #dee0e9;
								<?php endif; ?>
								<?php if ( ! empty( $values['navigation']['hover_text_color'] ) ) : ?>
									color : $nav_link_hover_text_color;
								<?php endif; ?>
								<?php if ( 'none' !== $values['navigation']['nav_link_border_type'] ) : ?>
									<?php if ( ! empty( $values['navigation']['hover_nav_link_border_color'] ) ) : ?>
									border-color: $nav_link_hover_border_color;
									<?php endif; ?>
								<?php endif; ?>
							}
						}
					}
				}
			}

			.user-registration-MyAccount-content {
				width: 100 - $nav_wrap_width + '%';
			}
		}

		&.horizontal {
			.user-registration-MyAccount-navigation {
				<?php if ( isset( $values['navigation']['nav_wrapper_border_type'] ) ) : ?>
					<?php if ( 'none' !== $values['navigation']['nav_wrapper_border_type'] ) : ?>
						border-style: $nav_wrap_border_type;
						<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['navigation']['nav_wrapper_border_width'], 'px' ) ); ?>
						<?php if ( ! empty( $values['navigation']['nav_wrapper_border_color'] ) ) : ?>
							border-color: $nav_wrap_border_color;
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				border-radius: <?php echo implode( ' ', $nav_wrapper_border_radius_values ); ?>;

				ul {
					.user-registration-MyAccount-navigation-link {
						&.is-active {
							a {
								<?php if ( '' !== $values['navigation']['hover_background_color'] ) : ?>
									background-color: <?php echo ur_clean( $values['navigation']['hover_background_color'] ); ?>;
								<?php else : ?>
									background-color: #f0f1f5;
								<?php endif; ?>
							}
						}
					}
				}
			}
		}

		// My Account main content
		.user-registration-MyAccount-content {
			<?php foreach ( array( 'padding' ) as $type ) : ?>
				<?php foreach ( $values['wrapper']['content_padding'] as $device => $value ) : ?>
					<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
						<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
		}

		.ur-form-row {
			label {
				<?php if ( ! empty( $values['form']['label_color'] ) ) : ?>
					color: $field_label_font_color;
				<?php endif; ?>
				<?php if ( ! empty( $values['form']['label_font_size'] ) ) : ?>
					font-size: $field_label_font_size + 'px';
				<?php endif; ?>
				<?php foreach ( array( 'margin' ) as $type ) : ?>
					<?php foreach ( $values['form']['label_margin'] as $device => $value ) : ?>
						<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
							<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}

			input[type="text"],
			.ur-edit-profile-field:not(.input-checkbox):not(.input-radio),
			.user-registration-Input {
				<?php if ( '' !== $values['form']['input_background_color'] ) : ?>
					background-color: <?php echo ur_clean( $values['form']['input_background_color'] ); ?>;
					<?php else : ?>
						background-color: #ffffff;
				<?php endif; ?>
				<?php if ( ! empty( $values['form']['input_text_color'] ) ) : ?>
					color: $field_input_font_color;
				<?php endif; ?>
				<?php if ( isset( $values['form']['input_border_type'] ) ) : ?>
					<?php if ( 'none' !== $values['form']['input_border_type'] ) : ?>
						border-style: $field_input_border_type;
						<?php printf( '@include border-width(%s);', ur_sanitize_dimension_unit( $values['form']['input_border_width'], 'px' ) ); ?>
						<?php if ( ! empty( $values['form']['input_border_color'] ) ) : ?>
							border-color: $field_input_border_color;
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				border-radius: <?php echo implode( ' ', $form_input_border_radius_values ); ?>;

				<?php foreach ( array( 'padding' ) as $type ) : ?>
					<?php foreach ( $values['form']['input_padding'] as $device => $value ) : ?>
						<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
							<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>

				&:focus {
					<?php if ( '' !== $values['form']['input_focus_background_color'] ) : ?>
						background-color: <?php echo ur_clean( $values['form']['input_focus_background_color'] ); ?>;
						<?php else : ?>
						background-color: #ffffff;
					<?php endif; ?>
					<?php if ( ! empty( $values['form']['input_focus_text_color'] ) ) : ?>
						color: $field_input_font_focus_color;
					<?php endif; ?>
					<?php if ( ! empty( $values['form']['input_focus_border_color'] ) ) : ?>
						border-color: $field_input_border_focus_color;
					<?php endif; ?>
				}
			}

			.ur-checkbox-list,
			.ur-radio-list {
				label {
					<?php if ( ! empty( $values['form']['choice_font_color'] ) ) : ?>
						color: $field_label_choice_color;
					<?php endif; ?>
					font-size: $field_label_choice_size + 'px';
				}
				<?php foreach ( array( 'margin' ) as $type ) : ?>
					<?php foreach ( $values['form']['choice_margin'] as $device => $value ) : ?>
						<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
							<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				}
			}

		// Button
		.button {
			<?php if ( ! empty( $values['button']['button_font_size'] ) ) : ?>
				font-size: $button_font_size + 'px';
			<?php endif; ?>
			<?php if ( '' !== $values['button']['button_background_color'] ) : ?>
				background-color: <?php echo ur_clean( $values['button']['button_background_color'] ); ?>;
				<?php else : ?>
					background-color: #ffffff;
			<?php endif; ?>
			<?php if ( ! empty( $values['button']['font_color'] ) ) : ?>
				color: $button_font_color;
			<?php endif; ?>
			<?php foreach ( array( 'margin', 'padding' ) as $type ) : ?>
				<?php foreach ( $values['button'][ $type ] as $device => $value ) : ?>
					<?php if ( in_array( $device, array( 'desktop', 'tablet', 'mobille' ), true ) ) : ?>
						<?php printf( '@include responsive-media(%s, %s, %s);', $type, $device, ur_sanitize_dimension_unit( $value, 'px' ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>

			&:hover {
				<?php if ( '' !== $values['button']['button_hover_background_color'] ) : ?>
					background-color: <?php echo ur_clean( $values['button']['button_hover_background_color'] ); ?>;
					<?php else : ?>
						background-color: #ffffff;
				<?php endif; ?>
				<?php if ( ! empty( $values['button']['button_hover_text_color'] ) ) : ?>
					color: $button_hover_font_color;
				<?php endif; ?>
			}
		}
	}
}

@media screen and (max-width: 980px) {
	#user-registration {
		&.vertical {
			.user-registration-MyAccount-navigation {
				width: 30%;
			}

			.user-registration-MyAccount-content {
				width: 70%;
			}
		}
	}
}

@media screen and (max-width: 600px) {
	#user-registration {
		&.vertical {
			.user-registration-MyAccount-navigation {
				width: 100%;

				ul {
					.user-registration-MyAccount-navigation-link {
						a {
							padding: 15px 20px;
						}
					}
				}
			}

			.user-registration-MyAccount-content {
				width: 100%;
			}
		}

		.user-registration-MyAccount-content {
			padding: 15px;
		}
	}
}
