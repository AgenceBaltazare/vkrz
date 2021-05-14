<?php
/**
 * User Registration Customizer My Account Navigation Configs.
 *
 * @package User_Registration_Customize_My_Account\Admin\Customizer\Config
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add User Registration Customize My Account Header Panels.
 *
 * @param array $panels Array of panels.
 */
function user_registration_customize_my_account_body_panels( $panels ) {
	return array_merge(
		$panels,
		array(
			'urcma_navigation' => array(
				'title'       => esc_html__( 'Navigation', 'user-registration-customize-my-account' ),
				'description' => '',
				'priority'    => 30,
			),
		)
	);
}
add_filter( 'user_registration_customize_my_account_panels', 'user_registration_customize_my_account_body_panels' );

/**
 * Add User Registration Customizer My Account Navigation Sections.
 *
 * @param array $sections Array of sections.
 * @since 1.1.0
 */
function user_registration_customize_my_account_navigation_sections( $sections ) {

	return array_merge(
		$sections,
		array(
			'urcma_navigation_wrapper' => array(
				'title'              => esc_html__( 'Navigation Wrapper', 'user-registration-customize-my-account' ),
				'description'        => '',
				'priority'           => 10,
				'panel'              => 'urcma_navigation',
				'description_hidden' => true,
			),
			'urcma_navigation_link'    => array(
				'title'              => esc_html__( 'Navigation Link', 'user-registration-customize-my-account' ),
				'description'        => '',
				'priority'           => 10,
				'panel'              => 'urcma_navigation',
				'description_hidden' => true,
			),
		)
	);
}
add_filter( 'user_registration_customize_my_account_sections', 'user_registration_customize_my_account_navigation_sections' );

/**
 * Add User Registration Customizer My Account Navigation controls.
 *
 * @param array $controls Array of controls.
 * @since 1.1.0
 */
function user_registration_customize_my_account_navigation_controls( $controls, $customize ) {

	$controls['navigation'] = array(
		'navigation_style'             => array(
			'setting' => array(
				'default'           => get_option( 'user_registration_my_account_layout', 'horizontal' ),
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Navigation Style', 'user-registration-customize-my-account' ),
				'description' => esc_html__( 'Choose My Account page layout', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_navigation_wrapper',
				'type'        => 'ButtonSet',
				'choices'     => array(
					'horizontal' => array(
						'name' => esc_html__( 'Horizontal', 'user-registration-customize-my-account' ),
					),
					'vertical'   => array(
						'name' => esc_html__( 'Vertical', 'user-registration-customize-my-account' ),
					),
				),
			),
		),
		'nav_wrapper_width'            => array(
			'setting' => array(
				'default'           => '20',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Navigation Width', 'user-registration-customize-my-account' ),
				'description' => esc_html__( 'Selected navigation width will be in percentage.', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_navigation_wrapper',
				'type'        => 'Slider',
				'input_attrs' => array(
					'min'  => 20,
					'max'  => 40,
					'step' => 1,
				),
			),
		),
		'nav_wrapper_background_color' => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background Color', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_navigation_wrapper',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'nav_wrapper_border_type'      => array(
			'setting' => array(
				'default'           => 'none',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Border Type', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_navigation_wrapper',
				'choices'     => array(
					'none'   => esc_html__( 'None', 'user-registration-customize-my-account' ),
					'solid'  => esc_html__( 'Solid', 'user-registration-customize-my-account' ),
					'dashed' => esc_html__( 'Dashed', 'user-registration-customize-my-account' ),
					'dotted' => esc_html__( 'Dotted', 'user-registration-customize-my-account' ),
				),
			),
		),
		'nav_wrapper_border_width'     => array(
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
				'section'     => 'urcma_navigation_wrapper',
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
		'nav_wrapper_border_color'     => array(
			'setting' => array(
				'default'           => '#dee0e9',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Border Color', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_navigation_wrapper',
				'type'        => 'Color',
			),
		),
		'nav_wrapper_border_radius'    => array(
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
				'section'     => 'urcma_navigation_wrapper',
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
		'nav_link_background_color'    => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_navigation_link',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'hover_background_color'       => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background Hover', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_navigation_link',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'nav_link_text_color'          => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Text', 'user-registration-customize-my-account' ),
				'section' => 'urcma_navigation_link',
				'type'    => 'Color',
			),
		),
		'hover_text_color'             => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Text Hover', 'user-registration-customize-my-account' ),
				'section' => 'urcma_navigation_link',
				'type'    => 'Color',
			),
		),
		'nav_link_border_type'         => array(
			'setting' => array(
				'default'           => 'none',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Border Type', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_navigation_link',
				'choices'     => array(
					'none'   => esc_html__( 'None', 'user-registration-customize-my-account' ),
					'solid'  => esc_html__( 'Solid', 'user-registration-customize-my-account' ),
					'dashed' => esc_html__( 'Dashed', 'user-registration-customize-my-account' ),
					'dotted' => esc_html__( 'Dotted', 'user-registration-customize-my-account' ),
				),
			),
		),
		'nav_link_border_width'        => array(
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
				'section'     => 'urcma_navigation_link',
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
		'nav_link_border_color'        => array(
			'setting' => array(
				'default'           => '#cccccc',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Border Color', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_navigation_link',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'hover_nav_link_border_color'  => array(
			'setting' => array(
				'default'           => '#cccccc',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Border Hover Color', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_navigation_link',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'nav_link_border_radius'       => array(
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
				'section'     => 'urcma_navigation_link',
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
		'padding'                      => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 10,
						'right'  => 15,
						'bottom' => 10,
						'left'   => 15,
					),
				),
			),
			'control' => array(
				'label'       => esc_html__( 'Padding', 'user-registration-customize-my-account' ),
				'description' => esc_html__( '', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_navigation_link',
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
	);

	return $controls;
}
add_filter( 'user_registration_customize_my_account_controls', 'user_registration_customize_my_account_navigation_controls', 10, 2 );
