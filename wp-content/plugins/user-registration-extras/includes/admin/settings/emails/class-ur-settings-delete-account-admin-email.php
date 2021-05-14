<?php
/**
 * Configure Email
 *
 * @class    User_Registration_Settings_Delete_Account_Admin_Email
 * @extends  User_Registration_Settings_Email
 * @category Class
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'User_Registration_Settings_Delete_Account_Admin_Email', false ) ) :

	/**
	 * User_Registration_Settings_Delete_Account_Admin_Email Class.
	 */
	class User_Registration_Settings_Delete_Account_Admin_Email {

		public function __construct() {
			$this->id          = 'delete_account_admin_email';
			$this->title       = esc_html__( 'Delete Account Admin Email', 'user-registration-extras' );
			$this->description = esc_html__( 'Email sent to the admin when user delete thier own account', 'user-registration-extras' );
		}

		/**
		 * Get settings
		 *
		 * @return array
		 */
		public function get_settings() {

			?><h2><?php echo esc_html__( 'Delete Account Admin Email', 'user-registration-extras' ); ?> <?php ur_back_link( __( 'Return to emails', 'user-registration-extras' ), admin_url( 'admin.php?page=user-registration-settings&tab=email' ) ); ?></h2>

			<?php
			$settings = apply_filters(
				'user_registration_delete_account_admin_email',
				array(
					array(
						'type' => 'title',
						'desc' => '',
						'id'   => 'delete_account_admin_email',
					),
					array(
						'title'    => __( 'Enable this email', 'user-registration-extras' ),
						'desc'     => __( 'Enable this email sent to the admin after user deletes thier own account', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_enable_delete_account_admin_email',
						'default'  => 'yes',
						'type'     => 'checkbox',
						'autoload' => false,
					),

					array(
						'title'    => __( 'Email Receipents', 'user-registration' ),
						'desc'     => __( 'Use comma to send emails to multiple receipents.', 'user-registration' ),
						'id'       => 'user_registration_extras_delete_account_email_receipents',
						'default'  => get_option( 'admin_email' ),
						'type'     => 'text',
						'css'      => 'min-width: 350px;',
						'autoload' => false,
						'desc_tip' => true,
					),
					array(
						'title'    => __( 'Email Subject', 'user-registration-extras' ),
						'desc'     => __( 'The email subject you want to customize.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_delete_account_admin_email_subject',
						'type'     => 'text',
						'default'  => __( '{{blog_info}} Account deleted', 'user-registration-extras' ),
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'title'    => __( 'Email Content', 'user-registration-extras' ),
						'desc'     => __( 'The email content you want to customize.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_delete_account_admin_email_content',
						'type'     => 'tinymce',
						'default'  => $this->user_registration_get_delete_account_admin_email(),
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'type' => 'sectionend',
						'id'   => 'delete_account_admin_email',
					),
				)
			);

			return apply_filters( 'user_registration_get_settings_' . $this->id, $settings );
		}

			/**
			 * Email Format.
			 */
		public static function user_registration_get_delete_account_admin_email() {

			$message = apply_filters(
				'user_registration_get_delete_account_admin_email',
				sprintf(
					__(
						'{{username}} has just deleted their {{blog_info}} account.',
						'user-registration-extras'
					)
				)
			);

			return $message;
		}
	}
endif;

return new User_Registration_Settings_Delete_Account_Admin_Email();
