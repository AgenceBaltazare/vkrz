<?php
/**
 * Form View: WYSIWYG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="ur-input-type-wysiwyg ur-admin-template">

	<div class="ur-label">
		<label><?php echo esc_html( $this->get_general_setting_data( 'label' ) ); ?></label>

	</div>
	<div class="ur-field" data-field-key="wysiwyg">
		<?php
			$settings = array(
				'media_buttons' => false,
				'editor_class'  => 'wysiwyg input-text ur-frontend-field',
			);
			wp_editor( '', 'ur-input-type-wysiwyg', $settings );
			?>

	</div>
	<?php

	UR_Form_Field_Wysiwyg::get_instance()->get_setting();

	?>
</div>
