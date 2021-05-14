<?php
/**
 * Admin class
 *
 * User_Registration_Extras Admin
 *
 * @package User_Registration_Extras
 * @since  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'User_Registration_Extras_Admin' ) ) {
	/**
	 * Admin class.
	 * The class manage all the admin behaviors.
	 *
	 * @since 1.0.0
	 */
	class User_Registration_Extras_Admin {

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = USER_REGISTRATION_EXTRAS_VERSION;

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_menu', array( $this, 'dashboard_menu' ), 14 );
			add_action( 'user_registration_auto_generate_password', array( $this, 'user_registration_extras_auto_generate_password' ) );
			add_filter( 'user_registration_success_params', array( $this, 'user_registration_after_register_mail' ), 10, 4 );

			add_filter( 'user_registration_email_classes', array( $this, 'get_emails' ), 10, 1 );
			// Frontend message settings.
			add_filter( 'user_registration_frontend_messages_settings', array( $this, 'add_auto_generated_password_frontend_message' ) );
			add_action( 'admin_init', array( $this, 'actions' ) );
			add_action( 'admin_print_scripts', array( $this, 'hide_unrelated_notices' ) );
			add_action( 'admin_head-nav-menus.php', array( $this, 'add_nav_menu_meta_boxes' ) );

		}

		/**
		 * Enqueue scripts
		 *
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {

			if ( isset( $_GET['page'] ) && ( 'user-registration-settings' === $_GET['page'] || 'user-registration-dashboard' === $_GET['page'] ) ) {

				$min = ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) ? '.min' : '';

				wp_register_script(
					'user-registration-extras-admin',
					USER_REGISTRATION_EXTRAS_ASSETS_URL . '/js/admin/user-registration-extras-admin-script' . $min . '.js',
					array(
						'jquery',
						'flatpickr',
						'chartjs',
					),
					USER_REGISTRATION_EXTRAS_VERSION
				);
				wp_register_style( 'user-registration-extras-admin-style', USER_REGISTRATION_EXTRAS_ASSETS_URL . '/css/user-registration-extras-admin.css', array( 'flatpickr' ), USER_REGISTRATION_EXTRAS_VERSION );

				wp_enqueue_script( 'user-registration-extras-admin' );
				wp_enqueue_style( 'user-registration-extras-admin-style' );

				wp_localize_script(
					'user-registration-extras-admin',
					'user_registration_extras_script_data',
					array(
						'ajax_url' => admin_url( 'admin-ajax.php' ),
					)
				);
			}
		}

		/**
		 * Get all emails triggered.
		 *
		 * @return array $emails List of all emails.
		 */
		public function get_emails( $emails ) {
			$emails['User_Registration_Settings_Generated_Password_Email']   = include dirname( __FILE__ ) . '/admin/settings/emails/class-ur-settings-generated-password-email.php';
			$emails['User_Registration_Settings_Delete_Account_Email']       = include dirname( __FILE__ ) . '/admin/settings/emails/class-ur-settings-delete-account-email.php';
			$emails['User_Registration_Settings_Delete_Account_Admin_Email'] = include dirname( __FILE__ ) . '/admin/settings/emails/class-ur-settings-delete-account-admin-email.php';

			return $emails;
		}

		/**
		 * Include auto generated password success message into frontend messages.
		 *
		 * @param array $settings Frontend messages settings array.
		 */
		public function add_auto_generated_password_frontend_message( $settings ) {

			$auto_password_generation = array(
				array(
					'title'    => __( 'Auto generated password success message', 'user-registration-extras' ),
					'desc'     => __( 'Enter the text message after user is registered.', 'user-registration-extras' ),
					'id'       => 'user_registration_extras_auto_password_generation_message',
					'type'     => 'textarea',
					'desc_tip' => true,
					'css'      => 'min-width: 350px; min-height: 100px;',
					'default'  => __( 'An email with a password to access your account has been sent to your email.', 'user-registration-extras' ),
				),
			);

			array_splice( $settings, 4, 0, $auto_password_generation );

			return $settings;
		}

		/**
		 * Generate a random password with length provided by the user.
		 *
		 * @since 1.0.0
		 */
		public function user_registration_extras_auto_generate_password() {
			$password_length = get_option( 'user_registration_extras_auto_generated_password_length', '' );
			$user_pass       = trim( wp_generate_password( $password_length, true, true ) );
			add_filter(
				'user_registration_auto_generated_password',
				function ( $msg ) use ( $user_pass ) {
					return $user_pass;
				}
			);

			add_filter(
				'user_registration_required_form_fields',
				function ( $required_fields ) {
					$index = array_search( 'user_pass', $required_fields );
					unset( $required_fields[ $index ] );
					return $required_fields;
				}
			);
		}

		/**
		 * Process and submit entry to provider.
		 *
		 * @param array   $valid_form_data Form data submitted
		 * @param integer $form_id ID of the form.
		 * @param int     $user_id ID of the user
		 */
		public function user_registration_after_register_mail( $success_params, $valid_form_data, $form_id, $user_id ) {
			$activated_form_list = get_option( 'user_registration_auto_password_activated_forms', array() );

			if ( in_array( $form_id, $activated_form_list ) ) {
				$this->send_auto_generated_password_email( $user_id, $form_id, $valid_form_data );
				$success_params['auto_password_generation_success_message'] = get_option( 'user_registration_extras_auto_password_generation_message', esc_html( 'An email with a password to access your account has been sent to your email.' ) );
			}
			return $success_params;
		}

		/**
		 * Send mail with auto generated password.
		 *
		 * @param int $user_id ID of the user
		 */
		private function send_auto_generated_password_email( $user_id, $form_id, $form_data ) {

			include dirname( __FILE__ ) . '/admin/settings/emails/class-ur-settings-generated-password-email.php';

			$user         = get_user_by( 'ID', $user_id );
			$username     = $user->data->user_login;
			$email        = $user->data->user_email;
			$user_pass    = apply_filters( 'user_registration_auto_generated_password', 'user_pass' );
			list( $name_value, $data_html ) = ur_parse_name_values_for_smart_tags( $user_id, $form_id, $form_data );

			$values       = array(
				'username'    => $username,
				'email'       => $email,
				'all_fields' => $data_html
			);

			$header  = 'From: ' . UR_Emailer::ur_sender_name() . ' <' . UR_Emailer::ur_sender_email() . ">\r\n";
			$header .= 'Reply-To: ' . UR_Emailer::ur_sender_email() . "\r\n";
			$header .= "Content-Type: text/html\r\n; charset=UTF-8";

			$subject = get_option( 'user_registration_extras_auto_generated_password_email_subject', 'Your password for logging into {{blog_info}}' );

			$settings                  = new User_Registration_Settings_Generated_Password_Email();
			$message                   = $settings->user_registration_get_auto_generated_password_email();
			$message                   = get_option( 'user_registration_extras_auto_generated_password_email_content', $message );
			$form_id                   = ur_get_form_id_by_userid( $user_id );
			list( $message, $subject ) = user_registration_email_content_overrider( $form_id, $settings, $message, $subject );


			$message = UR_Emailer::parse_smart_tags( $message, $values, $name_value );
			$subject = UR_Emailer::parse_smart_tags( $subject, $values, $name_value );

			// Get selected email template id for specific form.
			$template_id = ur_get_single_post_meta( $form_id, 'user_registration_select_email_template' );

			if ( 'yes' === get_option( 'user_registration_extras_enable_auto_generated_password_email', 'yes' ) ) {
				UR_Emailer::user_registration_process_and_send_email( $email, $subject, $message, $header, '', $template_id );
			}
		}

		/**
		 * Popups admin actions.
		 */
		public function actions() {

			if ( isset( $_GET['page'] ) && 'user-registration-settings' === $_GET['page'] && isset( $_GET['tab'] ) && 'user-registration-extras' === $_GET['tab'] ) {

				// Bulk actions
				if ( isset( $_REQUEST['action'] ) && isset( $_REQUEST['popup'] ) ) {
					$this->bulk_actions();
				}

				// Empty trash
				if ( isset( $_GET['empty_trash'] ) ) {
					$this->empty_trash();
				}
			}

		}

		/**
		 * Bulk trash/delete.
		 *
		 * @param array $popups Popups post id.
		 * @param bool  $delete Delete action.
		 */
		private function bulk_trash( $popups, $delete = false ) {
			foreach ( $popups as $popup_id ) {
				if ( $delete ) {
					wp_delete_post( $popup_id, true );
				} else {
					wp_trash_post( $popup_id );
				}
			}

			$type   = ! EMPTY_TRASH_DAYS || $delete ? 'deleted' : 'trashed';
			$qty    = count( $popups );
			$status = isset( $_GET['status'] ) ? '&status=' . sanitize_text_field( $_GET['status'] ) : '';

			// Redirect to Popups page.
			wp_redirect( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups' . $status . '&' . $type . '=' . $qty ) );
			exit();
		}

		/**
		 * Bulk untrash.
		 *
		 * @param array $popups Popups post ids.
		 */
		private function bulk_untrash( $popups ) {
			foreach ( $popups as $popup_id ) {
				wp_untrash_post( $popup_id );
			}

			$qty = count( $popups );

			// Redirect to Popups page.
			wp_redirect( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups&status=trashed&untrashed=' . $qty ) );
			exit();
		}

		/**
		 * Bulk actions.
		 */
		private function bulk_actions() {
			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_die( __( 'You do not have permissions to edit popups!', 'user-registration-extras' ) );
			}

			$popup = array_map( 'absint', (array) $_REQUEST['popup'] );

			switch ( $_REQUEST['action'] ) {
				case 'trash':
					$this->bulk_trash( $popup );
					break;
				case 'untrash':
					$this->bulk_untrash( $popup );
					break;
				case 'delete':
					$this->bulk_trash( $popup, true );
					break;
				default:
					break;
			}
		}

		/**
		 * Empty Trash.
		 */
		private function empty_trash() {
			if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'empty_trash' ) ) {
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'user-registration-extras' ) );
			}

			if ( ! current_user_can( 'delete_posts' ) ) {
				wp_die( __( 'You do not have permissions to delete forms!', 'user-registration-extras' ) );
			}

			$popup = get_posts(
				array(
					'post_type'           => 'ur_extras_popup',
					'ignore_sticky_posts' => true,
					'nopaging'            => true,
					'post_status'         => 'trash',
					'fields'              => 'ids',
				)
			);

			foreach ( $popup as $webhook_id ) {
				wp_delete_post( $webhook_id, true );
			}

			$qty = count( $popup );

			// Redirect to registrations page
			wp_redirect( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups&deleted=' . $qty ) );
			exit();
		}


		/**
		 * Table list output.
		 */
		public static function user_registration_extras_popup_list_table_output() {

			global $user_registration_extras_popup_table_list;
			?>
			<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'User Registration Popups', 'user-registration-extras' ); ?></h1>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=add-new-popup' ) ); ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'user-registration-extras' ); ?></a>
				<hr class="wp-header-end">
				<br class="clear">
				<?php

				$forms = array(
					'all'	=> __('All Popups', 'user-registration-extras' ),
					'registration' => __('Registration Popups', 'user-registration-extras' ),
					'login'        => __('Login Popups', 'user-registration-extras' ),
				);

				$latest   = key( $forms );
				$selected = isset( $_REQUEST['popup_type'] ) ? $_REQUEST['popup_type'] : $latest;

				if ( isset( $_POST['popup_type'] ) ) {
					$query_args = add_query_arg(
						array(
							'popup_type' => $selected,
						),
						'//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
					);
					wp_safe_redirect( $query_args );
				}
				?>
				<?php
				$user_registration_extras_popup_table_list = new User_Registration_Extras_Popup_Table_List();
				$user_registration_extras_popup_table_list->prepare_items();
				?>

				<form id="popups-select" method="get">
					<input type="hidden" name="page" value="user-registration-settings" />
					<input type="hidden" name="tab" value="user-registration-extras" />
					<input type="hidden" name="section" value="popups" />
					<select id = "form-select" name ="popup_type">
						<?php
						foreach ( $forms as $key => $form ) {
							echo '<option value="' . $key . '" ' . selected( $selected, $key, false ) . '>' . $form . '</option>';
						}
						?>
					</select>
					<button type="submit" class="button" ><?php esc_html_e( 'Filter', 'user-registration-extras' ); ?></button>
				</form>


				<form id="popups-list" method="get">
					<input type="hidden" name="page" value="user-registration-settings" />
					<input type="hidden" name="tab" value="user-registration-extras" />
					<input type="hidden" name="section" value="popups" />
					<?php
						$user_registration_extras_popup_table_list->views();
						$user_registration_extras_popup_table_list->search_box( __( 'Search Popups', 'user-registration-extras' ), 'user-registration-extras' );
						$user_registration_extras_popup_table_list->display();
					?>
				</form>
			</div>
			<?php
		}

		/**
		 * Hide Notices From WPList table for Popup list table section.
		 * For Clear appearance.
		 *
		 * @return void
		 */
		public function hide_unrelated_notices() {
			global $wp_filter;

			// Return on other than user registraion builder page.
			if ( empty( $_REQUEST['page'] ) || ( 'user-registration-settings' !== $_REQUEST['page'] || empty( $_REQUEST['tab'] ) || 'user-registration-extras' !== $_REQUEST['tab'] ) && 'user-registration-dashboard' !== $_REQUEST['page'] ) {
				return;
			}

			foreach ( array( 'user_admin_notices', 'admin_notices', 'all_admin_notices' ) as $wp_notice ) {
				if ( ! empty( $wp_filter[ $wp_notice ]->callbacks ) && is_array( $wp_filter[ $wp_notice ]->callbacks ) ) {
					foreach ( $wp_filter[ $wp_notice ]->callbacks as $priority => $hooks ) {
						foreach ( $hooks as $name => $arr ) {
							// Remove all notices except user registration plugins notices.
							if ( ! strstr( $name, 'user_registration_' ) ) {
								unset( $wp_filter[ $wp_notice ]->callbacks[ $priority ][ $name ] );
							}
						}
					}
				}
			}
		}

		/**
		 * Add custom nav meta box.
		 *
		 * Adapted from http://www.johnmorrisonline.com/how-to-add-a-fully-functional-custom-meta-box-to-wordpress-navigation-menus/.
		 */
		public function add_nav_menu_meta_boxes() {
			$args = array(
				'post_type'   => 'ur_extras_popup',
				'post_status' => array( 'publish' ),
			);

			$popups             = new WP_Query( $args );
			$active_popup_count = 0;

			// Check if there is at least one active popup.
			if ( ! empty( $popups->posts ) ) {
				foreach ( $popups->posts as $popup ) {
					$popup_content = json_decode( $popup->post_content );

					if ( '1' === $popup_content->popup_status ) {
						$active_popup_count++;
					}
				}
			}

			if ( $active_popup_count > 0 ) {
				add_meta_box(
					'user_registration_extras_popup_nav_link',
					__( 'User Registration Extras Popup', 'user-registration-extras' ),
					array(
						$this,
						'nav_menu_links',
					),
					'nav-menus',
					'side',
					'low'
				);
			}
		}

		/**
		 * Output menu links.
		 */
		public function nav_menu_links() {
			// Get items from account menu.
			$menus   = array();
			$post_id = array();
			$args    = array(
				'post_type'     => 'ur_extras_popup',
				'post_status'   => array( 'publish' ),
				'__post_not_in' => $post_id,
			);

			$popups = new WP_Query( $args );

			foreach ( $popups->posts as $popup ) {
				$post_id[]     = $popup->ID;
				$popup_content = json_decode( $popup->post_content );

				if ( '1' === $popup_content->popup_status ) {
					$menus[ 'user-registration-modal-link-' . $popup->ID ] = sprintf( __( '%s', 'user-registration-extras' ), $popup_content->popup_title );
				}
			}

			?>
			<div id="posttype-user-registration-modal" class="posttypediv">
				<div id="tabs-panel-user-registration-modal" class="tabs-panel tabs-panel-active">
					<ul id="user-registration-modal-checklist" class="categorychecklist form-no-clear">
						<?php
						$i = - 1;
						foreach ( $menus as $key => $value ) :
							?>
							<li>
								<label class="menu-item-title">
									<input type="checkbox" class="menu-item-checkbox"
										   name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-object-id]"
										   value="<?php echo esc_attr( $i ); ?>"/> <?php echo esc_html( $value ); ?>
								</label>
								<input type="hidden" class="menu-item-type"
									   name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-type]" value="post"/>
								<input type="hidden" class="menu-item-title"
									   name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-title]"
									   value="<?php echo esc_html( $value ); ?>"/>
								<input type="hidden" class="menu-item-url"
									   name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-url]"
									   value="<?php echo esc_url( '#user-registration-modal' ); ?>"/>
								<input type="hidden" class="menu-item-classes"
									   name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-classes]"
									   value="user-registration-modal-link <?php echo $key; ?>"/>
							</li>
							<?php
							$i --;
						endforeach;
						?>
					</ul>
				</div>
				<p class="button-controls">
					<span class="list-controls">
					<a href="<?php echo admin_url( 'nav-menus.php?page-tab=all&selectall=1#posttype-user-registration-modal' ); ?>"
					   class="select-all"><?php _e( 'Select all', 'user-registration-extras' ); ?></a>
					</span>
					<span class="add-to-menu">
					<input type="submit" class="button-secondary submit-add-to-menu right"
						   value="<?php esc_attr_e( 'Add to menu', 'user-registration-extras' ); ?>"
						   name="add-post-type-menu-item" id="submit-posttype-user-registration-modal">
					<span class="spinner"></span>
					</span>
				</p>
			</div>
			<?php
		}

		/**
		 * Add dashboard menu item.
		 */
		public function dashboard_menu() {
			add_submenu_page(
				'user-registration',
				__( 'User Registration Dashboard', 'user-registration-extras' ),
				__( 'Dashboard', 'user-registration-extras' ),
				'manage_user_registration',
				'user-registration-dashboard',
				array(
					$this,
					'dashboard_page',
				)
			);
		}

		/*
		*  Init the dashboard page.
		*/
		public function dashboard_page() {
			// User_Registration_Extras_Dashboard_Analytics::output();
			require USER_REGISTRATION_EXTRAS_TEMPLATE_PATH . '/dashboard.php';
		}

	}

}
