<?php
/**
 * Configure Email
 *
 * @class    User_Registration_Settings_Admin_Email
 * @extends  User_Registration_Settings_Email
 * @category Class
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'User_Registration_Settings_Generated_Password_Email', false ) ) :

	/**
	 * User_Registration_Settings_Generated_Password_Email Class.
	 */
	class User_Registration_Settings_Generated_Password_Email {

		public function __construct() {
			$this->id          = 'generated_password_email';
			$this->title       = esc_html__( 'Auto Generated Password Email', 'user-registration-extras' );
			$this->description = esc_html__( 'Email sent to the user on enabling auto password generation', 'user-registration-extras' );
		}

		/**
		 * Get settings
		 *
		 * @return array
		 */
		public function get_settings() {

			?><h2><?php echo esc_html__( 'Auto Generated Password Email', 'user-registration-extras' ); ?> <?php ur_back_link( __( 'Return to emails', 'user-registration-extras' ), admin_url( 'admin.php?page=user-registration-settings&tab=email' ) ); ?></h2>

			<?php
			$settings = apply_filters(
				'user_registration_generated_password_email',
				array(
					array(
						'type' => 'title',
						'desc' => '',
						'id'   => 'generated_password_email',
					),
					array(
						'title'    => __( 'Enable this email', 'user-registration-extras' ),
						'desc'     => __( 'Enable this email sent to the user after succesful registration.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_enable_auto_generated_password_email',
						'default'  => 'yes',
						'type'     => 'checkbox',
						'autoload' => false,
					),
					array(
						'title'    => __( 'Email Subject', 'user-registration-extras' ),
						'desc'     => __( 'The email subject you want to customize.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_auto_generated_password_email_subject',
						'type'     => 'text',
						'default'  => __( 'Your password for logging into {{blog_info}}', 'user-registration-extras' ),
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'title'    => __( 'Email Content', 'user-registration-extras' ),
						'desc'     => __( 'The email content you want to customize.', 'user-registration-extras' ),
						'id'       => 'user_registration_extras_auto_generated_password_email_content',
						'type'     => 'tinymce',
						'default'  => $this->user_registration_get_auto_generated_password_email(),
						'css'      => 'min-width: 350px;',
						'desc_tip' => true,
					),
					array(
						'type' => 'sectionend',
						'id'   => 'generated_password_email',
					),
				)
			);

			return apply_filters( 'user_registration_get_settings_' . $this->id, $settings );
		}

			/**
			 * Email Format.
			 */
		public static function user_registration_get_auto_generated_password_email() {

			$message = apply_filters(
				'user_registration_get_auto_generated_password_email',
				sprintf(
					__(
						'Hi {{username}}, <br/>

Your registration on <a href="{{home_url}}">{{blog_info}}</a>  has been completed. <br/>

Please use the following password to log into <a href="{{home_url}}">{{blog_info}}</a> : <br/>
{{auto_pass}}

Thank You!',
						'user-registration-extras'
					)
				)
			);

			return $message;
		}
	}
endif;

return new User_Registration_Settings_Generated_Password_Email();
