<?php
/**
 * User Registration Messages Config Functions
 *
 * @package User_Registration_Style_Customizer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add user registration messages customizer sections
 *
 * @param array $sections Array of sections.
 */
function ur_style_customizer_messages_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'user_registration_messages' => array(
				'title'              => __( 'Messages', 'user-registration-style-customizer' ),
				'description'        => __( 'This is messages description.', 'user-registration-style-customizer' ),
				'priority'           => 10,
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_style_customizer_sections', 'ur_style_customizer_messages_sections' );

/**
 * Add user reigstration style customizer controls.
 *
 * @param array                   $controls  Array of controls.
 * @param UR_Style_Customizer_API $customize UR_Style_Customizer_API instance.
 */
function ur_style_customizer_messages_controls( $controls ) {
	$controls['messages'] = array(
		'show_error_message'     => array(
			'setting' => array(
				'default' => false,
			),
			'control' => array(
				'label'   => __( 'Show Error Message', 'user-registration-style-customizer' ),
				'section' => 'user_registration_messages',
				'type'    => 'UR_Customize_Toggle_Control',
			),
		),

		'error_font_size'        => array(
			'setting' => array(
				'default'           => '14',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Font Size', 'user-registration-style-customizer' ),
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 12,
					'max'  => 100,
					'step' => 1,
				),
			),
		),

		'error_font_color'       => array(
			'setting' => array(
				'default' => '#f4000a',
			),
			'control' => array(
				'label'       => __( 'Font Color', 'user-registration-style-customizer' ),
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
				'type'        => 'UR_Customize_Color_Control',
			),
		),

		'error_background_color' => array(
			'setting' => array(
				'default' => 'rgba(255,65,73,.1)',
			),
			'control' => array(
				'label'       => __( 'Background Color', 'user-registration-style-customizer' ),
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
				'type'        => 'UR_Customize_Color_Control',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),

		'error_border_type'      => array(
			'setting' => array(
				'default'           => 'solid',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => __( 'Border Type', 'user-registration-style-customizer' ),
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
				'choices'     => array(
					'none'   => __( 'None', 'user-registration-style-customizer' ),
					'dotted' => __( 'Dotted', 'user-registration-style-customizer' ),
					'dashed' => __( 'Dashed', 'user-registration-style-customizer' ),
					'solid'  => __( 'Solid', 'user-registration-style-customizer' ),
				),
			),
		),

		'error_border_width'     => array(
			'setting' => array(
				'default' => array(
					'top'    => 3,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
				),
			),
			'control' => array(
				'label'       => __( 'Border Width', 'user-registration-style-customizer' ),
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
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

		'error_border_color'     => array(
			'setting' => array(
				'default' => '#ff4149',
			),
			'control' => array(
				'label'       => __( 'Border Color', 'user-registration-style-customizer' ),
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
				'type'        => 'UR_Customize_Color_Control',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),

		'error_border_radius'    => array(
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
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
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

		'error_line_height'      => array(
			'setting' => array(
				'default'           => '1.25',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => __( 'Line Height', 'user-registration-style-customizer' ),
				'description' => __( '', 'user-registration-style-customizer' ),
				'section'     => 'user_registration_messages',
				'type'        => 'UR_Customize_Slider_Control',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 3,
					'step' => .01,
				),
			),
		),
	);
	return $controls;
}
add_filter( 'user_registration_style_customizer_controls', 'ur_style_customizer_messages_controls', 10, 2 );
