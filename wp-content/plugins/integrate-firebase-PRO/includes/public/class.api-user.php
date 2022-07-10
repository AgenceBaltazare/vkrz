<?php

/**
 * REST API for User Management
 */

defined('ABSPATH') || exit;

class Firebase_Rest_Api_User {
  private static $initiated = false;
  private static $firebase_service;
  private static $options_settings;

  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    self::$initiated = true;
    self::$options_settings = get_option("firebase_settings");
    // Import Firebase Service
    if (isset(self::$options_settings['base_domain']) && isset(self::$options_settings['dashboard_api_token'])) {
      self::$firebase_service = include FIREBASE_WP__PLUGIN_DIR . 'includes/service/class.firebase-service.php';
    }
    add_action('rest_api_init', array('Firebase_Rest_Api_User', 'add_api_routes'));
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

  public static function add_api_routes() {
    /**
     * User API Paths
     */

    register_rest_route('firebase/v2', 'users/register-autologin', array(
      'methods' => 'POST',
      'callback' => array('Firebase_Rest_Api_User', 'register_and_autologin'),
      'permission_callback' => '__return_true',
    ));
  }

  private static function update_user_data($user, $firebase_user) {
    update_user_meta($user->ID, "firebase_uid", $firebase_user['userId']);

    if (isset($firebase_user['email']) && !empty($user->user_email)) {
      wp_update_user(array('ID' => $user->ID, 'user_email' => $firebase_user['email']));
    }

    $display_name = $user->display_name;

    // update name if not set or there's no white space
    if (empty($display_name) || strpos($display_name, ' ') === false) {
      // 1 - Assign display name to phone number
      // 2 - Then assign display name to firebase user displayName

      if (!empty($firebase_user['phoneNumber'])) {
        wp_update_user(array('ID' => $user->ID, 'display_name' => $firebase_user['phoneNumber']));
        wp_update_user(array('ID' => $user->ID, 'nickname' => $firebase_user['phoneNumber']));
      }

      if (!empty($firebase_user['displayName'])) {
        wp_update_user(array('ID' => $user->ID, 'display_name' => $firebase_user['displayName']));
        wp_update_user(array('ID' => $user->ID, 'nickname' => $firebase_user['displayName']));
      }

      if (!empty($firebase_user['firstName'])) {
        update_user_meta($user->ID, "first_name", $firebase_user['firstName']);
      }

      if (!empty($firebase_user['lastName'])) {
        update_user_meta($user->ID, "last_name", $firebase_user['lastName']);
      }
    }
  }

  private static function sync_user_data_to_firebase($user, $firebase_user) {
    $synced_user_to_firebase = get_user_meta($user->ID, 'synced_user_to_firebase', true);

    if (empty($synced_user_to_firebase) && self::$firebase_service) {
      // Sync User to Firebase
      $firebase_user['wordpressUserId'] = $user->ID;
      self::$firebase_service->sync_user_to_firebase($firebase_user);
    }
  }

