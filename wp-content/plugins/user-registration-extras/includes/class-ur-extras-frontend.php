<?php
/**
 * UserRegistrationExtras Frontend.
 *
 * @class    User_Registration_Extras_Frontend
 * @version  1.0.0
 * @package  UserRegistrationExtras/Admin
 * @category Admin
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * User_Registration_Extras_Frontend Class
 */
class User_Registration_Extras_Frontend {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {

		add_action( 'user_registration_enqueue_scripts', array( $this, 'load_scripts' ), 10, 2 );
		add_action( 'user_registration_my_account_enqueue_scripts', array( $this, 'load_scripts' ), 10, 2 );
		add_filter( 'user_registration_handle_form_fields', array( $this, 'user_registration_user_pass_form_field_filter' ), 10, 2 );
		add_action( 'user_registration_after_form_fields', array( $this, 'user_registration_form_field_honeypot' ), 10, 2 );
		add_action( 'wp_footer', array( $this, 'user_registration_extras_display_active_menu_popup' ) );

		$delete_account = get_option( 'user_registration_extras_general_setting_delete_account', 'disable' );

		if ( 'disable' !== $delete_account ) {
			add_action( 'init', array( $this, 'user_registration_add_delete_account_endpoint' ) );
			add_filter( 'user_registration_account_menu_items', array( $this, 'delete_account_item_tab' ) );
		}
	}

	/**
	 * Add payment endpoint.
	 */
	public function user_registration_add_delete_account_endpoint() {
		$mask = Ur()->query->get_endpoints_mask();
		add_rewrite_endpoint( 'delete-account', $mask );
	}

	/**
	 * Add the item to the $items array
	 *
	 * @param mixed $items Items.
	 */
	public function delete_account_item_tab( $items ) {
		$new_items                   = array();
		$new_items['delete-account'] = __( 'Delete Account', 'user-registration-extras' );

		return $this->delete_account_insert_before_helper( $items, $new_items, 'user-logout' );
	}

	/**
	 * Delete Account insert after helper.
	 *
	 * @param mixed $items Items.
	 * @param mixed $new_items New items.
	 * @param mixed $before Before item.
	 */
	public function delete_account_insert_before_helper( $items, $new_items, $before ) {

		// Search for the item position.
		$position = array_search( $before, array_keys( $items ), true );

		// Insert the new item.
		$return_items  = array_slice( $items, 0, $position, true );
		$return_items += $new_items;
		$return_items += array_slice( $items, $position, count( $items ) - $position, true );

		return $return_items;
	}

	/**
	 * Load script files and localization for js.
	 *
	 * @param array $form_data_array Form Data.
	 * @param int   $form_id Form Id.
	 */
	public function load_scripts( $form_data_array, $form_id ) {

		$delete_account_option      = get_option( 'user_registration_extras_general_setting_delete_account', 'disable' );
		$delete_account_popup_html  = '';
		$delete_account_popup_title = apply_filters( 'user_registration_extras_delete_account_popup_title', __( 'Are you sure you want to delete your account? ', 'user-registration-extras' ) );
		if ( 'prompt_password' === $delete_account_option ) {
			$delete_account_popup_html = apply_filters( 'user_registration_extras_delete_account_popup_message', __( '<p>This will erase all of your account data from the site. To delete your account enter your password below.</p>', 'user-registration-extras' ) ) . '<input type="password" id="password" class="swal2-input" placeholder="Password">';
		} elseif ( 'direct_delete' === $delete_account_option ) {
			$delete_account_popup_html = apply_filters( 'user_registration_extras_delete_account_popup_message', __( '<p>This will erase all of your account data from the site.</p>.', 'user-registration-extras' ) );
		}

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script( 'user-registration-extras-frontend-script', USER_REGISTRATION_EXTRAS_ASSETS_URL . '/js/frontend/user-registration-extras-frontend' . $min . '.js', array( 'jquery' ), USER_REGISTRATION_EXTRAS_VERSION );

		wp_enqueue_script( 'user-registration-extras-frontend-script' );
		wp_localize_script(
			'user-registration-extras-frontend-script',
			'user_registration_extras_frontend_data',
			array(
				'ajax_url'                   => admin_url( 'admin-ajax.php' ),
				'is_user_logged_in'          => is_user_logged_in(),
				'has_create_user_capability' => current_user_can( apply_filters( 'ur_registration_user_capability', 'create_users' ) ),
				'delete_account_option'      => get_option( 'user_registration_extras_general_setting_delete_account', 'disable' ),
				'delete_account_popup_title' => $delete_account_popup_title,
				'delete_account_popup_html'  => $delete_account_popup_html,
				'delete_account_button_text' => __( 'Delete Account', 'user-registration-extras' ),
				'cancel_button_text'         => __( 'Cancel', 'user-registration-extras' ),
				'please_enter_password'      => __( 'Please enter password', 'user-registration-extras' ),
				'account_deleted_message'    => __( 'Account successfully deleted!', 'user-registration-extras' ),
			)
		);
	}

