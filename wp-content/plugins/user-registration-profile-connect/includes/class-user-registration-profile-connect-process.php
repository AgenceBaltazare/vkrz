<?php
/**
 * User_Registration_Profile_Connect_Process
 * @package  User_Registration_Profile_Connect_Process
 * @since  1.0.0 
 */

defined( 'ABSPATH' ) || exit;	

/**
 * @class User_Registration_Profile_Connect_Process
 */
Class User_Registration_Profile_Connect_Process {

	/**
	 * User_Registration_Profile_Connect_Process Constructor
	 */
	public function __construct() {

		//Bulk action.
		add_action( 'manage_users_extra_tablenav', array( $this, 'profile_connect' ), 10000 ) ;
		add_action( 'load-users.php', array( $this, 'profile_connect_process' ) );

		//Show form connection option on individual profile page.
		add_action( 'show_user_profile', array( $this, 'render_profile_field' ) );
		add_action( 'edit_user_profile', array( $this, 'render_profile_field' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_profile_field' ), 1, 1 );

		//Fires immediately after an existing user is updated.
		add_action( 'profile_update', array( $this, 'save_profile_field' ), 1, 1 );
	}

	/**
	 * Extra dropdown to connect form on users tab
	 * @param  string $which navbar position
	 * @return void
	 */
	public function profile_connect( $which ) {

		$all_forms = ur_get_all_user_registration_form(); // Get all user registration forms.
		$id = 'bottom' === $which ? 'new_form2' : 'new_form';
		$button_id = 'bottom' === $which ? 'connectit2' : 'connectit';
		?>
		<div class="alignleft actions">
			<?php if ( current_user_can( 'promote_users' ) ) : ?>
			<label class="screen-reader-text" for="<?php echo $id ?>"><?php _e( 'Connect with form&hellip;', 'user-registration-profile-connect' ) ?></label>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>">
				<option value=""><?php _e( 'Connect with form&hellip;', 'user-registration-profile-connect' ) ?></option>
				<option value="-1"><?php _e( 'None','user-registration-profile-connect' )?></option>
				<?php foreach( $all_forms as $key => $form ) {
					?><option value="<?php echo esc_attr( $key );?>"><?php echo esc_attr( $form )  ?></option><?php
				}
				?>
			</select>
		<?php
				wp_nonce_field( 'ur-connect-form', 'ur-connect-form-nonce' );
				submit_button( __( 'Connect', 'user-registration-profile-connect' ), '', $button_id, false );
			endif;
	}

	/**
	 * Process for the form connection for selected users
	 * @return void
	 */
	public function profile_connect_process() {
		// Output the admin notice.
		add_action( 'admin_notices', array( $this, 'profile_connect_notice' ) );

		// Return if nonce check fails.
		if ( empty( $_REQUEST['users'] ) || empty( $_REQUEST['new_form'] ) 
		    || ! wp_verify_nonce( $_REQUEST['ur-connect-form-nonce'], 'ur-connect-form' ) ) {
			return;
		}

		// Return if current user cannot edit users.
		if ( ! current_user_can( 'edit_user' ) ) {
			throw new Exception( 'You donot have enough permission to perform this action' );
		}

		$users = array_map( 'absint', $_REQUEST['users'] );
		$connected = 0;
		$disconnected = 0;

		foreach( $users as $user ) {
			if( $_REQUEST['new_form'] === '-1' ){
				delete_user_meta( $user, 'ur_form_id');
				$disconnected++;
			}
			else {
				update_user_meta( $user, 'ur_form_id', sanitize_text_field( $_REQUEST['new_form'] ) );
				$connected++;	
			}
		}

		if( $connected > 0 ) {
			$redirect = add_query_arg( array( 'connected' => 'form-connection-success', 'users' => $connected ), 'users.php' );
		} else if( $disconnected > 0 ){
			$redirect = add_query_arg( array( 'connected' => 'form-disconnected-success', 'users' => $disconnected ), 'users.php' ); 
		} else {
			$redirect = add_query_arg( array( 'connected' => 'form-connection-error' ), 'users.php' );
		}

		wp_safe_redirect( $redirect );
		exit();	
	}

	/**
	 * Notice for sucess or failure
	 */
	public function profile_connect_notice() {

		if ( 'users' != get_current_screen()->id ) {
			return;
		}	

		$connected = isset( $_REQUEST['connected'] ) ? $_REQUEST['connected'] : false;
		$users = isset( $_REQUEST['users'] ) ? $_REQUEST['users'] : '';	

		if( 'form-connection-success' === $connected ) {
			echo '<div id="user-approvation-result" class="notice notice-success is-dismissible"><p><strong>' . sprintf( __( 'Form connected for %s user(s)! ', 'user-registration-profile-connect' ), $users ) . '</strong></p></div>';	
		} else if( 'form-connection-error' === $connected ) {
			echo '<div id="user-approvation-result" class="notice notice-error is-dismissible"><p><strong>' . __( 'Form Connection Failed! Please try again. ', 'user-registration-profile-connect' ) . '</strong></p></div>';
		} else if( 'form-disconnected-success' === $connected ) {
			echo '<div id="user-approvation-result" class="notice notice-error is-dismissible"><p><strong>' . sprintf( __( 'Form disconnected for the %s user(s)! ', 'user-registration-profile-connect' ), $users ) . '</strong></p></div>';
		}
	}

	/**
	 * Render the form connection option in user profile
	 * @param WP_Object $user User Instance
	 */
	public function render_profile_field( $user ) {

		// Return if current user cannot edit users.
		if ( ! current_user_can( 'edit_user' ) ) {
			throw new Exception( 'You donot have enough permission to perform this action' );
		}
		?>
			<table class="form-table">
				<tr>
					<th><label for="ur_profile_connect"><?php _e( 'Connect To Form', 'user-registration-profile-connect' ); ?></label>
					</th>
					<td>
						<select id="ur_profile_connect" name="ur_profile_connect">
							<?php
							$all_forms = ur_get_all_user_registration_form(); 
							$selected = get_user_meta( $user->ID, 'ur_form_id', true );
							?><option value="-1"><?php _e( 'None','user-registration-profile-connect' ); ?></option><?php
							foreach (  $all_forms as $key => $form ) : ?>
								<option
									value="<?php echo esc_attr( $key ); ?>" <?php selected( $selected, $key ); ?> ?><?php echo esc_attr( $form );  ?></option>
							<?php endforeach; ?>
						</select>

						<span class="description"><?php _e( 'Connect this user to form.', 'user-registration-profile-connect' ); ?></span>
					</td>
				</tr>
			</table>
		<?php
	}

	/**
	 * Save the profile 
	 * @param  int $user_id
	 */
	public function save_profile_field( $user_id ) {

		if ( ! current_user_can( 'edit_users', $user_id ) ) {
			return false;
		}
		if ( empty( $_POST['ur_profile_connect'] ) )	{
			return false;
		}

		update_user_meta( $user_id, 'ur_form_id', sanitize_text_field( $_POST['ur_profile_connect'] ) );
	}
}

new User_Registration_Profile_Connect_Process;