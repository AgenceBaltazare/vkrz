<?php
/**
 * User_Registration_Field_Visibility_Admin
 *
 * @package  User_Registration_Field_Visibility_Admin
 * @since  1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @class User_Registration_Field_Visibility_Admin
 */
class User_Registration_Field_Visibility_Admin {

	/**
	 * User_Registration_Field_Visibility_Admin Constructor
	 */
	public function __construct() {
		add_action( 'user_registration_after_advance_settings', array( $this, 'field_visibility' ), 10, 2 );
	}


	/**
	 * Field visibility field settings view.
	 *
	 * @param  string $field_id       field_id prefixed with user_registration_.
	 * @param  object $field_settings Field Settings.
	 *
	 * @return void
	 */
	public function field_visibility( $field_id, $field_settings ) {

		$visibility_settings = $this->get_field_visibility_settings( $field_id, $field_settings );

		if ( '' !== $visibility_settings ) {

			echo "<div class='ur-advance-setting-block'>";
			echo '<h2 class="ur-toggle-heading">' . esc_html__( 'Visibility Settings', 'user-registration-field-visibility' ) . '</h2>';
			echo '<hr>';
			echo '<div class="ur-toggle-content">';
			echo $visibility_settings;
			echo '</div></div>';
		}

	}

	/**
	 * Get Field Visibility settings data.
	 *
	 * @param  string $field_id       field_id prefixed with user_registration_.
	 * @param  object $setting_data   Field Settings.
	 *
	 * @return mixed
	 */
	public function get_field_visibility_settings( $field_id, $setting_data ) {

		$file_name  = str_replace( 'user_registration_', '', $field_id );
		$file_name  = explode( '_', $file_name );
		$class_path = dirname( __FILE__ ) . '/fields/class-urfv-setting-' . implode( '-', $file_name ) . '.php';
		$file_name  = array_map( 'ucwords', $file_name );
		$class_name = 'URFV_Setting_' . implode( '_', $file_name );

		include_once dirname( __FILE__ ) . '/fields/class-urfv-setting-base.php';
		if ( file_exists( $class_path ) ) {
			include_once $class_path;
			if ( class_exists( $class_name ) ) {
				$instance = new $class_name();
				return $instance->output( $setting_data );
			}
		}

		return '';
	}
}

new User_Registration_Field_Visibility_Admin();
