<?php

/**
 * Add Users to Firebase Menu
 */

defined('ABSPATH') || exit;

class Firebase_Users_Admin {
  private static $initiated = false;
  private static $firebase_settings;

  static $users = null;

  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    global $wpdb;

    self::$firebase_settings = get_option('firebase_settings');
    self::$initiated = true;

    self::$users = $wpdb->get_results("SELECT * from $wpdb->users WHERE NULLIF(user_email, '') IS NOT NULL");
    // self::$users = $wpdb->get_results("SELECT * from $wpdb->users");

    add_action('admin_menu', array('Firebase_Users_Admin', 'add_firebase_users_menu'));

    add_action('admin_enqueue_scripts', array('Firebase_Users_Admin', 'load_firebase_users_js'));

    add_action('admin_post_firebase_import_users', array('Firebase_Users_Admin', 'firebase_start_to_import_users'));
  }

  public static function load_firebase_users_js() {
    wp_enqueue_script('firebase-users', FIREBASE_USERS__PLUGIN_URL . 'js/firebase-users.js', array('jquery'), FIREBASE_USERS_VERSION, false);
  }

  public static function add_firebase_users_menu() {
    if ((is_plugin_active('integrate-firebase-PRO/init.php')) && class_exists('Firebase')) {
      add_submenu_page(
        'firebase-setting', // string $parent_slug
        'Firebase Users Integration', // string $page_title,
        'Import Users', // string $menu_title,
        'manage_options', // string $capability,
        'firebase-users', // string $menu_slug,
        array('Firebase_Users_Admin', 'add_firebase_users_menu_html') // callable $function = ''
      );
    }
  }

  public static function firebase_start_to_import_users() {
    // at the end redirect to target page
    $firebaseUserstNonce = $_POST['firebaseUserstNonce'];

    if (!wp_verify_nonce($firebaseUserstNonce, 'firebaseUsers')) {
      die(__('Firebase - Security check failed', 'ifp-users'));
    } else {
      echo 'Start importing...<br>';

      $user_chunks = array_chunk(self::$users, 1000);

      foreach ($user_chunks as $user_chunk) {
        error_log('-----');
        echo '<p> Importing ' . count($user_chunk) . ' users...</p>';
        $resObj = apply_filters('firebase_import_users_to_firebase', $user_chunk);

        if ($resObj->status) {
          echo $resObj->message;
        } else {
          echo 'Error: ';
          echo $resObj->message;
        }

        sleep(3);
      }
    }
  }

  /**
   * Show Warning message
   *
   * @param [type] $message
   * @return void
   */
  public static function show_warning_message($message) {
    echo '<div>';
    echo "<p class='notice notice-warning'>' . $message . '</p>";
    echo '</div>';
  }

  public static function add_firebase_users_menu_html() {

    // check user capabilities
    if (!current_user_can('manage_options')) {
      return;
    }

    echo "<div class='wrap'>";
    echo "<h1>Users Integration (v" . FIREBASE_USERS_VERSION . ")</h1>";
    // Errors & Messages
    echo "<div id='firebase-error' class='error notice notice-error is-dismissible'></div>";
    echo "<div id='firebase-message' class='message notice notice-success is-dismissible'></div>";
    echo "<div id='firebase-warning' class='message notice notice-warning is-dismissible'></div>";
    settings_errors();

    // Form
    echo "<form method='post' action='options.php'>";
    if (!empty(self::$firebase_settings['base_domain']) && !empty(self::$firebase_settings['dashboard_api_token'])) {
      echo "
              <h2>Start to import WordPress users to Firebase</h2>

              <p>This extension will help to import all WordPress users to Firebase.</p>
              <p>Make sure that you're running Integrate Firebase PRO with the latest version. Cloud functions are also required.</p>
              <p>Only users with <strong>emails</strong> are imported.</p>
            ";

      echo "<p>Number of WP Users: " . count(self::$users) . "</p>";

      wp_nonce_field('firebaseUsers', 'firebaseUserstNonce');

      echo "
              <button class='button button-primary' type='button' id='firebase-import-users' data-url=" . admin_url('admin-post.php') . ">
                Import WP Users to Firebase
              </button>
            ";
    } else {
      self::show_warning_message('Please enter your cloud functions URL and secret tokens in Firebase > Settings!');
    }
    echo '</form>';
    echo '</div>';
  }
}