	/**
	 * Add honeypot field template to exisiting form in frontend.
	 *
	 * @param array $grid_data Grid data of Form parsed from form's post content.
	 * @param int   $form_id ID of the form.
	 */
	public function user_registration_user_pass_form_field_filter( $grid_data, $form_id ) {
		$activated_form_list = get_option( 'user_registration_auto_password_activated_forms', array() );
		if ( in_array( $form_id, $activated_form_list, true ) ) {

			foreach ( $grid_data as $grid_data_key => $single_item ) {

				if ( 'user_pass' === $single_item->field_key || 'user_confirm_password' === $single_item->field_key ) {
					unset( $grid_data[ $grid_data_key ] );
				}
			}
		}
		return $grid_data;
	}

	/**
	 * Retrieves and displays all popups rendered in nav menu item.
	 */
	public function user_registration_extras_display_active_menu_popup() {
		$menus  = get_nav_menu_locations();
		$popups = array();

		foreach ( $menus as $key => $value ) {

			if ( isset( $value ) ) {

				$menu_item = wp_get_nav_menu_items( $menus[ $key ] );

				if ( is_array( $menu_item ) ) {

					foreach ( $menu_item as $item ) {

						if ( $item && 'user-registration-modal-link' === $item->classes[0] ) {
							$popup_id = substr( $item->classes[1], 29 );

							// Check if multiple popups with same id exists.
							if ( ! in_array( $popup_id, $popups ) ) {
								array_push( $popups, $popup_id );
								$post = get_post( $popup_id );

								if ( isset( $post->post_content ) ) {
									$popup_content = json_decode( $post->post_content );

									if ( '1' === $popup_content->popup_status ) {

										$current_user_capability = apply_filters( 'ur_registration_user_capability', 'create_users' );

										if ( ( is_user_logged_in() && current_user_can( $current_user_capability ) ) || ! is_user_logged_in() ) {
											$display = 'display:none;';
											require USER_REGISTRATION_EXTRAS_TEMPLATE_PATH . '/popup-registration.php';
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Add honeypot field template to exisiting form in frontend.
	 *
	 * @since 1.0.0
	 * @param array $form_data_array Form data parsed from form's post content.
	 * @param int   $form_id ID of the form.
	 */
	public function user_registration_form_field_honeypot( $form_data_array, $form_id ) {
		$activated_form_list = get_option( 'user_registration_extras_spam_protection_by_honeypot_enabled_forms', array() );

		if ( in_array( $form_id, $activated_form_list ) ) {
			$names = array( 'Name', 'Phone', 'Comment', 'Message', 'Email', 'Website' );
			$name  = $names[ array_rand( $names ) ];
			?>
		<div class="ur-form-row ur-honeypot-container" style="display: none!important;position: absolute!important;left: -9000px!important;">
			<div class="ur-form-grid ur-grid-1" style="width:99%">
				<div class="ur-field-item field-honeypot">
					<div class="form-row " id="honeypot_field" data-priority="">
						<label for="honeypot" class="ur-label"><?php echo esc_html( $name ); ?>
						</label>
						<input data-rules="" data-id="honeypot" type="text" class="input-text input-text ur-frontend-field  " name="honeypot" id="honeypot" placeholder="" value="" data-label="<?php esc_html( $name ); ?>">
					</div>
				</div>
			</div>
		</div>
			<?php
		}
	}
}
