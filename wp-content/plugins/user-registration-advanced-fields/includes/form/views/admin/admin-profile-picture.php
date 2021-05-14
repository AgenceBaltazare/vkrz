<?php
/**
 * Form View: Profile Picture
 *
 * @since  1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$gravatar_image = plugins_url( '/assets/img/default_profile.png', URAF_PLUGIN_FILE );

?>
<div class="ur-input-type-profile-picture ur-admin-template">

	<div class="ur-label">
		<label><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></label>
	</div>

	<div class="ur-field" data-field-key="profile_picture">
		<p id="profile_pic_url_field">
			<img class="profile-preview" alt="profile-picture" src="<?php echo $gravatar_image; ?>" style="max-width:96px; max-height:96px;">
		</p>
		<button disabled type="button" class="button wp_uraf_take_snapshot">Take Picture</button>
		<button disabled type="button" class="button wp_uraf_profile_picture_upload">Upload file</button>
	</div>

	<?php
	UR_Form_Field_Multi_Select2::get_instance()->get_setting();
	?>
</div>
