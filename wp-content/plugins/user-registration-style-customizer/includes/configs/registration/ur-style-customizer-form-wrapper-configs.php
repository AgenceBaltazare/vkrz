<?php
/**
 * User Registration Form Wrapper Config Functions
 *
 * @package User_Registration_Style_Customizer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add user registration wrapper customizer sections
 *
 * @param array $sections Array of sections.
 */
function ur_style_customizer_form_wrapper_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'user_registration_wrapper' => array(
				'title'              => __( 'Form Wrapper', 'user-registration-style-customizer' ),
				'description'        => __( 'This is form wrapper description.', 'user-registration-style-customizer' ),
				'priority'           => 10,
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_style_customizer_sections', 'ur_style_customizer_form_wrapper_sections' );

/**
 * Add user reigstration style customizer controls.
 *
 * @param array                   $controls  Array of controls.
 * @param UR_Style_Customizer_API $customize UR_Style_Customizer_API instance.
 */
function ur_style_customizer_wrapper_controls( $controls, $customize ) {
	$controls['wrapper'] = array(
		'width'                 => array(
			'setting' => array(
				'default'           => '100',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Width', 'user-registration-style-customizer' ),
				'description' => __( 'Choose a form width (in %).', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 50,
					'max'  => 100,
					'step' => 1,
				),
			),
		),

		'font_family'           => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Font Family', 'user-registration-style-customizer' ),
				'description' => __( 'Select a desire Google font.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Select2_Control',
				'input_attrs' => array(
					'data-allow_clear' => true,
					'data-placeholder' => _x( 'Select Font Family&hellip;', 'enhanced select', 'user-registration-style-customizer' ),
				),
				'custom_args' => array(
					'google_font' => true,
				),
			),
		),

		'background_color'      => array(
			'setting' => array(
				'default' => '',
			),
			'control' => array(
				'label'       => __( 'Background Color', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Color_Control',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),

		'background_image'      => array(
			'setting' => array(
				'default'           => get_theme_support( 'custom-background', 'default-image' ),
				'theme_supports'    => 'custom-background',
				'sanitize_callback' => array( $customize, 'sanitize_background_setting' ),
			),
			'control' => array(
				'label'   => __( 'Background Image', 'user-registration-style-customizer' ),
				'section' => 'user_registration_wrapper',
				'type'    => 'UR_Customize_Background_Image_Control',
			),
		),

		'background_preset'     => array(
			'setting' => array(
				'default'           => get_theme_support( 'custom-background', 'default-preset' ),
				'theme_supports'    => 'custom-background',
				'sanitize_callback' => array( $customize, 'sanitize_background_setting' ),
			),
			'control' => array(
				'label'   => __( 'Background Preset', 'user-registration-style-customizer' ),
				'section' => 'user_registration_wrapper',
				'type'    => 'select',
				'choices' => array(
					'default' => _x( 'Default', 'Default Preset', 'user-registration-style-customizer' ),
					'fill'    => __( 'Fill Screen', 'user-registration-style-customizer' ),
					'fit'     => __( 'Fit to Screen', 'user-registration-style-customizer' ),
					'repeat'  => _x( 'Repeat', 'Repeat Image', 'user-registration-style-customizer' ),
					'custom'  => _x( 'Custom', 'Custom Preset', 'user-registration-style-customizer' ),
				),
			),
		),

		'background_position'   => array(
			'settings' => array(
				'background_position_x' => array(
					'default'           => get_theme_support( 'custom-background', 'default-position-x' ),
					'theme_supports'    => 'custom-background',
					'sanitize_callback' => array( $customize, 'sanitize_background_setting' ),
				),
				'background_position_y' => array(
					'default'           => get_theme_support( 'custom-background', 'default-position-y' ),
					'theme_supports'    => 'custom-background',
					'sanitize_callback' => array( $customize, 'sanitize_background_setting' ),
				),
			),
			'control'  => array(
				'label'    => __( 'Image Position', 'user-registration-style-customizer' ),
				'section'  => 'user_registration_wrapper',
				'type'     => 'WP_Customize_Background_Position_Control',
				'settings' => array(
					'x' => 'background_position_x',
					'y' => 'background_position_y',
				),
			),
		),

		'background_size'       => array(
			'setting' => array(
				'default'           => get_theme_support( 'custom-background', 'default-size' ),
				'theme_supports'    => 'custom-background',
				'sanitize_callback' => array( $customize, 'sanitize_background_setting' ),
			),
			'control' => array(
				'label'   => __( 'Image Size', 'user-registration-style-customizer' ),
				'section' => 'user_registration_wrapper',
				'type'    => 'select',
				'choices' => array(
					'auto'    => __( 'Original', 'user-registration-style-customizer' ),
					'contain' => __( 'Fit to Screen', 'user-registration-style-customizer' ),
					'cover'   => __( 'Fill Screen', 'user-registration-style-customizer' ),
				),
			),
		),

		'background_repeat'     => array(
			'setting' => array(
				'default'           => get_theme_support( 'custom-background', 'default-repeat' ),
				'theme_supports'    => 'custom-background',
				'sanitize_callback' => array( $customize, 'sanitize_background_setting' ),
			),
			'control' => array(
				'label'   => __( 'Repeat Background Image', 'user-registration-style-customizer' ),
				'section' => 'user_registration_wrapper',
				'type'    => 'checkbox',
			),
		),

		'background_attachment' => array(
			'setting' => array(
				'default'           => get_theme_support( 'custom-background', 'default-attachment' ),
				'theme_supports'    => 'custom-background',
				'sanitize_callback' => array( $customize, 'sanitize_background_setting' ),
			),
			'control' => array(
				'label'   => __( 'Scroll with Page', 'user-registration-style-customizer' ),
				'section' => 'user_registration_wrapper',
				'type'    => 'checkbox',
			),
		),

		'border_type'           => array(
			'setting' => array(
				'default'           => 'solid',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => __( 'Border Type', 'user-registration-style-customizer' ),
				'description' => __( 'This is form wrapper border type', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'choices'     => array(
					'none'    => __( 'None', 'user-registration-style-customizer' ),
					'hidden'  => __( 'Hidden', 'user-registration-style-customizer' ),
					'dotted'  => __( 'Dotted', 'user-registration-style-customizer' ),
					'dashed'  => __( 'Dashed', 'user-registration-style-customizer' ),
					'solid'   => __( 'Solid', 'user-registration-style-customizer' ),
					'double'  => __( 'Double', 'user-registration-style-customizer' ),
					'groove'  => __( 'Groove', 'user-registration-style-customizer' ),
					'ridge'   => __( 'Ridge', 'user-registration-style-customizer' ),
					'inset'   => __( 'Inset', 'user-registration-style-customizer' ),
					'outset'  => __( 'Outset', 'user-registration-style-customizer' ),
					'initial' => __( 'Initial', 'user-registration-style-customizer' ),
					'inherit' => __( 'Inherit', 'user-registration-style-customizer' ),
				),
			),
		),

		'border_width'          => array(
			'setting' => array(
				'default' => array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
			),
			'control' => array(
				'label'       => __( 'Border Width', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form wrapper border width.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Dimension_Control',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 50,
					'step' => 1,
				),
				'custom_args' => array(
					'anchor'     => true,
					'input_type' => 'number',
				),
			),
		),

		'border_color'          => array(
			'setting' => array(
				'default' => '#ddd',
			),
			'control' => array(
				'label'       => __( 'Border Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form border color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Color_Control',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),

		'border_radius'         => array(
			'setting' => array(
				'default' => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
					'unit'   => 'px',
				),
			),
			'control' => array(
				'label'       => __( 'Border Radius', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form border radius.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Dimension_Control',
				'input_attrs' => array(
					'min' => 0,
				),
				'custom_args' => array(
					'anchor'       => true,
					'input_type'   => 'number',
					'unit_choices' => array(
						'px' => esc_attr__( 'PX', 'user-registration-style-customizer' ),
						'%'  => esc_attr__( '%', 'user-registration-style-customizer' ),
					),
				),
			),
		),

		'margin'                => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 0,
						'right'  => 0,
						'bottom' => 30,
						'left'   => 0,
					),
				),
			),
			'control' => array(
				'label'       => __( 'Form Margin', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form margin.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Dimension_Control',
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),

		'padding'               => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 20,
						'right'  => 20,
						'bottom' => 20,
						'left'   => 20,
					),
				),
			),
			'control' => array(
				'label'       => __( 'Form Padding', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form padding.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_wrapper',
				'type'        => 'UR_Customize_Dimension_Control',
				'input_attrs' => array(
					'min' => 0,
				),
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),
	);
	return $controls;
}
add_filter( 'user_registration_style_customizer_controls', 'ur_style_customizer_wrapper_controls', 10, 2 );
