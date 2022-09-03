<?php
/* Set up upload field for frontend */
/* overwrite the two functions for when an upload is made from the frontend so they don't check for a logged in user */
if( strpos( wp_get_referer(), 'wp-admin' ) === false && isset( $_REQUEST['action'] ) && 'upload-attachment' == $_REQUEST['action'] ){
    if( !function_exists( 'check_ajax_referer' ) ){
        function check_ajax_referer( ) {
            return true;
        }
    }

    if( !function_exists( 'auth_redirect' ) ){
        function auth_redirect() {
            return true;
        }
    }
}

/* create a fake user with the "upload_posts" capability and assign him to the global $current_user. this is used to bypass the checks for current_user_can('upload_files') in async-upload.php */
add_action( 'current_screen', 'wppb_create_fake_user_when_uploading_and_not_logged_in' );
if( !function_exists( 'wppb_create_fake_user_when_uploading_and_not_logged_in' ) ) {
    function wppb_create_fake_user_when_uploading_and_not_logged_in()
    {
        if ( isset($_REQUEST['action']) && 'upload-attachment' == $_REQUEST['action'] && isset($_REQUEST['wppb_upload']) && 'true' == $_REQUEST['wppb_upload'] ) {
            if (!is_user_logged_in() || !current_user_can('upload_files') || !current_user_can('edit_posts')) {
                global $current_user;
                $current_user = new WP_User(0, 'frontend_uploader');
                $current_user->allcaps = array("upload_files" => true, "edit_posts" => true, "edit_others_posts" => true, "edit_pages" => true, "edit_others_pages" => true);
            }
        }
    }
}

/* for a request of a upload from the frontend and no user is logged in don't query for attachments */
add_action( 'after_setup_theme', 'wppb_modify_query_attachements_when_not_logged_in' );
if( !function_exists( 'wppb_modify_query_attachements_when_not_logged_in' ) ) {
    function wppb_modify_query_attachements_when_not_logged_in()
    {
        if (strpos(wp_get_referer(), 'wp-admin') === false && !is_user_logged_in()) {
            add_action('wp_ajax_query-attachments', 'wppb_wp_ajax_not_loggedin_query_attachments', 0);
            add_action('wp_ajax_nopriv_query-attachments', 'wppb_wp_ajax_not_loggedin_query_attachments', 0);
            function wppb_wp_ajax_not_loggedin_query_attachments()
            {
                wp_send_json_success();
            }
        }
    }
}

/* restrict file types of the upload field functionality */
add_filter('wp_handle_upload_prefilter', 'wppb_upload_file_type');
if( !function_exists( 'wppb_upload_file_type' ) ) {
    function wppb_upload_file_type($file)
    {
        if( isset( $_POST['wppb_upload'] ) && $_POST['wppb_upload'] == 'true'  ) {

            // file size limits.
            $size = $file['size'];
            $limit = apply_filters('wppb_server_max_upload_size_byte_constant', wppb_return_bytes(ini_get('upload_max_filesize')));
            if ( $size > $limit )  {
                $limit = $limit / ( 1024 * 1024 ) ;
                $file['error'] = __("Files must be smaller than ", "profile-builder") . $limit . 'MB';
            }

            if (isset($_POST['meta_name']) && !empty($_POST['meta_name'])) {
                $meta_name = sanitize_text_field( $_POST['meta_name'] );
                /*let's get the field details so we can see if we have any file restrictions */
                $all_fields = apply_filters( 'wppb_form_fields', get_option('wppb_manage_fields'), array( 'context' => 'upload_helper', 'upload_meta_name' => $meta_name ) );
                if (!empty($all_fields)) {
                    foreach ($all_fields as $field) {
                        if ($field['meta-name'] == $meta_name) {
                            $allowed_upload_extensions = '';
                            if ($field['field'] == 'Upload' && !empty($field['allowed-upload-extensions']))
                                $allowed_upload_extensions = $field['allowed-upload-extensions'];
                            if ($field['field'] == 'Avatar' && !empty($field['allowed-image-extensions'])) {
                                if (trim($field['allowed-image-extensions']) == '.*')
                                    $allowed_upload_extensions = '.jpg,.jpeg,.gif,.png,.ico';
                                else
                                    $allowed_upload_extensions = $field['allowed-image-extensions'];
                            }

                            $ext = strtolower( substr(strrchr($file['name'], '.'), 1) );

                            if (!empty($allowed_upload_extensions) && $allowed_upload_extensions != '.*') {
                                $allowed = str_replace('.', '', array_map('trim', explode(",", strtolower( $allowed_upload_extensions))));
                                //first check if the user uploaded the right type
                                if (!in_array($ext, (array)$allowed)) {
                                    $file['error'] = __("Sorry, you cannot upload this file type for this field.", 'profile-builder');
                                    return $file;
                                }
                            }
                            //check if the type is allowed at all by WordPress
                            foreach (get_allowed_mime_types() as $key => $value) {
                                if (strpos($key, $ext) !== false || $key == $ext)
                                    return $file;
                            }
                            $file['error'] = __("Sorry, you cannot upload this file type for this field.", 'profile-builder');
                        }
                    }
                }
            }

            if (empty($_POST['meta_name']))
                $file['error'] = __("An error occurred, please try again later.", 'profile-builder');
        }

        return $file;
    }
}

