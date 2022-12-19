<?php

class Firebase {
  private static $initiated = false;
  private static $options;
  private static $options_auth;
  private static $options_settings;
  private static $options_wordpress;
  private static $firebase_experiments;

  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {

    // Fixed is_plugin_active() not found bug
    if (!function_exists('is_plugin_active')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    self::$initiated = true;
    self::$options = get_option("firebase_credentials");
    self::$options_auth = get_option("firebase_auth");
    self::$options_settings = get_option("firebase_settings");
    self::$options_wordpress = get_option("firebase_wordpress");
    self::$firebase_experiments = get_option('firebase_experiments');

    // Redirect Login Page when Login With Firebase is checked
    // TODO: validate product key
    if (self::$options_auth && isset(self::$options_auth['login_with_firebase']) && isset(self::$options_settings['product_key']) && strlen(self::$options_settings['product_key']) > 0) {
      add_action('init', array('Firebase', 'prevent_wp_login'));
    }
    add_action('wp_enqueue_scripts', array('Firebase', 'load_firebase_js'));

    // WP API
    $rest_api_users = new Firebase_Rest_Api_User();
    $rest_api_users->init();

    // Add-on initialization
    if (class_exists('Firebase_Maps')) {
      Firebase_Maps::init();
    }
  }

  public static function prevent_wp_login() {
    global $pagenow;

    // Ignore SSO query (Discourse...) & debug mode
    if (!empty($_GET['sso']) || !empty($_GET['SSO']) || !empty($_GET['debug'])) {
      wp_enqueue_script('firebase-wp-login', FIREBASE_WP__PLUGIN_URL . 'js/wp-login.js');
      return;
    }

    if ('wp-login.php' == $pagenow && !is_user_logged_in()) {
      // Redirect to default login page or to dedicated page for login
      if (self::$options_auth['login_url']) {
        $redirect_url = self::$options_auth['login_url'];
        wp_redirect($redirect_url);
        exit();
      }
    }
  }

  public static function load_firebase_js() {

    // @TODO will be imported from Webpack
    // wp_enqueue_style( 'firebase', plugin_dir_url( dirname(__FILE__) ) . 'css/firebase.css' );

    $FIREBASE_SERVICES = isset(self::$options['firebase_services']) ? self::$options['firebase_services'] : array();
    // Set language for FirebaseUI Web
    $FIREBASE_LANGUAGE_LIST = require_once FIREBASE_WP__PLUGIN_DIR . 'i18n/firebaseui_web.php';

    $current_wp_langague = "en";
    if (isset($FIREBASE_LANGUAGE_LIST[get_locale()])) {
      $current_wp_langague = $FIREBASE_LANGUAGE_LIST[get_locale()];
    }

    wp_enqueue_script('firebase', FIREBASE_WP__PLUGIN_URL . 'js/firebase.js', array('jquery'), FIREBASE_WP_VERSION, true);
    // uncomment for development
    // wp_enqueue_script('firebase-pro', FIREBASE_WP__PLUGIN_URL . 'js/firebase-pro.js', array('firebase'), FIREBASE_WP_VERSION, true);

    $site_url = get_site_url();
    $license = self::$options_settings['product_key'];
    $secret = base64_encode('{"productKey":"' . $license . '", "origin": "' . $site_url . '", "pluginId": "IFP_YEARLY"}');

    $firebase_pro_script = "//wp.techcater.com/js/firebase-pro.js?secret=$secret";

    if (strpos(get_site_url(), 'techcater-plugins.local') !== false) {
      $firebase_pro_script = "//wp-dev.techcater.com/js/firebase-pro.js?secret=$secret";
      // $firebase_pro_script = "http://localhost:5000/js/firebase-pro.js?secret=$secret";
    }

    wp_localize_script(
      'firebase',
      'firebaseOptions',
      array(
        'apiKey' => isset(self::$options['api_key']) ? self::$options['api_key'] : '',
        'authDomain' => isset(self::$options['auth_domain']) ? self::$options['auth_domain'] : '',
        'databaseURL' => isset(self::$options['database_url']) ? self::$options['database_url'] : '',
        'storageBucket' => isset(self::$options['storage_bucket']) ? self::$options['storage_bucket'] : '',
        'appId' => isset(self::$options['app_id']) ? self::$options['app_id'] : '',
        'measurementId' => isset(self::$options['measurement_id']) ? self::$options['measurement_id'] : '',
        'messagingSenderId' => isset(self::$options['messaging_sender_id']) ? self::$options['messaging_sender_id'] : '',
        'reCaptchaSiteKey' => isset(self::$options['re_captcha_id']) ? self::$options['re_captcha_id'] : '',
        'projectId' => isset(self::$options['project_id']) ? self::$options['project_id'] : '',
        'services' => $FIREBASE_SERVICES,
        // comment for development
        'proScript' => $firebase_pro_script,
        'language' => $current_wp_langague
      )
    );

    wp_localize_script(
      'firebase',
      'authSettings',
      array(
        'loginWithFirebase' => isset(self::$options_auth['login_with_firebase']) ? self::$options_auth['login_with_firebase'] : null,
        'loginUrl' => isset(self::$options_auth['login_url']) ? self::$options_auth['login_url'] : null,
        'signinWithEmailLink' => isset(self::$options_auth['signin_with_email_link']) ? self::$options_auth['signin_with_email_link'] : null,
        'googleClientId' => isset(self::$options_auth['google_client_id']) ? self::$options_auth['google_client_id'] : null,

        'signInSuccessUrl' => isset(self::$options_auth['sign_in_success_url']) ? self::$options_auth['sign_in_success_url'] : null,
        'signInOptions' => isset(self::$options_auth['sign_in_options']) ? self::$options_auth['sign_in_options'] : null,
        'tosUrl' => isset(self::$options_auth['tos_url']) ? self::$options_auth['tos_url'] : null,
        'privacyPolicyUrl' => isset(self::$options_auth['privacy_policy_url']) ? self::$options_auth['privacy_policy_url'] : null,

        // WordFence
        'isWordfenceActive' => is_plugin_active('wordfence/wordfence.php')
      )
    );

    wp_localize_script(
      'firebase',
      'firebaseSettings',
      array(
        'baseDomain' => isset(self::$options_settings['base_domain']) ? self::$options_settings['base_domain'] : null,
        'frontendApiToken' => isset(self::$options_settings['frontend_api_token']) ? self::$options_settings['frontend_api_token'] : null,
        'proVersion' => FIREBASE_WP_VERSION
      )
    );

    wp_localize_script(
      'firebase',
      'firebaseWordpress',
      array(
        'siteUrl' => get_site_url(),
        'firebaseLoginKey' => wp_create_nonce('firebase_login_key'),
        'userCollectionName' => isset(self::$options_wordpress['wp_sync_users']) ? self::$options_wordpress['wp_sync_users'] : null,
        'firebaseDatabaseType' => isset(self::$options_wordpress['wp_sync_database_type']) ? self::$options_wordpress['wp_sync_database_type'] : null,
        'isUserLoggedIn' => is_user_logged_in(),
        // Hide logout link if login with firebase is disabled
        'wpLogoutLink' => isset(self::$options_auth['login_with_firebase']) ? wp_logout_url() : null,
      )
    );

    wp_localize_script(
      'firebase',
      'firebaseExperiments',
      array(
        'allowUpdatingEmail' => isset(self::$firebase_experiments['ifp_allow_updating_email']) ? self::$firebase_experiments['ifp_allow_updating_email'] : null,
      )
    );

    $public_translations = require_once FIREBASE_WP__PLUGIN_DIR . 'i18n/public_translations.php';
    $public_translations = apply_filters('firebase_edit_public_translation_texts', $public_translations);

    wp_localize_script('firebase', 'firebaseTranslations', $public_translations);
  }
}
