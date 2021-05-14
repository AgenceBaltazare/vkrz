<?php
/**
 * User Registration Button Config Functions
 *
 * @package User_Registration_Style_Customizer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add user registration button customizer sections.
 *
 * @param array $sections Array of sections.
 */
function ur_style_customizer_button_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'user_registration_buttons' => array(
				'title'              => __( 'Button Styles', 'user-registration-style-customizer' ),
				'description'        => __( 'This is field labels description.', 'user-registration-style-customizer' ),
				'priority'           => 10,
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_style_customizer_sections', 'ur_style_customizer_button_sections' );

/**
 * Add user registration style customizer controls.
 *
 * @param array $controls Array of controls.
 */
function ur_style_customizer_button_controls( $controls ) {
	$controls['button'] = array(
		'font_size'              => array(
			'setting' => array(
				'default'           => '14',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Font Size', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button font size (px).', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
			),
		),
		'font_style'             => array(
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
				'description' => __( 'This is a form button font style.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
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
		'font_color'             => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Font Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button font color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'hover_font_color'       => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Hover Font Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button hover font color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'background_color'       => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Button Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'hover_background_color' => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Button Hover Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button hover color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'alignment'              => array(
			'setting' => array(
				'default'           => 'right',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Button Alignment', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button alignment.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
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
		'border_type'            => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => __( 'Border Type', 'user-registration-style-customizer' ),
				'description' => __( 'This is form button border type', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
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
		'border_width'           => array(
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
				'description' => __( 'This is a form button border width.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
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
		'border_color'           => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Border Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button style border color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'border_hover_color'     => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Border Hover Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button style border color in hover.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'border_radius'          => array(
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
				'description' => __( 'This is a button border radius.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
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
		'line_height'            => array(
			'setting' => array(
				'default'           => '1.5',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Line Height', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button line height.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 3,
					'step' => .01,
				),
			),
		),
		'margin'                 => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 0,
						'right'  => 0,
						'bottom' => 0,
						'left'   => 0,
					),
				),
			),
			'control' => array(
				'label'       => __( 'Button Margin', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button margin.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
				'type'        => 'UR_Customize_Dimension_Control',
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),
		'padding'                => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 10,
						'right'  => 20,
						'bottom' => 10,
						'left'   => 20,
					),
				),
			),
			'control' => array(
				'label'       => __( 'Button Padding', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form button padding.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_buttons',
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
add_filter( 'user_registration_style_customizer_controls', 'ur_style_customizer_button_controls' );
