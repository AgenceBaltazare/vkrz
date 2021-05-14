<?php
/**
 * Customize API: UR_Customize_Templates_Section class
 *
 * @package User_Registration_Customize_My_Account\Admin\Customizer\Sections
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customize Templates Section class.
 *
 * A UI container for form templates controls, which are displayed within sections.
 *
 * @see WP_Customize_Section
 */
class UR_Customize_Templates_Section extends WP_Customize_Section {

	/**
	 * Section Type.
	 *
	 * @var string
	 */
	public $type = 'ur-templates';

	/**
	 * An Underscore (JS) template for rendering this panel's container.
	 *
	 * The templates panel renders a custom section heading with the current template and a switch template button.
	 *
	 * @see WP_Customize_Panel::print_template()
	 *
	 * @since 4.9.0
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section-ur-templates">
			<h3 class="accordion-section-title">
				<span class="customize-action"><?php esc_html_e( 'Active template', 'user-registration-customize-my-account' ); ?></span> <span class="customize-template-name">{{ data.title }}</span>

				<?php if ( current_user_can( 'manage_user_registration' ) ) : ?>
					<button type="button" class="button change-template" aria-label="<?php esc_attr_e( 'Change template', 'user-registration-customize-my-account' ); ?>"><?php echo esc_html_x( 'Change', 'template', 'user-registration-customize-my-account' ); ?></button>
				<?php endif; ?>
			</h3>
			<ul class="accordion-section-content">
				<li class="customize-section-description-container section-meta <# if ( data.description ) { #>customize-info<# } #>">
					<div class="customize-section-title">
						<button class="customize-section-back" tabindex="-1">
							<span class="screen-reader-text"><?php echo esc_html_e( 'Back', 'user-registration-customize-my-account' ); ?></span>
						</button>
						<h3>
							<span class="customize-action">
								<?php esc_html_e( 'You are browsing', 'user-registration-customize-my-account' ); ?>
							</span>
							<?php esc_html_e( 'Templates', 'user-registration-customize-my-account' ); ?>
						</h3>
						<# if ( data.description ) { #>
							<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php esc_html_e( 'Help', 'user-registration-customize-my-account' ); ?></span></button>
							<div class="description customize-section-description">
								{{{ data.description }}}
							</div>
						<# } #>

						<div class="customize-control-notifications-container"></div>
					</div>
				</li>
			</ul>
		</li>
		<?php
	}
}
