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
function user_registration_customize_my_account_color_sections( $sections ) {

	return array_merge(
		$sections,
		array(
			'urcma_color' => array(
				'title'       => esc_html__( 'Color', 'user-registration-customize-my-account' ),
				'description' => '',
				'priority'    => 20,
			),
		)
	);
}
add_filter( 'user_registration_customize_my_account_sections', 'user_registration_customize_my_account_color_sections' );


/**
 * Add User Registration Customizer My Account wrapper controls.
 *
 * @param array $controls Array of controls.
 * @since 1.1.0
 */
function user_registration_customize_my_account_color_controls( $controls, $customize ) {

		$controls['color'] = array(
			'heading'    => array(
				'setting' => array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
				),
				'control' => array(
					'label'       => esc_html__( 'Headings', 'user-registration-customize-my-account' ),
					'description' => esc_html__( '', 'user-registration-customize-my-account' ),
					'section'     => 'urcma_color',
					'type'        => 'Color',
					'custom_args' => array(
						'alpha' => false,
					),
				),
			),
			'body'       => array(
				'setting' => array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
				),
				'control' => array(
					'label'       => esc_html__( 'Body', 'user-registration-customize-my-account' ),
					'description' => esc_html__( '', 'user-registration-customize-my-account' ),
					'section'     => 'urcma_color',
					'type'        => 'Color',
				),
			),
			'link'       => array(
				'setting' => array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
				),
				'control' => array(
					'label'       => esc_html__( 'Link', 'user-registration-customize-my-account' ),
					'description' => esc_html__( '', 'user-registration-customize-my-account' ),
					'section'     => 'urcma_color',
					'type'        => 'Color',
				),
			),
			'link_hover' => array(
				'setting' => array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
				),
				'control' => array(
					'label'       => esc_html__( 'Link Hover', 'user-registration-customize-my-account' ),
					'description' => esc_html__( '', 'user-registration-customize-my-account' ),
					'section'     => 'urcma_color',
					'type'        => 'Color',
				),
			),
		);

		return $controls;
}

add_filter( 'user_registration_customize_my_account_controls', 'user_registration_customize_my_account_color_controls', 10, 2 );
