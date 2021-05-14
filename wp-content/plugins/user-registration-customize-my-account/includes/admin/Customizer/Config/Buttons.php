<?php
/**
 * User Registration Customizer My Account Buttons Configs.
 *
 * @package User_Registration_Customize_My_Account\Admin\Customizer\Config
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add User Registration Customizer My Account Buttons Sections.
 *
 * @param array $sections Array of sections.
 * @since 1.1.0
 */
function user_registration_customize_my_account_button_sections( $sections ) {

	return array_merge(
		$sections,
		array(
			'urcma_button' => array(
				'title'       => esc_html__( 'Buttons', 'user-registration-customize-my-account' ),
				'description' => '',
				'priority'    => 30,
			),
		)
	);
}
add_filter( 'user_registration_customize_my_account_sections', 'user_registration_customize_my_account_button_sections' );

/**
 * Add User Registration Customizer My Account Form controls.
 *
 * @param array $controls Array of controls.
 * @since 1.1.0
 */
function user_registration_customize_my_account_button_controls( $controls, $customize ) {

	$controls['button'] = array(
		'button_font_size'              => array(
			'setting' => array(
				'default'           => '16',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Font Size', 'user-registration-customize-my-account' ),
				'description' => '',
				'section'     => 'urcma_button',
				'type'        => 'Slider',
				'input_attrs' => array(
					'min'  => 12,
					'max'  => 50,
					'step' => 1,
				),
			),
		),
		'button_background_color'       => array(
			'setting' => array(
				'default'           => '#4b4bb5',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_button',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'button_hover_background_color' => array(
			'setting' => array(
				'default'           => '#2c2c9c',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'       => esc_html__( 'Background Hover', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_button',
				'type'        => 'Color',
				'custom_args' => array(
					'alpha' => true,
				),
			),
		),
		'button_text_color'             => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Color', 'user-registration-customize-my-account' ),
				'section' => 'urcma_button',
				'type'    => 'Color',
			),
		),
		'button_hover_text_color'       => array(
			'setting' => array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'control' => array(
				'label'   => esc_html__( 'Hover Color', 'user-registration-customize-my-account' ),
				'section' => 'urcma_button',
				'type'    => 'Color',
			),
		),
		'margin'                        => array(
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
				'section'     => 'urcma_button',
				'type'        => 'Dimension',
				'custom_args' => array(
					'anchor'     => true,
					'responsive' => true,
					'input_type' => 'number',
				),
			),
		),
		'padding'                       => array(
			'setting' => array(
				'default' => array(
					'desktop' => array(
						'top'    => 8,
						'right'  => 12,
						'bottom' => 8,
						'left'   => 12,
					),
				),
			),
			'control' => array(
				'label'       => esc_html__( 'Padding', 'user-registration-customize-my-account' ),
				'description' => esc_html__( '', 'user-registration-customize-my-account' ),
				'section'     => 'urcma_button',
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
add_filter( 'user_registration_customize_my_account_controls', 'user_registration_customize_my_account_button_controls', 10, 2 );
