<?php
/**
 * User Registration Field Style Config Functions
 *
 * @package User_Registration_Style_Customizer/Functions
 * @version 1.0.0
 */
defined( 'ABSPATH' ) || exit;
/**
 * Add user registration style customizer sections.
 *
 * @param array $sections Array of sections.
 */
function ur_style_customizer_field_styles_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'user_registration_field_styles' => array(
				'title'              => __( 'Field Styles', 'user-registration-style-customizer' ),
				'description'        => __( 'This is field styles description.', 'user-registration-style-customizer' ),
				'priority'           => 10,
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_style_customizer_sections', 'ur_style_customizer_field_styles_sections' );
/**
 * Add user registration style customizer controls.
 *
 * @param array $controls Array of controls.
 */
function ur_style_customizer_field_styles_controls( $controls ) {
	$controls['field_styles'] = array(
		'font_size'          => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Font Size', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field style font size in px.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 12,
					'max'  => 100,
					'step' => 1,
				),
			),
		),

		'font_color'         => array(
			'setting' => array(
				'default' => '',
			),
			'control' => array(
				'label'       => __( 'Font Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field style font color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Color_Control',
			),
		),

		'font_style'         => array(
			'setting' => array(
				'default' => array(
					'bold'      => false,
					'italic'    => false,
					'underline' => false,
					'uppercase' => false,
				),
			),
			'control' => array(
				'label'       => __( 'Font Style', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field style font style.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Image_Checkbox_Control',
				'choices'     => array(
					'bold'      => array(
						'name'  => __( 'Bold', 'user-registration-style-customizer' ),
						'image' => plugins_url( 'assets/images/bold.svg', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ),
					),
					'italic'    => array(
						'name'  => __( 'Italic', 'user-registration-style-customizer' ),
						'image' => plugins_url( 'assets/images/italic.svg', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ),
					),
					'underline' => array(
						'name'  => __( 'Underline', 'user-registration-style-customizer' ),
						'image' => plugins_url( 'assets/images/underline.svg', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ),
					),
					'uppercase' => array(
						'name'  => __( 'Uppercase', 'user-registration-style-customizer' ),
						'image' => plugins_url( 'assets/images/uppercase.svg', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ),
					),
				),
			),
		),

		'alignment'          => array(
			'setting' => array(
				'default'           => 'left',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Alignment', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field alignment.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Image_Radio_Control',
				'choices'     => array(
					'left'   => array(
						'name'  => __( 'Left', 'user-registration-style-customizer' ),
						'image' => plugins_url( 'assets/images/align-left.svg', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ),
					),
					'center' => array(
						'name'  => __( 'Center', 'user-registration-style-customizer' ),
						'image' => plugins_url( 'assets/images/align-center.svg', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ),
					),
					'right'  => array(
						'name'  => __( 'Right', 'user-registration-style-customizer' ),
						'image' => plugins_url( 'assets/images/align-right.svg', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ),
					),
				),
			),
		),

		'border_type'        => array(
			'setting' => array(
				'default'           => 'solid',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => __( 'Border Type', 'user-registration-style-customizer' ),
				'description' => __( 'This is form field border type', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
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

		'border_width'       => array(
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
				'description' => __( 'This is a form field border width.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Dimension_Control',
				'input_attrs' => array(
					'min' => 0,
				),
				'custom_args' => array(
					'anchor'     => true,
					'input_type' => 'number',
				),
			),
		),

		'border_color'       => array(
			'setting' => array(
				'default' => '',
			),
			'control' => array(
				'label'       => __( 'Border Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field style border color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Color_Control',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),

		'border_focus_color' => array(
			'setting' => array(
				'default' => '',
			),
			'control' => array(
				'label'       => __( 'Border Focus Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field style border color on focus.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Color_Control',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),

		'border_radius'      => array(
			'setting' => array(
				'default' => array(
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
					'unit'   => 'px',
				),
			),
			'control' => array(
				'label'       => __( 'Border Radius', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field border radius.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
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

		'background_color'   => array(
			'setting' => array(
				'default' => 'rgba(255,255,255,0.99)',
			),
			'control' => array(
				'label'       => __( 'Background Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field style background color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Color_Control',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),

		'margin'             => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 0,
						'right'  => 0,
						'bottom' => 10,
						'left'   => 0,
					),
				),
			),
			'control' => array(
				'label'       => __( 'Field Margin', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field margin.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
				'type'        => 'UR_Customize_Dimension_Control',
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),

		'padding'            => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 6,
						'right'  => 12,
						'bottom' => 6,
						'left'   => 12,
					),
				),
			),
			'control' => array(
				'label'       => __( 'Field Padding', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field padding.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_styles',
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
add_filter( 'user_registration_style_customizer_controls', 'ur_style_customizer_field_styles_controls' );
