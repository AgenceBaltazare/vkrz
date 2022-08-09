<?php

/**
 * Add Firebase setting menu
 * @var [type]
 */

class Firebase_Admin {
  private static $initiated = false;
  private static $notified = false;
  private static $options;
  private static $options_database;
  private static $options_auth;
  private static $options_wordpress;
  private static $options_settings;

  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    self::$initiated = true;
    self::$options = get_option("firebase_credentials");
    self::$options_database = get_option("firebase_database");
    self::$options_auth = get_option("firebase_auth");
    self::$options_wordpress = get_option("firebase_wordpress");
    self::$options_settings = get_option("firebase_settings");

    add_action('admin_menu', array("Firebase_Admin", "add_firebase_admin_menu"));
    add_action("admin_init", array("Firebase_Admin", "register_settings"));
    add_action('admin_enqueue_scripts', array('Firebase_Admin', 'load_firebase_admin_js'));
    add_action('firebase_pro_init', array('Firebase_Admin', 'validate_product'));
  }

  public static function add_firebase_admin_menu() {
    $page_title = 'Firebase for Wordpress';
    $menu_title = 'Firebase';
    $capability = 'manage_options';
    $menu_slug = 'firebase-setting';
    $function = 'display_page';
    $icon_url = 'dashicons-plugins-checked';
    $position = 25;

    add_menu_page(__($page_title, "integrate-firebase-PRO"), __($menu_title, "integrate-firebase-PRO"), $capability, $menu_slug, array("Firebase_Admin", $function), $icon_url, $position);
  }

  public static function validate_product() {
    if (!empty(self::$options_settings['product_key']) && !self::$notified) {
      // Validate product
      $data = new stdClass();
      $data->productKey = self::$options_settings['product_key'];
      $url = "https://techcater.com/api-products/v1/products/IFP_YEARLY/validate";

      if (strpos(get_site_url(), 'techcater-plugins.local') !== false) {
        error_log('--------Validate DEV SITE------------');
        $url = "https://dev.techcater.com/api-products/v1/products/IFP_YEARLY/validate";
      }

      $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
          'Content-Type' => 'application/json; charset=utf-8',
        ),
        'body' => json_encode($data),
      ));


      if (is_wp_error($response)) {
        // ignore checking
      } else if (isset($response['body'])) {
        $result = json_decode($response['body']);
        if (is_object($result) && $result->status == 0) {
          // Show missing error message
          new IFP_Message($result->message, 'error');
        }
      }
    } else {
      // Show missing error message
      new IFP_Message('Your product key is missing. Please go to Firebase > Settings tab and add it.', 'error');
    }

    self::$notified = true;
  }

  public static function load_firebase_admin_js() {
    // Load plugins files

    // @TODO will be imported from Webpack
    // wp_enqueue_style( 'firebase-admin', plugin_dir_url( dirname(__FILE__) ) . 'css/firebase-admin.css' );

    // Datatables Assets
    wp_enqueue_style('firebase-datatables-buttons', '//cdn.datatables.net/buttons/2.2.1/css/buttons.dataTables.min.css', array(), FIREBASE_WP_VERSION, false);

    wp_enqueue_script('firebase-datatables', '//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js', array('jquery'), FIREBASE_WP_VERSION, true);
    wp_enqueue_script('firebase-datatables-buttons', '//cdn.datatables.net/buttons/2.2.1/js/dataTables.buttons.min.js', array('jquery'), FIREBASE_WP_VERSION, true);
    wp_enqueue_script('firebase-datatables-buttons-flash', '//cdn.datatables.net/buttons/2.2.1/js/buttons.flash.min.js', array('jquery'), FIREBASE_WP_VERSION, true);
    wp_enqueue_script('firebase-datatables-buttons-html5', '//cdn.datatables.net/buttons/2.2.1/js/buttons.html5.min.js', array('jquery'), FIREBASE_WP_VERSION, true);

    wp_enqueue_script('firebase-admin', FIREBASE_WP__PLUGIN_URL . 'js/firebase-admin.js', array('jquery'), FIREBASE_WP_VERSION, true);

    wp_localize_script(
      'firebase-admin',
      'firebaseOptions',
      array(
        'apiKey' => isset(self::$options['api_key']) ? self::$options['api_key'] : '',
        'authDomain' => isset(self::$options['auth_domain']) ? self::$options['auth_domain'] : '',
        'databaseURL' => isset(self::$options['database_url']) ? self::$options['database_url'] : '',
        'storageBucket' => isset(self::$options['storage_bucket']) ? self::$options['storage_bucket'] : '',
        'appId' => isset(self::$options['app_id']) ? self::$options['app_id'] : '',
        'measurementId' => isset(self::$options['measurement_id']) ? self::$options['measurement_id'] : '',
        'messagingSenderId' => isset(self::$options['messaging_sender_id']) ? self::$options['messaging_sender_id'] : '',
        'projectId' => isset(self::$options['project_id']) ? self::$options['project_id'] : '',
      )
    );

    $public_translations = require_once FIREBASE_WP__PLUGIN_DIR . 'i18n/public_translations.php';
    wp_localize_script('firebase-admin', 'firebaseTranslations', $public_translations);

    // the dashboad api token is for admin only
    if (current_user_can('administrator')) {
      wp_localize_script(
        'firebase-admin',
        'firebaseSettings',
        array(
          'baseDomain' => isset(self::$options_settings['base_domain']) ? self::$options_settings['base_domain'] : null,
          'dashboardApiToken' => isset(self::$options_settings['dashboard_api_token']) ? self::$options_settings['dashboard_api_token'] : null,
          'frontendApiToken' => isset(self::$options_settings['frontend_api_token']) ? self::$options_settings['frontend_api_token'] : null,
          'IFPROVersion' => FIREBASE_WP_VERSION,
        )
      );
    } else {
      wp_localize_script(
        'firebase-admin',
        'firebaseSettings',
        array(
          'baseDomain' => isset(self::$options_settings['base_domain']) ? self::$options_settings['base_domain'] : null,
          'frontendApiToken' => isset(self::$options_settings['frontend_api_token']) ? self::$options_settings['frontend_api_token'] : null,
        )
      );
    }
  }

  public static function register_settings() {
    // General
    register_setting(
      "firebase_option_group",
      "firebase_credentials",
      array("Firebase_Admin", "sanitize")
    );

    add_settings_section(
      'general_section_id', // ID
      __('Enter your firebase credentials below:', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'print_section_info'), // Callback
      'credentials' // Page
    );

    add_settings_field(
      'api_key', // ID
      __('API Key', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'api_key_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    add_settings_field(
      'auth_domain', // ID
      __('Auth Domain', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'auth_domain_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    add_settings_field(
      'database_url', // ID
      __('Database URL', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'database_url_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    add_settings_field(
      'project_id', // ID
      __('Project Id', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'project_id_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    add_settings_field(
      'storage_bucket', // ID
      __('Storage Bucket', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'storage_bucket_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    add_settings_field(
      'app_id', // ID
      __('App Id', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'app_id_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    add_settings_field(
      'measurement_id', // ID
      __('Measurement Id', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'measurement_id_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    add_settings_field(
      'messaging_sender_id', // ID
      __('Messaging Sender Id', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'messaging_sender_id_callback'), // Callback
      'credentials', // Page
      'general_section_id' // Section
    );

    // Optimization
    add_settings_section(
      'if_optimize_section_id', // ID
      __('Optimization:', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'print_optimize_section_info'), // Callback
      'credentials' // Page
    );

    add_settings_field(
      'firebase_services', // ID
      __('Firebase Services', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'firebase_services_callback'), // Callback
      'credentials', // Page
      'if_optimize_section_id', // Section
      array(
        'name' => 'firebase_services',
        'options' => array(
          'realtime' => 'Realtime',
          'firestore' => 'Firestore',
          'storage' => 'Storage',
          'analytics' => 'Analytics',
          'messaging' => 'Messaging',
          'functions' => 'Functions',
        ),
      )
    );

    // Database

    // Auth
    register_setting(
      "firebase_auth_group",
      "firebase_auth",
      array("Firebase_Admin", "sanitize")
    );

    add_settings_section(
      'firebase_auth_section_id', // ID
      __('Login Page Configuration:', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'print_auth_login_page_section_info'), // Callback
      'auth' // Page,
    );

    add_settings_field(
      'login_with_firebase', // ID
      __('Allow Login to WP Dashboard', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'login_with_firebase_callback'), // Callback
      'auth', // Page
      'firebase_auth_section_id' // Section
    );

    add_settings_field(
      'login_url', // ID
      __('Login Url', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'login_url_callback'), // Callback
      'auth', // Page
      'firebase_auth_section_id' // Section
    );

    add_settings_section(
      'auth_section_id', // ID
      __('FirebaseUI Web Configuration:', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'print_auth_firebase_section_info'), // Callback
      'auth' // Page
    );

    add_settings_field(
      'sign_in_options', // ID
      __('Sign In Options', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'sign_in_options_callback'), // Callback
      'auth', // Page
      'auth_section_id', // Section
      array(
        'name' => 'sign_in_options',
        'options' => array(
          'google' => 'Google',
          'facebook' => 'Facebook',
          'twitter' => 'Twitter',
          'github' => 'Github',
          'apple' => 'Apple',
          'microsoft' => 'Microsoft',
          'phone' => 'Phone',
          'email' => 'Email',
        ),
      )
    );

    add_settings_field(
      'signin_with_email_link', // ID
      __('Sign In via Email Link', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'signin_with_email_link_callback'), // Callback
      'auth', // Page
      'auth_section_id' // Section
    );

    add_settings_field(
      'google_client_id', // ID
      __('Google Client ID (One-tap Sign-up)', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'google_client_id_callback'), // Callback
      'auth', // Page
      'auth_section_id' // Section
    );

    add_settings_field(
      'sign_in_success_url', // ID
      __('Sign In Success Url', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'sign_in_success_url_callback'), // Callback
      'auth', // Page
      'auth_section_id' // Section
    );

    add_settings_field(
      'tos_url', // ID
      __('Terms of Service Url', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'tos_url_callback'), // Callback
      'auth', // Page
      'auth_section_id' // Section
    );

    add_settings_field(
      'privacy_policy_url', // ID
      __('Privacy Policy Url', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'privacy_policy_url_callback'), // Callback
      'auth', // Page
      'auth_section_id' // Section
    );

    // WordPress
    register_setting(
      "firebase_wordpress_group",
      "firebase_wordpress",
      array("Firebase_Admin", "sanitize")
    );

    add_settings_section(
      'wordpress_section_id', // ID
      __('Sync WordPress to Firebase', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'print_wordpress_section_info'), // Callback
      'wordpress' // Page
    );

    add_settings_field(
      'wp_sync_database_type', // ID
      __('Database Type', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'wp_sync_database_type_callback'), // Callback
      'wordpress', // Page
      'wordpress_section_id' // Section
    );

    add_settings_field(
      'wp_sync_post_types', // ID
      __('Sync Post Types', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'wp_sync_post_types_callback'), // Callback
      'wordpress', // Page
      'wordpress_section_id', // Section
      array(
        'name' => 'wp_sync_post_types',
        'options' => array(
          'post' => 'Post',
          'page' => 'Page',
          'category' => 'Category',
        ),
      )
    );

    add_settings_field(
      'wp_sync_custom_post_types', // ID
      __('Custom Post Types', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'wp_sync_custom_post_types_callback'), // Callback
      'wordpress', // Page
      'wordpress_section_id' // Section
    );

    add_settings_field(
      'wp_sync_users', // ID
      __('Sync Users To', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'wp_sync_users_callback'), // Callback
      'wordpress', // Page
      'wordpress_section_id' // Section
    );

    // Settings
    register_setting(
      "firebase_settings_group",
      "firebase_settings",
      array("Firebase_Admin", "sanitize")
    );

    add_settings_section(
      'plugin_settings_section_id', // ID
      __('Plugin Configuration', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'print_plugin_settings_section_info'), // Callback
      'settings' // Page
    );

    add_settings_field(
      'product_key', // ID
      __('Product Key', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'product_key_callback'), // Callback
      'settings', // Page
      'plugin_settings_section_id' // Section
    );

    add_settings_section(
      'cloud_functions_settings_section_id', // ID
      __('Cloud Functions Configuration', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'print_cloud_functions_settings_section_info'), // Callback
      'settings' // Page
    );

    add_settings_field(
      'base_domain', // ID
      __('Cloud Functions URL', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'base_domain_callback'), // Callback
      'settings', // Page
      'cloud_functions_settings_section_id' // Section
    );

    add_settings_field(
      'dashboard_api_token', // ID
      __('Dashboard API Secret Token', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'dashboard_api_token_callback'), // Callback
      'settings', // Page
      'cloud_functions_settings_section_id' // Section
    );

    add_settings_field(
      'frontend_api_token', // ID
      __('Frontend API Secret Token', 'integrate-firebase-PRO'), // Title
      array("Firebase_Admin", 'frontend_api_token_callback'), // Callback
      'settings', // Page
      'cloud_functions_settings_section_id' // Section
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public static function sanitize($input) {
    $new_input = array();

    // General
    if (isset($input['api_key'])) {
      $new_input['api_key'] = sanitize_text_field($input['api_key']);
    }

    if (isset($input['auth_domain'])) {
      $new_input['auth_domain'] = sanitize_text_field($input['auth_domain']);
    }

    if (isset($input['database_url'])) {
      $new_input['database_url'] = sanitize_text_field($input['database_url']);
    }

    if (isset($input['storage_bucket'])) {
      $new_input['storage_bucket'] = sanitize_text_field($input['storage_bucket']);
    }

    if (isset($input['app_id'])) {
      $new_input['app_id'] = sanitize_text_field($input['app_id']);
    }

    if (isset($input['measurement_id'])) {
      $new_input['measurement_id'] = sanitize_text_field($input['measurement_id']);
    }

    if (isset($input['messaging_sender_id'])) {
      $new_input['messaging_sender_id'] = sanitize_text_field($input['messaging_sender_id']);
    }

    if (isset($input['project_id'])) {
      $new_input['project_id'] = sanitize_text_field($input['project_id']);
    }

    if (isset($input['firebase_services'])) {
      // sanitize input array
      $new_input['firebase_services'] = array();
      if (is_array($input['firebase_services'])) {
        foreach ($input['firebase_services'] as $item) {
          $new_input['firebase_services'][] = sanitize_text_field($item);
        }
      }
    }

    // Database

    // Auth

    if (isset($input['login_with_firebase'])) {
      $new_input['login_with_firebase'] = sanitize_text_field($input['login_with_firebase']);
    }

    if (isset($input['login_url'])) {
      $new_input['login_url'] = sanitize_text_field($input['login_url']);
    }

    if (isset($input['sign_in_options'])) {
      // sanitize input array
      $new_input['sign_in_options'] = array();
      if (is_array($input['sign_in_options'])) {
        foreach ($input['sign_in_options'] as $item) {
          $new_input['sign_in_options'][] = sanitize_text_field($item);
        }
      }
    }

    if (isset($input['signin_with_email_link'])) {
      $new_input['signin_with_email_link'] = sanitize_text_field($input['signin_with_email_link']);
    }

    if (isset($input['google_client_id'])) {
      $new_input['google_client_id'] = sanitize_text_field($input['google_client_id']);
    }

    if (isset($input['sign_in_success_url'])) {
      $new_input['sign_in_success_url'] = sanitize_text_field($input['sign_in_success_url']);
    }

    if (isset($input['tos_url'])) {
      $new_input['tos_url'] = sanitize_text_field($input['tos_url']);
    }

    if (isset($input['privacy_policy_url'])) {
      $new_input['privacy_policy_url'] = sanitize_text_field($input['privacy_policy_url']);
    }

    // WordPress
    if (isset($input['wp_sync_post_types'])) {
      // sanitize input array
      $new_input['wp_sync_post_types'] = array();
      if (is_array($input['wp_sync_post_types'])) {
        foreach ($input['wp_sync_post_types'] as $item) {
          $new_input['wp_sync_post_types'][] = sanitize_text_field($item);
        }
      }
    }

    if (isset($input['wp_sync_custom_post_types'])) {
      $new_input['wp_sync_custom_post_types'] = sanitize_text_field($input['wp_sync_custom_post_types']);
    }

    if (isset($input['wp_sync_users'])) {
      $new_input['wp_sync_users'] = sanitize_text_field($input['wp_sync_users']);
    }

    if (isset($input['wp_sync_database_type'])) {
      $new_input['wp_sync_database_type'] = sanitize_text_field($input['wp_sync_database_type']);
    }

    // Settings
    if (isset($input['product_key'])) {
      $new_input['product_key'] = sanitize_text_field($input['product_key']);
    }

    if (isset($input['base_domain'])) {
      $new_input['base_domain'] = sanitize_text_field($input['base_domain']);
    }

    if (isset($input['dashboard_api_token'])) {
      $new_input['dashboard_api_token'] = sanitize_text_field($input['dashboard_api_token']);
    }

    if (isset($input['frontend_api_token'])) {
      $new_input['frontend_api_token'] = sanitize_text_field($input['frontend_api_token']);
    }

    return $new_input;
  }

  /**
   * General Tab
   */
  public static function print_section_info() {
    print __("
        <p>Firebase info can be found in Project <strong>Setting > SERVICE ACCOUNTS</strong> in <a href='https://console.firebase.google.com' target='_blank'>Firebase Console</a></p>
        <p>You don't have to enter <em>storage bucket, app id, measurement id, and messaging sender id</em> if you don't to use storage, messages and analytics.</p>
        ", 'integrate-firebase-PRO');
  }

  public static function print_optimize_section_info() {
    print __("Please choose the services that you will integrate. This will help to improve the speed of your website.", 'integrate-firebase-PRO');
  }

  // Get the settings option array and print one of its values
  public static function api_key_callback() {
    self::print_form("api_key");
  }

  public static function auth_domain_callback() {
    self::print_form("auth_domain");
  }

  public static function database_url_callback() {
    self::print_form("database_url");
  }

  public static function storage_bucket_callback() {
    self::print_form("storage_bucket");
  }

  public static function app_id_callback() {
    self::print_form("app_id");
  }

  public static function measurement_id_callback() {
    self::print_form("measurement_id");
  }

  public static function messaging_sender_id_callback() {
    self::print_form("messaging_sender_id");
  }

  public static function project_id_callback() {
    self::print_form("project_id");
  }

  public static function print_form($form_id) {
    printf(
      "<input type='text' id='$form_id' name='firebase_credentials[$form_id]' value='%s'  style='width: %u%%;'/>",
      isset(self::$options[$form_id]) ? esc_attr(self::$options[$form_id]) : '',
      100
    );
  }

  public static function firebase_services_callback($args, $firebase_services = 'firebase_services') {
    foreach ($args['options'] as $value => $label) {
      $checked = null;
      if (isset(self::$options[$firebase_services]) && in_array($value, self::$options[$firebase_services])) {
        $checked = 'checked="checked"';
      }
      printf(
        "<label>$label <input type='checkbox' name='firebase_credentials[$firebase_services][]' value='%s' $checked/></label> &nbsp;",
        $value
      );
    }
  }

  /**
   * Database Tab
   */
  public static function print_database_section_info() {
    print "<i>*" . __('This plugin supports both Real Time Database and Firestore', 'integrate-firebase-PRO') . "</i>";
  }

  public static function database_type_callback($args, $database_type = 'database_type') {
    printf(
      '<select name="%1$s[%2$s]" id="%3$s">',
      $args['option_name'],
      $args['name'],
      $args['name']
    );

    foreach ($args['options'] as $val => $title) {
      printf(
        '<option value="%1$s" %2$s>%3$s</option>',
        $val,
        selected($val, $args['value'], false),
        $title
      );
    }

    print '</select>';
  }

  public static function print_form_database($form_id) {
    printf(
      "<input type='text' id='$form_id' name='firebase_database[$form_id]' value='%s'  style='width: %u%%;'/>",
      isset(self::$options_database[$form_id]) ? esc_attr(self::$options_database[$form_id]) : '',
      100
    );
  }

  /**
   * Auth Tab
   */

  public static function print_auth_login_page_section_info() {
    print "<i>*" . __('Enter these fields if you want to login through Firebase Web UI.', 'integrate-firebase-PRO') . "</i>";
    print "<p><strong class='warning'>" . __('* Please read the <a href="https://firebase-wordpress-docs.readthedocs.io/en/latest/auth/wordpress-user-integration.html" target="_blank">User Guide</a> before checking Allow Login to WP Dashboard', 'integrate-firebase-PRO') . "</strong></p>";
  }

  public static function login_with_firebase_callback() {
    echo "<input type='checkbox' id='login_with_firebase' name='firebase_auth[login_with_firebase]' value='1'";
    if (isset(self::$options_auth['login_with_firebase']) && self::$options_auth['login_with_firebase'] == '1') {
      echo ' checked';
    }
    echo '/>';
  }

  public static function login_url_callback() {
    self::print_form_auth("login_url");
  }

  public static function print_auth_firebase_section_info() {
    print "<i>*" . __('Configuration for FirebaseUI Web.', 'integrate-firebase-PRO') . "</i>";
  }

  public static function sign_in_options_callback($args, $sign_in_options = 'sign_in_options') {
    foreach ($args['options'] as $option) {
      $checked = null;
      if (isset(self::$options_auth[$sign_in_options]) && in_array($option, self::$options_auth[$sign_in_options])) {
        $checked = 'checked="checked"';
      }
      printf(
        "<label>$option <input type='checkbox' name='firebase_auth[$sign_in_options][]' value='%s' $checked/></label> &nbsp;",
        $option
      );
    }
  }

  public static function signin_with_email_link_callback() {
    echo "<input type='checkbox' id='signin_with_email_link' name='firebase_auth[signin_with_email_link]' value='1'";
    if (isset(self::$options_auth['signin_with_email_link']) && self::$options_auth['signin_with_email_link'] == '1') {
      echo ' checked';
    }
    echo '/>';
  }

  public static function google_client_id_callback() {
    self::print_form_auth("google_client_id");
  }

  public static function sign_in_success_url_callback() {
    self::print_form_auth("sign_in_success_url");
  }

  public static function tos_url_callback() {
    self::print_form_auth("tos_url");
  }

  public static function privacy_policy_url_callback() {
    self::print_form_auth("privacy_policy_url");
  }

  public static function print_form_auth($form_id) {
    // firebase_auth[$form_id] is manadatory for saving inputs
    printf(
      "<input type='text' id='$form_id' name='firebase_auth[$form_id]' value='%s'  style='width: %u%%;'/>",
      isset(self::$options_auth[$form_id]) ? esc_attr(self::$options_auth[$form_id]) : '',
      100
    );
  }

  /**
   * WordPress Tab
   */
  public static function print_wordpress_section_info() {
    print "
            <i>*" . __('Choose the suitable options for synchronization.', 'integrate-firebase-PRO') . "</i>
        ";
  }

  public static function wp_sync_database_type_callback() {
    $selected = isset(self::$options_wordpress['wp_sync_database_type']) ? self::$options_wordpress['wp_sync_database_type'] : 'firestore';
?>
    <select name='firebase_wordpress[wp_sync_database_type]'>
      <option value='firestore' <?php selected($selected, 'firestore'); ?>>Firestore</option>
      <option value='realtime' <?php selected($selected, 'realtime'); ?>>Realtime</option>
    </select>
<?php
  }

  public static function wp_sync_post_types_callback($args, $wp_sync_post_types = 'wp_sync_post_types') {
    foreach ($args['options'] as $value => $label) {
      $checked = null;
      if (isset(self::$options_wordpress[$wp_sync_post_types]) && in_array($value, self::$options_wordpress[$wp_sync_post_types])) {
        $checked = 'checked="checked"';
      }
      printf(
        "<label>$label <input type='checkbox' name='firebase_wordpress[$wp_sync_post_types][]' value='%s' $checked/></label> &nbsp;",
        $value
      );
    }
  }

  public static function wp_sync_custom_post_types_callback() {
    $form_id = "wp_sync_custom_post_types";
    printf(
      "<input type='text' placeholder='separated by comma' id='$form_id' name='firebase_wordpress[$form_id]' value='%s'  style='width: %u%%;'/>",
      isset(self::$options_wordpress[$form_id]) ? esc_attr(self::$options_wordpress[$form_id]) : '',
      100
    );
  }

  public static function wp_sync_users_callback() {
    $form_id = "wp_sync_users";
    printf(
      "<input type='text' placeholder='enter collection name. e.g users...' id='$form_id' name='firebase_wordpress[$form_id]' value='%s'  style='width: %u%%;'/>",
      isset(self::$options_wordpress[$form_id]) ? esc_attr(self::$options_wordpress[$form_id]) : '',
      100
    );
  }

  /**
   * Setting Tab
   */
  public static function print_plugin_settings_section_info() {
    print "
            <i>* " . __('Product key is mandatory for the plugin update.', 'integrate-firebase-PRO') . "</i>"
      . "<p>" . __("Please login to ")
      . "<a href='https://techcater.com/shop/my-account' target='_blank'>"
      . __("My Account") . "</a>" . __(" in order to create a product key.")
      . "</p>";
  }

  public static function product_key_callback() {
    self::print_form_settings("product_key");
  }

  public static function print_cloud_functions_settings_section_info() {
    print "
            <i>* " . __('API secret token is mandatory for securely managing Firebase.', 'integrate-firebase-PRO') . "</i>"
      . "<i>" . __('Never reveal your dashboard api token!', 'integrate-firebase-PRO') . "</i>"
      . "<p>" . __("Please follow the ")
      . "<a href='https://firebase-wordpress-docs.readthedocs.io/en/latest/intro/cloud-functions-deployment.html' target='_blank'>"
      . __("Integration Guide") . "</a>" . __(" to configure this section.")
      . "</p>";
  }

  public static function base_domain_callback() {
    self::print_form_settings("base_domain");
  }

  public static function dashboard_api_token_callback() {
    self::print_form_settings("dashboard_api_token");
  }

  public static function frontend_api_token_callback() {
    self::print_form_settings("frontend_api_token");
  }

  public static function print_form_settings($form_id) {
    switch ($form_id) {
      case 'product_key':
      case 'dashboard_api_token':
      case 'frontend_api_token':
        printf(
          "<input type='password' id='$form_id' name='firebase_settings[$form_id]' value='%s'  style='width: %u%%;'/>",
          isset(self::$options_settings[$form_id]) ? esc_attr(self::$options_settings[$form_id]) : '',
          100
        );
        break;

      case 'base_domain':
        printf(
          "<input type='text' id='$form_id' name='firebase_settings[$form_id]' value='%s'  style='width: %u%%;'/>",
          isset(self::$options_settings[$form_id]) ? esc_attr(self::$options_settings[$form_id]) : '',
          100
        );
        break;
    }
  }

  /**
   * Show Warning message
   *
   * @param [type] $message
   * @return void
   */
  public static function show_warning_message($message) {
    echo "<div>";
    echo "<p class='notice notice-warning'>" . $message . "</p>";
    echo "</div>";
  }

  /**
   * Display firebase content on Setting page
   * @return [type] [description]
   */
  public static function display_page() {
    echo "<div class='wrap'>";
    // Errors & Messages
    echo "<div id='firebase-error' class='error notice notice-error is-dismissible'></div>";
    echo "<div id='firebase-message' class='message notice notice-success is-dismissible'></div>";
    echo "<div id='firebase-warning' class='message notice notice-warning is-dismissible'></div>";
    settings_errors();

    echo "<h1>" . __('Firebase Settings', 'integrate-firebase-PRO') . "</h1>";
    echo "<h3>Integrate Firebase PRO (v" . FIREBASE_WP_VERSION . ")</h3>";
    echo "<p class='error'>" . __('If you have any extensions, please also update them to latest version!', 'integrate-firebase-PRO') . "</p>";

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
    $general_class = $active_tab === 'general' ? 'nav-tab-active' : '';
    $database_class = $active_tab === 'database' ? 'nav-tab-active' : '';
    $users_class = $active_tab === 'users' ? 'nav-tab-active' : '';
    $auth_class = $active_tab === 'auth' ? 'nav-tab-active' : '';
    $message_class = $active_tab === 'message' ? 'nav-tab-active' : '';
    $wordpress_class = $active_tab === 'wordpress' ? 'nav-tab-active' : '';
    $settings_class = $active_tab === 'settings' ? 'nav-tab-active' : '';
    $about_class = $active_tab === 'about' ? 'nav-tab-active' : '';

    echo "<h2 class='nav-tab-wrapper'>";
    echo "<a href='?page=firebase-setting&tab=general' class='nav-tab $general_class'>" . __('General', 'integrate-firebase-PRO') . "</a>";
    echo "<a href='?page=firebase-setting&tab=database' class='nav-tab $database_class'>" . __('Database', 'integrate-firebase-PRO') . "</a>";
    echo "<a href='?page=firebase-setting&tab=users' class='nav-tab $users_class' id='if-users-tab'>" . __('Users', 'integrate-firebase-PRO') . "</a>";
    echo "<a href='?page=firebase-setting&tab=auth' class='nav-tab $auth_class' id='if-auth-tab'>" . __('Auth', 'integrate-firebase-PRO') . "</a>";
    echo "<a href='?page=firebase-setting&tab=message' class='nav-tab $message_class' id='if-message-tab'>" . __('Message', 'integrate-firebase-PRO') . "</a>";
    echo "<a href='?page=firebase-setting&tab=wordpress' class='nav-tab $wordpress_class' id='if-wordpress-tab'>" . __('WordPress', 'integrate-firebase-PRO') . "</a>";
    echo "<a href='?page=firebase-setting&tab=settings' class='nav-tab $settings_class'>" . __('Settings', 'integrate-firebase-PRO') . "</a>";
    echo "<a href='?page=firebase-setting&tab=about' class='nav-tab $about_class'>" . __('About', 'integrate-firebase-PRO') . "</a>";
    echo "</h2>";

    echo "<form method='post' action='options.php'>";
    // This prints out all hidden setting fields
    if ($active_tab === 'general') {
      if (empty(self::$options_settings['product_key'])) {
        self::show_warning_message(__('Please enter your Product Key in Firebase > Settings!', 'integrate-firebase-PRO'));
      } else {
        settings_fields('firebase_option_group');
        do_settings_sections('credentials');
        submit_button();
      }
    } else if ($active_tab === 'database') {
      if (!empty(self::$options_settings['base_domain']) && !empty(self::$options_settings['dashboard_api_token'])) {
        echo "<div id='if-database-admin'></div>";
        echo "<div id='if-database-holder'></div>";
      } else {
        self::show_warning_message(__('Please enter your cloud functions URL and secret tokens in Firebase > Settings!', 'integrate-firebase-PRO'));
      }
    } else if ($active_tab === 'users') {
      if (!empty(self::$options_settings['base_domain']) && !empty(self::$options_settings['dashboard_api_token'])) {
        echo "<div id='if-users-content'>";
        echo "<br>";
        // Add users
        echo "<div id='if-add-new-user'></div>";
        echo "<hr><br>";
        // Load users
        echo "<a href='#' id='if-users-get-users' class='button button-primary'>" . __('Click to load users', 'integrate-firebase-PRO') . "</a>";
        echo "<p class='if-users-loading'>" . __('User data is loading...', 'integrate-firebase-PRO') . "</p>";
        echo "<div id='if-users-table-wrapper'></id>";
        echo "</div>";
      } else {
        self::show_warning_message(__('Please enter your cloud functions URL and secret tokens in Firebase > Settings!', 'integrate-firebase-PRO'));
      }
    } else if ($active_tab === 'auth') {
      settings_fields('firebase_auth_group');
      do_settings_sections('auth');
      submit_button();
    } else if ($active_tab === 'message') {
      echo "<p>" . __("Message only support send to topic or condition at the moment. If you want to improve this feature please take the <a href='https://forms.gle/LwaMqQfxeJjy5iBj7' target='_blank'>cloud message feature survey", 'integrate-firebase-PRO') . "</a>.</p>";
      if (!empty(self::$options_settings['base_domain']) && !empty(self::$options_settings['dashboard_api_token'])) {
        echo "<div id='if-send-message-wrapper'></div>";
      } else {
        self::show_warning_message(__('Please enter your cloud functions URL and secret tokens in Firebase > Settings!', 'integrate-firebase-PRO'));
      }
    } else if ($active_tab === 'wordpress') {
      if (!empty(self::$options_settings['base_domain']) && !empty(self::$options_settings['dashboard_api_token'])) {
        settings_fields('firebase_wordpress_group');
        do_settings_sections('wordpress');
        submit_button();
      } else {
        self::show_warning_message(__('Please enter your cloud functions URL and secret tokens in Firebase > Settings!', 'integrate-firebase-PRO'));
      }
    } else if ($active_tab === 'settings') {
      settings_fields('firebase_settings_group');
      do_settings_sections('settings');
      submit_button();
    } else if ($active_tab === 'about') {
      echo "<h3>" . __('Integrate Firebase PRO plugin will help to bring Firebase features to WordPress site.', 'integrate-firebase-PRO') . "</h3>";
      echo "<p>" . __("If you have any issues or feature requests, please create <a href='https://github.com/dalenguyen/firebase-wordpress-plugin/issues' target='_blank'>a ticket on Github</a>. Remember to sensor any sensitive information before creating a ticket.", 'integrate-firebase-PRO') . "</p>";
      echo "<p>" . __("Please visit the <a href='https://firebase-wordpress-docs.readthedocs.io' target='_blank'>Official Documentation</a> for the latest tutorials and updates.", 'integrate-firebase-PRO') . "</p>";
    }

    echo "</form>";
    echo "</div>";
  }
}
