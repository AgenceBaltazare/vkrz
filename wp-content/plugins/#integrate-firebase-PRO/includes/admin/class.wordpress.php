<?php

/**
 * WordPress Custom Hooks
 */

class FirebaseCustomWordPress {
  private static $initiated = false;
  private static $options_auth;
  private static $options_wordpress;

  private static $firebase_service;

  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    self::$initiated = true;
    self::$options_auth = get_option("firebase_auth");
    self::$options_wordpress = get_option("firebase_wordpress");

    if (self::$options_wordpress && isset(self::$options_wordpress['wp_sync_database_type'])) {
      self::$firebase_service = include FIREBASE_WP__PLUGIN_DIR . 'includes/service/class.firebase-service.php';
      add_action('wp_insert_post', array('FirebaseCustomWordPress', 'listen_to_save_post_event'), 10, 3);
      add_action('wp_trash_post', array('FirebaseCustomWordPress', 'listen_to_delete_post_event'), 10, 3);

      // Taxonomy
      add_action('create_category', array('FirebaseCustomWordPress', 'listen_to_update_category_event'), 10, 1);
      add_action('edited_category', array('FirebaseCustomWordPress', 'listen_to_update_category_event'), 10, 1);
      add_action('delete_category', array('FirebaseCustomWordPress', 'listen_to_delete_category_event'), 10, 1);

      // profile
      add_action('profile_update', array('FirebaseCustomWordPress', 'listen_to_profile_update_event'), 10, 2);
      // add_action('updated_user_meta', array('FirebaseCustomWordPress', 'listen_to_profile_update_event'), 10, 3);
    }

    // Disable password reset for login with firebase feature
    if (self::$options_auth && isset(self::$options_auth['login_with_firebase'])) {
      add_filter('show_password_fields', array('FirebaseCustomWordPress', 'disable_password_fields'));
    }
  }

  private static function write_log($log) {
    if (true === WP_DEBUG) {
      if (is_array($log) || is_object($log)) {
        error_log(print_r($log, true));
      } else {
        error_log($log);
      }
    }
  }

  public static function disable_password_fields() {
    if (current_user_can('administrator')) {
      return true;
    }
    return false;
  }

  public static function listen_to_save_post_event($post_id, $post, $update) {
    // If this is just a revision, skip action
    if (wp_is_post_revision($post)) {
      return;
    }

    if ($post->post_status == 'publish' || $post->post_status == 'private' || $post->post_status == 'draft') {
      $post->permalink = get_the_permalink($post_id);
      $post->post_author_name = get_the_author_meta('display_name', $post->post_author);
      $post->post_thumbnail = get_the_post_thumbnail_url($post_id, 'post-thumbnail');

      // Get post type by post.
      $post_type = $post->post_type;

      // Get post type taxonomies.
      $taxonomies = get_object_taxonomies($post_type, 'objects');

      $taxonomyList = new stdClass();

      foreach ($taxonomies as $taxonomy_slug => $taxonomy) {

        // Get the terms related to post.
        $terms = get_the_terms($post->ID, $taxonomy_slug);

        if (!empty($terms)) {
          $taxoKey = $taxonomy->label;
          $taxonomyList->$taxoKey = $terms;
        }
      }

      $post->taxonomies = $taxonomyList;

      // Get custom fields
      $custom_fields = new stdClass();
      $postmetas = get_post_meta($post_id);

      foreach ($postmetas as $key => $value) {
        if (substr($key, 0, 1) !== '_') {
          if (!empty(get_post_meta($post_id, $key)[0])) {

            $data = get_post_meta($post_id, $key, true);

            // get_field only exist in ACF
            if (function_exists('get_field')) {
              $data = get_field($key, $post_id);
            }

            $custom_fields->$key = $data;

            if (is_array($data) && isset($data['type'])) {
              switch ($data['type']) {
                case 'image':
                  $custom_fields->$key = $data['url'];
                  break;

                default:
                  break;
              }
            }
          }
        }
      }

      $post->custom_fields = $custom_fields;

      if (is_object(get_userdata($post->post_author))) {
        // Get author info
        $author_data = get_userdata($post->post_author)->data;

        $author_object = new stdClass();
        $author_object->id = $author_data->ID;
        $author_object->user_login = $author_data->user_login;
        $author_object->user_nicename = $author_data->user_nicename;
        $author_object->display_name = $author_data->display_name;
        $author_object->user_url = $author_data->user_url;
        $author_object->user_registered = $author_data->user_registered;

        // get user meta data
        $author_metadata = get_user_meta($author_data->ID);

        if ($author_metadata && !empty($author_metadata['firebase_uid'])) {
          $author_object->firebase_uid = $author_metadata['firebase_uid'][0];
        }

        $post->author = $author_object;
      }

      return self::$firebase_service->save_wordpress_data_to_firebase($post_id, $post);
    }
  }

  public static function listen_to_delete_post_event($post_id) {
    $post_type = get_post_type($post_id);

    if ($post_type === 'revision') {
      return;
    }

    return self::$firebase_service->delete_wordpress_data_from_firebase($post_id, $post_type);
  }

  public static function listen_to_update_category_event($category_id) {
    $request = new WP_REST_Request('GET', "/wp/v2/categories/$category_id");
    $response = rest_do_request($request);

    if ($response->is_error()) {
      error_log('[Firebase] - Could not get category ' . $category_id);
      return;
    }

    $category = (object) $response->get_data();
    return self::$firebase_service->save_taxonomy_data_to_firebase('wpCategories', $category);
  }

  public static function listen_to_delete_category_event($category_id) {
    return self::$firebase_service->delete_taxonomy_data_to_firebase('wpCategories', $category_id);
  }

  public static function listen_to_profile_update_event($user_id, $old_user_data) {
    $firebase_user = [];
    $firebase_uid = get_user_meta($user_id, 'firebase_uid', true);

    $firebase_user['photoURL'] = get_avatar_url($user_id);
    $firebase_user['userId'] = $firebase_uid;
    $firebase_user['wordpressUserId'] = $user_id;

    // $new_user_email = $user_data['user_email'];
    // $old_user_email = $old_user_data->data->user_email;

    // if ($new_user_email !== $old_user_email) {
    //   // Do something if old and new email aren't the same
    // }

    $firebase_synced_data = get_user_meta($user_id, 'firebase_synced_data', true) ?? [];

    // TODO: add more conditions to check if user data has changed
    if (empty($firebase_synced_data) || $firebase_synced_data['photoURL'] !== $firebase_user['photoURL']) {
      self::$firebase_service->sync_user_profile_to_firebase($firebase_user);
    }
  }
}
