<?php
/**
 * Configure Email
 *
 * @class    User_Registration_Settings_Delete_Account_Email
 * @extends  User_Registration_Settings_Email
 * @category Class
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'User_Registration_Settings_Delete_Account_Email', false ) ) :

	/**
	 * User_Registration_Settings_Delete_Account_Email Class.
	 */
	class User_Registration_Settings_Delete_Account_Email {

		public function __construct() {
			$this->id          = 'delete_account_email';
			$this->title       = esc_html__( 'Delete Account Email', 'user-registration-extras' );
			$this->description = esc_html__( 'Email sent to the user when user delete thier own account', 'user-registration-extras' );
		}

		/**
		 * Get settings
		 *
		 * @return array
		 */
		public function get_settings() {

			?><h2><?php echo esc_html__( 'Delete Account Email', 'user-registration-extras' ); ?> <?php ur_back_link( __( 'Return to emails', 'user-registration-extras' ), admin_url( 'admin.php?page=user-registration-settings&tab=email' ) ); ?></h2>

			<?php
			$settings = apply_filters(
				'user_registration_delete_account_email',
				array(
					array(
						'type' => 'title',
						'desc' => '',
						'id'   => 'delete_account_email',
					),
					array(
						'title'    => __( 'Enable this email', 'user-registration-extras' ),
						'desc'     => __( 'Enable this email sent to the user after succesfully deletes thier own account', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_enable_delete_account_email',
						'default'  => 'yes',
						'type'     => 'checkbox',
						'autoload' => false,
					),
					array(
						'title'    => __( 'Email Subject', 'user-registration-extras' ),
						'desc'     => __( 'The email subject you want to customize.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_delete_account_email_subject',
						'type'     => 'text',
						'default'  => __( 'Your account has been deleted', 'user-registration-extras' ),
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'title'    => __( 'Email Content', 'user-registration-extras' ),
						'desc'     => __( 'The email content you want to customize.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_delete_account_email_content',
						'type'     => 'tinymce',
						'default'  => $this->user_registration_get_delete_account_email(),
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'type' => 'sectionend',
						'id'   => 'delete_account_email',
					),
				)
			);

			return apply_filters( 'user_registration_get_settings_' . $this->id, $settings );
		}

			/**
			 * Email Format.
			 */
		public static function user_registration_get_delete_account_email() {

			$message = apply_filters(
				'user_registration_get_delete_account_email',
				sprintf(
					__(
						'Hi {{username}},<br /><br />' .
									   'This is an automated email to let you know your {{blog_info}} account has been deleted. All of your personal information has been permanently deleted and you will no longer be able to login to {{blog_info}}.<br /><br />' .
									   'If your account has been deleted by accident please contact us at {{admin_email}} <br />' .
									   'Thanks,<br />' .
									   '{{blog_info}}',
						'user-registration-extras'
					)
				)
			);

			return $message;
		}
	}
endif;

return new User_Registration_Settings_Delete_Account_Email();
