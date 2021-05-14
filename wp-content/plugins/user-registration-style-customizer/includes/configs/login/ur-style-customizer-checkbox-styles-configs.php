<?php
/**
 * User Registration Radio and Checkbox Style Config Functions
 *
 * @package User_Registration_Style_Customizer/Functions
 * @version 1.0.0
 */
defined( 'ABSPATH' ) || exit;
/**
 * Add user registration button customizer sections
 *
 * @param array $sections Array of sections.
 */
function ur_style_customizer_checkbox_styles_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'user_registration_checkbox_style' => array(
				'title'              => __( 'Checkbox Style', 'user-registration-style-customizer' ),
				'description'        => __( 'This is checkbox style description.', 'user-registration-style-customizer' ),
				'priority'           => 10,
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_style_customizer_sections', 'ur_style_customizer_checkbox_styles_sections' );
/**
 * Add user registration style customizer controls.
 *
 * @param array $controls Array of controls.
 */
function ur_style_customizer_checkbox_styles_controls( $controls ) {
	$controls['checkbox_radio_styles'] = array(
		'font_size'       => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Font Size', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form checkbox/radio font size (px).', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 12,
					'max'  => 50,
					'step' => 1,
				),
			),
		),
		'font_color'      => array(
			'setting' => array(
				'default' => '',
			),
			'control' => array(
				'label'       => __( 'Font Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form checkbox/radio font color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'font_style'      => array(
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
				'description' => __( 'This is a form checkbox/radio font style.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
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
		'style_variation' => array(
			'setting' => array(
				'default' => 'default',
			),
			'control' => array(
				'label'       => __( 'Style Variation', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form radio/checkbox style variation.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
				'type'        => 'radio',
				'choices'     => array(
					'default' => __( 'Default', 'user-registration-style-customizer' ),
					'outline' => __( 'Outline', 'user-registration-style-customizer' ),
					'filled'  => __( 'Filled', 'user-registration-style-customizer' ),
				),
			),
		),
		'size'            => array(
			'setting' => array(
				'default'           => '18',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Radio & Checkbox Size', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form checkbox/radio size (px).', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 18,
					'max'  => 50,
					'step' => 1,
				),
			),
		),
		'color'           => array(
			'setting' => array(
				'default' => '#575757',
			),
			'control' => array(
				'label'       => __( 'Checkbox Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form checkbox/radio color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'checked_color'   => array(
			'setting' => array(
				'default' => '#575757',
			),
			'control' => array(
				'label'       => __( 'Checkbox Checked Color', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form checkbox/radio checked color.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
				'type'        => 'UR_Customize_Color_Control',
			),
		),
		'margin'          => array(
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
				'label'       => __( 'Checkbox Margin', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form radio/checkbox margin.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
				'type'        => 'UR_Customize_Dimension_Control',
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),
		'padding'         => array(
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
				'label'       => __( 'Checkbox Margin', 'user-registration-style-customizer' ),
				'description' => __( 'This is a form radio/checkbox padding.', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_checkbox_style',
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
add_filter( 'user_registration_style_customizer_controls', 'ur_style_customizer_checkbox_styles_controls' );