  private static function validate_user_request($request) {
    $error = new WP_Error();

    $site_url = get_site_url();

    $request_origin = $request->get_header('origin');
    $referer = $request->get_header('referer');
    $sec_fetch_site = $request->get_header('sec_fetch_site');
    $firebase_login_key = $request->get_header('firebase-login-key');
    $postman_token = $request->get_header('postman_token');
    $user_agent = $request->get_header('user-agent');

    $auth_source = $request->get_header('auth-source');

    // TODO: apply CSP (Content Security Policy) to improve security
    // if ( ! wp_verify_nonce( $firebase_login_key, 'firebase_login_key' ) ) {
    //   $error->add(400, __("Invalid Firebase Login Key", 'integrate-firebase-PRO'), array('status' => false));
    //   return $error;
    // }

    // Security start since version 2.3.1 & only check if cloud functions is configured
    if (FIREBASE_WP_VERSION >= "2.3.1" && self::$firebase_service) {
      // Check for last sign in time for security purpose
      $parameters = $request->get_json_params();
      $userId = sanitize_text_field($parameters['user']['userId']);
      // $last_login_at = sanitize_text_field($parameters['user']['lastLoginAt']);

      // $phoneNumber = sanitize_text_field(isset($parameters['user']['phoneNumber']) ? $parameters['user']['phoneNumber'] : null);

      // Retrieve firebase user from Firebase
      $firebase_user = apply_filters('firebase_get_firebase_user', $userId, 'lastSignInTime');
      $now = time();
      $last_sign_in_timestamp = date_timestamp_get(new DateTime($firebase_user->lastSignInTime));

      $time_different = $now - $last_sign_in_timestamp;

      // Only check timer for wordpress login
      if ($auth_source === 'wordpress') {
        if ($time_different > 200) {
          error_log("Failed login time 200 " . $time_different);
          $error->add(400, __("Invalid Sign In from Firebase", 'integrate-firebase-PRO'), array('status' => false));
          return $error;
        }
      } else if ($auth_source === 'token') {
        // TODO: add condition for token authentication
        error_log('Time different for token: ' . $time_different);
      } else {
        $error->add(400, __("Invalid Sign In Source", 'integrate-firebase-PRO'), array('status' => false));
        return $error;
      }
    }

    if (!empty($postman_token)) {
      $error->add(400, __("Invalid Request Sources", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    if (empty($firebase_login_key)) {
      $error->add(400, __("Invalid Firebase Login Key", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    if (!empty($sec_fetch_site) && $sec_fetch_site != 'same-origin') {
      $error->add(400, __("Invalid Sec Fetch Site", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    if (
      empty($request_origin) || strpos($site_url, $request_origin) === false
    ) {
      $error->add(400, __("Invalid Request Origin", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    if (
      empty($user_agent) || strpos($user_agent, 'Mozilla/5.0') === false
    ) {
      $error->add(400, __("Request is not from browsers", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    if (
      empty($referer) || strpos($referer, $site_url) === false
    ) {
      $error->add(400, __("Invalid Referer Origin", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    return null;
  }

  private static function validate_user_account($username, $firebase_uid, $email) {

    // get user by firebase uid
    $user = apply_filters('firebase_get_user_by_firebase_uid', $firebase_uid);
    if ($user) {
      return $user;
    }

    // get user by username
    $user = get_user_by('login', $username);
    if ($user) {
      // validate by checking firebase_uid 
      $firebase_uid_from_user = get_user_meta($user->ID, 'firebase_uid', true);
      if ($firebase_uid_from_user === $firebase_uid) {
        return $user;
      }
    }

    // if not found, try to get user by email
    $user = get_user_by('email', $email);

    if ($user) {
      $firebase_uid_from_user = get_user_meta($user->ID, 'firebase_uid', true);

      if ($firebase_uid_from_user !== $firebase_uid) {
        // update new firebase_uid & sync new user to firebase
        update_user_meta($user->ID, 'firebase_uid', $firebase_uid);
        update_user_meta($user->ID, 'synced_user_to_firebase', false);
      }
    }

    return $user;
  }

  public static function register_and_autologin(WP_REST_Request $request = null) {
    $response = array();
    $parameters = $request->get_json_params();

    $error = self::validate_user_request($request);


    if (!empty($error)) {
      return $error;
      // return new WP_Error($error->get_error_code(), __($error->get_error_message()));

    }

    $firebase_user = $parameters['user'];

    $firebase_uid = sanitize_text_field($firebase_user['userId']);
    // Humanize the user name
    $username = apply_filters('firebase_generate_nice_username', $firebase_user);

    $password = sanitize_text_field($firebase_user['password']);
    $email = sanitize_text_field(isset($firebase_user['email']) ? $firebase_user['email'] : '');

    $error = new WP_Error();

    if (empty($firebase_uid)) {
      $error->add(400, __("'userId' is required.", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    if (empty($password)) {
      $error->add(400, __("'password' is required.", 'integrate-firebase-PRO'), array('status' => false));
      return $error;
    }

    $user = self::validate_user_account($username, $firebase_uid, $email);

    if (!empty($user)) {
      $username = $user->data->user_login;

      if (is_multisite()) {
        $blog_id = get_current_blog_id();

        // doesn't exist in current blog
        if (!is_user_member_of_blog($user->ID, $blog_id)) {
          $role = 'subscriber';
          if (class_exists('WooCommerce')) {
            $role = 'customer';
          }
          add_existing_user_to_blog(array('user_id' => $user->ID, 'role' => $role));
        }
      }
    } else {
      // create new user
      // check for multisite
      $user_id = null;

      // create a unique username if username already exists or is empty
      if (empty($username) || username_exists($username)) {
        $username = 'user_' . time();
      }

      if (is_multisite()) {
        $user_id = wpmu_create_user($username, $password, $email);
      } else {
        $user_id = wp_create_user($username, $password, $email);
      }

      if (!is_wp_error($user_id)) {
        $user = get_user_by('id', $user_id);
        // Manually set user role to subscriber for now
        $user->set_role('subscriber');
        // WooCommerce role
        if (class_exists('WooCommerce')) {
          $user->set_role('customer');
        }
        do_action('wp_rest_user_user_register', $user);
      } else {
        $error->add(400, __("Cannot create a new user with email: $email", 'integrate-firebase-PRO'), array('status' => false));
        return $error;
      }
    }

    // Update user metadata
    self::update_user_data($user, $firebase_user);

    // Start auto signon
    $creds['user_login'] = $username;
    $creds['user_password'] = $password;
    $creds['remember'] = true;

    // Sync user data to firebase
    self::sync_user_data_to_firebase($user, $firebase_user);

    // is_ssl() for https sites
    $autologin_user = wp_signon($creds, is_ssl());

    if ($autologin_user->errors) {
      $error_message = $autologin_user->get_error_message();
      // Dominate WP password from Firebase
      wp_set_password($password, $user->ID);
      $autologin_user = wp_signon($creds, is_ssl());

      if (!$autologin_user->errors) {
        $response['code'] = 200;
        $response['message'] = __("User logged in", "integrate-firebase-PRO");
        return new WP_REST_Response($response, 200);
      } else {
        $response['code'] = 403;
        $response['message'] = __($error_message, "integrate-firebase-PRO");
        return new WP_REST_Response($response, 403);
      }
    } else {
      $response['code'] = 200;
      $response['message'] = __("User logged in", "integrate-firebase-PRO");
      return new WP_REST_Response($response, 200);
    }
  }
}