/**
 * Function that performs validation for the simple upload field
 *
 * @param $field - simple upload field
 * @param $upload - data to be uploaded
 *
 * @return bool
 */
function wppb_valid_simple_upload( $field, $upload ){
    $limit = apply_filters( 'wppb_server_max_upload_size_byte_constant', wppb_return_bytes( ini_get( 'upload_max_filesize' ) ) );
    $allowed_mime_types = get_allowed_mime_types();
    $all_fields = apply_filters( 'wppb_form_fields', get_option( 'wppb_manage_fields' ), array( 'context' => 'upload_helper', 'upload_meta_name' => $field[ 'meta-name' ] ) );
    if ( !empty( $all_fields ) ) {
        foreach ( $all_fields as $form_field ) {
            if ($form_field[ 'meta-name' ] == $field[ 'meta-name' ] ) {
                $allowed_upload_extensions = '';
                if ( $form_field[ 'field' ] == 'Upload' && !empty( $form_field[ 'allowed-upload-extensions' ] ) ) {
                    $allowed_upload_extensions = $form_field[ 'allowed-upload-extensions' ];
                }
                if ( $form_field[ 'field' ] == 'Avatar' ) {
                    if ( trim( $field[ 'allowed-image-extensions' ] ) == '.*' || trim( $field[ 'allowed-image-extensions' ] ) == '' ) {
                        $allowed_upload_extensions = '.jpg,.jpeg,.gif,.png';
                    }
                    else {
                        $allowed_upload_extensions = $form_field[ 'allowed-image-extensions' ];
                    }
                }
                if ( !empty( $allowed_upload_extensions ) && $allowed_upload_extensions != '.*' ) {
                    $allowed_upload_extensions = str_replace( '.', '', array_map( 'trim', explode( ",", strtolower( $allowed_upload_extensions ) ) ) );
                } else {
                    $allowed = true;
                }
                $allowed_by_wordpress = false;
                foreach ( $allowed_mime_types as $key => $val ){
                    if ( $val == $upload[ 'type' ] ){
                        $possible_extensions = explode( '|', $key );
                        $allowed_by_wordpress = true;
                    }
                }
                if ( isset( $possible_extensions ) && $allowed_by_wordpress == true ){
                    if ( !isset( $allowed ) ){
                        $allowed = false;
                        foreach ( $allowed_upload_extensions as $extension ){
                            if ( in_array( $extension, $possible_extensions ) ){
                                $allowed = true;
                            }
                        }
                    }
                    if ( $upload[ 'size' ] > $limit ){
                        $allowed = false;
                    }
                    return $allowed;
                }
                else{
                    return false;
                }
            }
        }
    }
}

