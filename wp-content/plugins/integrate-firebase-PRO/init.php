<?php

/**
 * The initation loader for Firebase, and the main plugin file.
 *
 * @category     WordPress_Plugin
 * @package      integrate-firebase-PRO
 * @author       dalenguyen
 * @link         https://techcater.com
 *
 * Plugin Name:  Integrate Firebase PRO
 * Plugin URI:   https://techcater.com
 * Description:  Integrate Firebase PRO is a plugin that helps to Integrate Firebase features to WordPress
 * Author:       dalenguyen
 * Author URI:   http://dalenguyen.me
 * Contributors: Dale Nguyen (@dalenguyen)
 *
 * Version:      3.23.1
 *
 * Text Domain:  integrate-firebase-PRO
 * Domain Path: /languages/
 *
 *
 *
 * This is an add-on for WordPress
 * https://wordpress.org/
 *
 * **********************************************************************
 * This program is paid software; you cannot redistribute it.
 * **********************************************************************
 */

/**
 * *********************************************************************
 *               You should not edit the code below
 *               (or any code in the included files)
 *               or things might explode!
 * ***********************************************************************
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

define('FIREBASE_WP_VERSION', '3.23.1');
define('FIREBASE_WP__MINIMUM_WP_VERSION', '4.0.0');
define('FIREBASE_WP__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FIREBASE_WP__PLUGIN_URL', plugin_dir_url(__FILE__));
define('FIREBASE_WP__PLUGIN_FILE', __FILE__);

add_action('plugins_loaded', 'init_firebase_pro_plugin');

function init_firebase_pro_plugin() {
  $plugin_rel_path = basename(dirname(__FILE__)) . '/languages';
  load_plugin_textdomain('integrate-firebase-PRO', false, $plugin_rel_path);

  // WordPress Hooks: Utils
  require_once FIREBASE_WP__PLUGIN_DIR . 'includes/hooks/class.firebase-utils.php';
  if (class_exists('FirebaseUtils')) {
    FirebaseUtils::init();
  }

  // WordPress Hooks: Filters
  require_once FIREBASE_WP__PLUGIN_DIR . 'includes/hooks/class.firebase-filters.php';
  if (class_exists('FirebaseWordPressFilters')) {
    FirebaseWordPressFilters::init();
  }

  // Rest API User
  require_once FIREBASE_WP__PLUGIN_DIR . 'includes/public/class.api-user.php';
  require_once FIREBASE_WP__PLUGIN_DIR . 'includes/public/class.firebase.php';
  if (class_exists('Firebase')) {
    Firebase::init();
  }

  // WordPress Custom Features
  require_once FIREBASE_WP__PLUGIN_DIR . 'includes/admin/class.wordpress.php';
  if (class_exists('FirebaseCustomWordPress')) {
    FirebaseCustomWordPress::init();
  }

  // WordPress Users Actions
  require_once FIREBASE_WP__PLUGIN_DIR . 'includes/admin/class.users.php';
  if (class_exists('FirebaseUsersActions')) {
    FirebaseUsersActions::init();
  }

  require_once FIREBASE_WP__PLUGIN_DIR . 'includes/public/class.shortcodes.php';
  if (class_exists('Firebase_Shortcode')) {
    Firebase_Shortcode::init();
  }

  // Admin configuration
  if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    require_once FIREBASE_WP__PLUGIN_DIR . 'includes/service/class.message-service.php';
    require_once FIREBASE_WP__PLUGIN_DIR . 'includes/admin/class.firebase-admin.php';
    require_once FIREBASE_WP__PLUGIN_DIR . 'includes/admin/class.experiments.php';
    if (class_exists('Firebase_Admin')) {
      Firebase_Admin::init();
      FirebaseExperimentsAdmin::init();
    }

    require_once FIREBASE_WP__PLUGIN_DIR . 'includes/admin/class.firebase-updater.php';
    if (class_exists('Firebase_Admin_Updater')) {
      Firebase_Admin_Updater::init();
    }
  }

  // Initialize other extensions
  do_action('firebase_pro_init');
}
