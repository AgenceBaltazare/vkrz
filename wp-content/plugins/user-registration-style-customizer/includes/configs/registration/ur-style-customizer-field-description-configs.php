<?php
/**
 * User Registration Field Description Config Functions
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
function ur_style_customizer_field_description_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'user_registration_field_description' => array(
				'title'              => __( 'Field Description', 'user-registration-style-customizer' ),
				'description'        => __( 'This is field description section.', 'user-registration-style-customizer' ),
				'priority'           => 10,
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_style_customizer_sections', 'ur_style_customizer_field_description_sections' );
/**
 * Add user registration style customizer controls.
 *
 * @param array $controls Array of controls.
 */
function ur_style_customizer_field_description_controls( $controls ) {
	$controls['field_description'] = array(
		'font_size'      => array(
			'setting' => array(
				'default'           => '12',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Font Size', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field description font size (px).', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_description',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 50,
					'step' => 1,
				),
			),
		),
		'font_color'     => array(
			'setting' => array(
				'default' => '',
			),
			'control' => array(
				'label'       => __( 'Font Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field description font color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_description',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'font_style'     => array(
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
				'description' => __( 'This is a form field description font style.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_description',
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
		'text_alignment' => array(
			'setting' => array(
				'default'           => 'left',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Text Alignment', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field description text alignment.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_description',
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
		'line_height'    => array(
			'setting' => array(
				'default'           => '1.25',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Line Height', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field description line height.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_description',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 3,
					'step' => .01,
				),
			),
		),
		'margin'         => array(
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
				'label'       => __( 'Margin', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field description margin.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_description',
				'type'        => 'UR_Customize_Dimension_Control',
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),
		'padding'        => array(
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
				'label'       => __( 'Padding', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form field description padding.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_field_description',
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
add_filter( 'user_registration_style_customizer_controls', 'ur_style_customizer_field_description_controls' );