/**
 * Function that registers intermediate avatar sizes
 *
 * @param $field - avatar field
 *
 */
function wppb_add_avatar_sizes( $field ){
    if( !empty( $field['avatar-size'] ) )
        add_image_size( 'wppb-avatar-size-'.$field['avatar-size'], $field['avatar-size'], $field['avatar-size'], true );
    else
        add_image_size( 'wppb-avatar-size-100', 100, 100, true );

    add_image_size( 'wppb-avatar-size-64', 64, 64, true );
    add_image_size( 'wppb-avatar-size-26', 26, 26, true );
}

//Function that registers avatar sizes for userlisting
function wppb_userlisting_avatar(){
    $userlisting_posts = get_posts( array( 'posts_per_page' => -1, 'post_status' =>'publish', 'post_type' => 'wppb-ul-cpt', 'orderby' => 'post_date', 'order' => 'ASC' ) );
    if( !empty( $userlisting_posts ) ){
        foreach ( $userlisting_posts as $post ){
            $this_form_settings = get_post_meta( $post->ID, 'wppb_ul_page_settings', true );
            $all_userlisting_avatar_size = apply_filters( 'all_userlisting_avatar_size', ( isset( $this_form_settings[0]['avatar-size-all-userlisting'] ) ? (int)$this_form_settings[0]['avatar-size-all-userlisting'] : 100 ) );
            $single_userlisting_avatar_size = apply_filters( 'single_userlisting_avatar_size', ( isset( $this_form_settings[0]['avatar-size-single-userlisting'] ) ? (int)$this_form_settings[0]['avatar-size-single-userlisting'] : 100 ) );

            add_image_size( 'wppb-avatar-size-'.$all_userlisting_avatar_size, $all_userlisting_avatar_size, $all_userlisting_avatar_size, true );
            add_image_size( 'wppb-avatar-size-'.$single_userlisting_avatar_size, $single_userlisting_avatar_size, $single_userlisting_avatar_size, true );
        }
    }
}

/**
 * Function that checks if the simple upload field belongs to a repeater field with conditional logic enabled
 *
 * @param $field - simple upload field
 *
 * @return bool
 */
function wppb_belongs_to_repeater_with_conditional_logic( $field ){
    $all_fields = apply_filters( 'wppb_form_fields', get_option( 'wppb_manage_fields' ), array( 'context' => 'upload_helper', 'upload_meta_name' => $field[ 'meta-name' ] ) );
    if ( !empty( $all_fields ) ) {
        foreach ( $all_fields as $form_field ) {
            if ( $form_field[ 'field' ] == 'Repeater' && isset( $form_field[ 'conditional-logic-enabled' ] ) && $form_field[ 'conditional-logic-enabled' ] == 'yes' ) {
                $repeater_group = get_option( $form_field[ 'meta-name' ], 'not_set' );
                if ( $repeater_group == 'not_set' ) {
                    continue;
                }
                else{
                    $repeater_count = count( $repeater_group );
                    for ( $i = 0; $i < $repeater_count; $i++ ){
                        if ( $repeater_group[ $i ][ 'field' ] == 'Upload' && isset( $repeater_group[ $i ][ 'simple-upload' ] ) && $repeater_group[ $i ][ 'simple-upload' ] == 'yes' && isset( $_REQUEST[ $form_field[ 'meta-name' ] . '_extra_groups_count' ] ) ){
                            $groups = absint( $_REQUEST[ $form_field[ 'meta-name' ] . '_extra_groups_count' ] );
                            for ( $j = 0; $j <= $groups; $j++ ){
                                $name = $repeater_group[ $i ][ 'meta-name' ];
                                if ( $j != 0 ){
                                    $name .= '_' . $j;
                                }
                                if ( $field[ 'meta-name' ] == $name ){
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return false;
}