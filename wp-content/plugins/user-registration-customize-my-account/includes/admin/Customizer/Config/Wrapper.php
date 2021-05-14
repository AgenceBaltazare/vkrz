<?php
/**
 * User Registration Customizer My Account Wrapper Configs.
 *
 * @package User_Registration_Customize_My_Account\Admin\Customizer\Config
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add User Registration Customizer My Account Wrapper Sections.
 *
 * @param array $sections Array of sections.
 * @since 1.1.0
 */
function user_registration_customize_my_account_wrapper_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'urcma_wrapper' => array(
				'title'       => esc_html__( 'Wrapper', 'user-registration-customize-my-account' ),
				'description' => '',
				'priority'    => 20,
			),
		)
	);
}
add_filter( 'user_registration_customize_my_account_sections', 'user_registration_customize_my_account_wrapper_sections' );

/**
 * Add User Registration Customizer My Account wrapper controls.
 *
 * @param array $controls Array of controls.
 * @since 1.1.0
 */
function user_registration_customize_my_account_wrapper_controls( $controls, $customize ) {

	$controls['wrapper'] = array(
		'background_color' => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background Color', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_wrapper',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'border_type'      => array(
			'setting' => array(
				'default'           => 'none',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Border Type', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_wrapper',
				'choices'     => array(
					'none'   => esc_html__( 'None', 'user-registration-customize-my-account' ),
					'dotted' => esc_html__( 'Dotted', 'user-registration-customize-my-account' ),
					'dashed' => esc_html__( 'Dashed', 'user-registration-customize-my-account' ),
					'solid'  => esc_html__( 'Solid', 'user-registration-customize-my-account' ),
				),
			),
		),
		'border_width'     => array(
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
				'section'     => 'urcma_wrapper',
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
		'border_color'     => array(
			'setting' => array(
				'default'           => '#cccccc',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Border Color', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_wrapper',
				'type'        => 'Color',
			),
		),
		'border_radius'    => array(
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
				'section'     => 'urcma_wrapper',
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
		'content_padding'  => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 30,
						'right'  => 30,
						'bottom' => 30,
						'left'   => 30,
					),
				),
			),
			'control' => array(
				'label'       => esc_html__( 'Content Padding', 'user-registration-customize-my-account' ),
				'description' => esc_html__( 'Inner spacing for the main content.', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_wrapper',
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
		'margin'           => array(
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
				'description' => esc_html__( 'Outer spacing for whole my account wrapper.', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_wrapper',
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
add_filter( 'user_registration_customize_my_account_controls', 'user_registration_customize_my_account_wrapper_controls', 10, 2 );
