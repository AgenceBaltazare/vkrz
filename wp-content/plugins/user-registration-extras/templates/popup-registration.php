<?php
/**
 * User Registration Extras Popup
 *
 * Shows user registration popup form
 *
 * @author  WPEverest
 * @package UserRegistrationExtras/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$popup_title  = $popup_content->popup_title;
$popup_type   = $popup_content->popup_type;
$popup_status = $popup_content->popup_status;
$popup_header = $popup_content->popup_header;
$popup_footer = $popup_content->popup_footer;
$popup_size   = $popup_content->popup_size;

$popup_size_class = '';

if ( 'large' === $popup_size ) {
	$popup_size_class = 'user-registration-modal__content--lg';
} elseif ( 'extra_large' === $popup_size ) {
	$popup_size_class = 'user-registration-modal__content--xl';
}

?>
<div class="user-registration-modal user-registration-modal-<?php echo $popup_id; ?>" style="<?php echo $display; ?>">

	<div class="user-registration-modal__backdrop"></div>

<div class="user-registration-modal__content <?php echo $popup_size_class; ?>">
		<?php
		if ( '' !== $popup_header ) {
			?>
			<div class="user-registration-modal__header">
				<h4 class="user-registration-modal__title"><?php echo $popup_header; ?></h4>
				<span class="user-registration-modal__close-icon"></span>
			</div>
			<?php
		}
		?>
		<div class="user-registration-modal__body">
			<?php
			if ( 'registration' === $popup_type ) {
					echo do_shortcode( '[user_registration_form id="' . $popup_content->form . '"]' );
			} else {
				echo do_shortcode( '[user_registration_login]' );
			}
			?>
		</div>
		<?php
		if ( '' !== $popup_header ) {
			?>
		<div class="user-registration-modal__footer">
			<p><?php echo $popup_footer; ?></p>
		</div>
			<?php
		}
		?>
</div>
</div>
