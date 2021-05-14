<?php
/**
 * User Registration Customizer My Account Form Configs.
 *
 * @package User_Registration_Customize_My_Account\Admin\Customizer\Config
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add User Registration Customize My Account Header Panels.
 *
 * @param array $panels Array of panels.
 */
function user_registration_customize_my_account_form_panels( $panels ) {
	return array_merge(
		$panels,
		array(
			'urcma_form' => array(
				'title'       => esc_html__( 'Forms', 'user-registration-customize-my-account' ),
				'description' => '',
				'priority'    => 30,
			),
		)
	);
}
add_filter( 'user_registration_customize_my_account_panels', 'user_registration_customize_my_account_form_panels' );

/**
 * Add User Registration Customizer My Account Form Sections.
 *
 * @param array $sections Array of sections.
 * @since 1.1.0
 */
function user_registration_customize_my_account_form_sections( $sections ) {

	return array_merge(
		$sections,
		array(
			'urcma_form_field_labels'    => array(
				'title'              => esc_html__( 'Field Labels', 'user-registration-customize-my-account' ),
				'description'        => '',
				'priority'           => 10,
				'panel'              => 'urcma_form',
				'description_hidden' => true,
			),
			'urcma_form_field_styles'    => array(
				'title'              => esc_html__( 'Field Styles', 'user-registration-customize-my-account' ),
				'description'        => '',
				'priority'           => 10,
				'panel'              => 'urcma_form',
				'description_hidden' => true,
			),
			'urcma_form_checkbox_styles' => array(
				'title'              => esc_html__( 'Checkbox/Radio Styles', 'user-registration-customize-my-account' ),
				'description'        => '',
				'priority'           => 10,
				'panel'              => 'urcma_form',
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_customize_my_account_sections', 'user_registration_customize_my_account_form_sections' );

/**
 * Add User Registration Customizer My Account Form controls.
 *
 * @param array $controls Array of controls.
 * @since 1.1.0
 */
function user_registration_customize_my_account_form_controls( $controls, $customize ) {

	$controls['form'] = array(
		'input_background_color'       => array(
			'setting' => array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_form_field_styles',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'input_focus_background_color' => array(
			'setting' => array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background Focus', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_form_field_styles',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'input_text_color'             => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Text', 'user-registration-customize-my-account' ),
				'section' => 'urcma_form_field_styles',
				'type'    => 'Color',
			),
		),
		'input_focus_text_color'       => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Text Focus', 'user-registration-customize-my-account' ),
				'section' => 'urcma_form_field_styles',
				'type'    => 'Color',
			),
		),
		'input_border_type'            => array(
			'setting' => array(
				'default'           => 'none',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Border Type', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_field_styles',
				'choices'     => array(
					'none'   => esc_html__( 'None', 'user-registration-customize-my-account' ),
					'solid'  => esc_html__( 'Solid', 'user-registration-customize-my-account' ),
					'dashed' => esc_html__( 'Dashed', 'user-registration-customize-my-account' ),
					'dotted' => esc_html__( 'Dotted', 'user-registration-customize-my-account' ),
				),
			),
		),
		'input_border_width'           => array(
			'setting' => array(
				'default' => array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
			),
			'control' => array(
				'label'       => esc_html__( 'Border Width', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_field_styles',
				'type'        => 'Dimension',
				'input_attrs' => array(
					'min' => 0,
				),
				'custom_args' => array(
					'anchor'     => true,
					'input_type' => 'number',
				),
			),
		),
		'input_border_color'           => array(
			'setting' => array(
				'default'           => '#dee0e9',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Border Color', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_field_styles',
				'type'        => 'Color',
			),
		),
		'input_focus_border_color'     => array(
			'setting' => array(
				'default'           => '#dee0e9',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Border Focus Color', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_field_styles',
				'type'        => 'Color',
			),
		),
		'input_border_radius'          => array(
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
				'label'       => esc_html__( 'Border Radius', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_field_styles',
				'type'        => 'Dimension',
				'input_attrs' => array(
					'min' => 0,
				),
				'custom_args' => array(
					'anchor'       => true,
					'input_type'   => 'number',
					'unit_choices' => array(
						'px' => esc_attr__( 'PX', 'user-registration-customize-my-account' ),
						'%'  => esc_attr__( '%', 'user-registration-customize-my-account' ),
					),
				),
			),
		),
		'input_padding'                => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 4,
						'right'  => 8,
						'bottom' => 4,
						'left'   => 8,
					),
				),
			),
			'control' => array(
				'label'       => esc_html__( 'Padding', 'user-registration-customize-my-account' ),
				'description' => esc_html__( 'Inner spacing for the input field.', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_form_field_styles',
				'type'        => 'Dimension',
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
		'label_font_size'              => array(
			'setting' => array(
				'default'           => '14',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Font Size', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_field_labels',
				'type'        => 'Slider',
				'input_attrs' => array(
					'min'  => 12,
					'max'  => 50,
					'step' => 1,
				),
			),
		),
		'label_color'                  => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Color', 'user-registration-customize-my-account' ),
				'section' => 'urcma_form_field_labels',
				'type'    => 'Color',
			),
		),
		'label_margin'                 => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 0,
						'right'  => 0,
						'bottom' => 5,
						'left'   => 0,
					),
				),
			),
			'control' => array(
				'label'       => esc_html__( 'Margin', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_field_labels',
				'type'        => 'Dimension',
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),
		'choice_font_size'             => array(
			'setting' => array(
				'default'           => '14',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Font Size', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_checkbox_styles',
				'type'        => 'Slider',
				'input_attrs' => array(
					'min'  => 12,
					'max'  => 50,
					'step' => 1,
				),
			),
		),
		'choice_font_color'            => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Color', 'user-registration-customize-my-account' ),
				'section' => 'urcma_form_checkbox_styles',
				'type'    => 'Color',
			),
		),
		'choice_margin'                => array(
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
				'label'       => esc_html__( 'Margin', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_form_checkbox_styles',
				'type'        => 'Dimension',
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
add_filter( 'user_registration_customize_my_account_controls', 'user_registration_customize_my_account_form_controls', 10, 2 );
