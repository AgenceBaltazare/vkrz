<?php
/**
 * URAF_AJAX
 *
 * AJAX Event Handler
 *
 * @class    URAF_AJAX
 * @since  1.3.0
 * @package  UserRegistrationAdvancedFields/Classes
 * @category Class
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URAF_AJAX Class
 */
class URAF_AJAX {

	/**
	 * Hooks in ajax handlers.
	 */
	public static function init() {

		self::add_ajax_events();

	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax)
	 */
	public static function add_ajax_events() {

		$ajax_events = array(
			'method_upload' => true,
		);
		foreach ( $ajax_events as $ajax_event => $nopriv ) {

			add_action( 'wp_ajax_uraf_profile_picture_upload_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {

				add_action(
					'wp_ajax_nopriv_uraf_profile_picture_upload_' . $ajax_event,
					array(
						__CLASS__,
						$ajax_event,
					)
				);
			}
		}
	}


	/**
	 * User input dropped function.
	 */
	public static function method_upload() {

		check_ajax_referer( 'uraf_profile_picture_upload_nonce', 'security' );

		$nonce = isset( $_REQUEST['security'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ) : false;

		$flag = wp_verify_nonce( $nonce, 'uraf_profile_picture_upload_nonce' );

		if ( true != $flag || is_wp_error( $flag ) ) {

			wp_send_json_error(
				array(
					'message' => __( 'Nonce error, please reload.', 'user-registration-advanced-fields' ),
				)
			);
		}

		$upload = isset( $_FILES['file'] ) ? $_FILES['file'] : array();

		$max_size = wp_max_upload_size();
		$max_size = size_format( $max_size );

		// Retrieves cropped picture dimensions from ajax request.
		$value              = $_REQUEST['cropped_image'];
		$cropped_image_size = json_decode( stripslashes( $value ), true );

		if ( ! isset( $upload['size'] ) || ( isset( $upload['size'] ) && $upload['size'] < 1 ) ) {

			wp_send_json_error(
				array(
					/* translators: %s - Max Size */
					'message' => sprintf( __( 'Please upload a picture with size less than %s', 'user-registration-advanced-fields' ), $max_size ),
				)
			);
		}

		$uploads = apply_filters( 'user_registration_file_upload_url', wp_upload_dir() ); /*Get path of upload dir of WordPress*/

		if ( ! is_writable( $uploads['path'] ) ) {  /*Check if upload dir is writable*/
			wp_send_json_error(
				array(

					'message' => __( 'Upload path permission deny.', 'user-registration-advanced-fields' ),
				)
			);

		}
		$post_overrides = array(
			'post_status' => 'publish',
			'post_title'  => $upload['name'],
		);
		$attachment_id  = media_handle_sideload( $upload, (int) 0, $post_overrides['post_title'], $post_overrides );

		if ( is_wp_error( $attachment_id ) ) {

			wp_send_json_error(
				array(

					'message' => $attachment_id->get_error_message(),
				)
			);
		}
		$url = wp_get_attachment_url( $attachment_id );

		// Retreives the directory path of uploaded picture.
		$pic_path = wp_get_upload_dir()['path'] . '/' . basename( get_attached_file( $attachment_id ) );

		// Retrieves original picture height and width.
		list( $original_image_width, $original_image_height ) = getimagesize( $pic_path );

		// Determines the type of uploaded picture and treats them differently.
		switch ( $upload['type'] ) {
			case 'image/png':
				$img_r = imagecreatefrompng( $pic_path );
				break;
			case 'image/gif':
				$img_r = imagecreatefromgif( $pic_path );
				break;
			default:
				$img_r = imagecreatefromjpeg( $pic_path );
		}

		$cropped_image_holder_width  = rtrim( $cropped_image_size['holder_width'], 'px' );
		$cropped_image_holder_height = rtrim( $cropped_image_size['holder_height'], 'px' );

		// Calculates the actual portion of original picture where the cropping is applied.
		$cropped_image_width  = absint( $cropped_image_size['w'] * $original_image_width / $cropped_image_holder_width );
		$cropped_image_left   = absint( $cropped_image_size['x'] * $original_image_width / $cropped_image_holder_width );
		$cropped_image_height = absint( $cropped_image_size['h'] * $original_image_height / $cropped_image_holder_height );
		$cropped_image_right  = absint( $cropped_image_size['y'] * $original_image_height / $cropped_image_holder_height );

		// Creates a frame of original height and width and copies the cropped picture portion to the frame.
		$dst_r = wp_imageCreateTrueColor( $original_image_width, $original_image_height );
		imagecopyresampled( $dst_r, $img_r, 0, 0, $cropped_image_left, $cropped_image_right, $original_image_width, $original_image_height, $cropped_image_width, $cropped_image_height );

		// Resizes the cropped picture to a size of 150 by 150.
		$dest_r = wp_imageCreateTrueColor( 150, 150 );
		imagecopyresampled( $dest_r, $dst_r, 0, 0, 0, 0, 150, 150, $original_image_width, $original_image_height );

		// Replaces the original picture with the cropped picture.
		$img_r = imagejpeg( $dest_r, wp_get_upload_dir()['path'] . '/' . basename( get_attached_file( $attachment_id ) ) );

		if ( empty( $url ) ) {
			$url = home_url() . '/wp-includes/images/media/text.png';
		}

		wp_send_json_success(
			array(
				'attachment_id'       => $attachment_id,
				'profile_picture_url' => $url,
			)
		);

	}


}

URAF_AJAX::init();
