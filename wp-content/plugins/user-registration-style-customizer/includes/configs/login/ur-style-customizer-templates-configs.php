<?php
/**
 * User Registration Templates Config Functions
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
function ur_style_customizer_templates_sections( $sections ) {
	return array_merge(
		$sections,
		array(
			'user_registration_templates' => array(
				'title'       => __( 'Default', 'user-registration-style-customizer' ),
				'description' => (
					'<p>' . __( 'Looking for a template? You can browse our templates, import and preview templates, then activate them right here.', 'user-registration-style-customizer' ) . '</p>' .
					'<p>' . __( 'While previewing a new template, you can continue to tailor things like form styles and custom css, and explore template-specific options.', 'user-registration-style-customizer' ) . '</p>'
				),
				'priority'    => 0,
				'type'        => 'UR_Customize_Templates_Section',
			),
		)
	);
}
add_filter( 'user_registration_style_customizer_sections', 'ur_style_customizer_templates_sections' );
