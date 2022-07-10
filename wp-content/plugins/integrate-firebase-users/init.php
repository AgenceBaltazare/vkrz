<?php

/**
 * The initiation loader for Firebase, and the main plugin file.
 *
 * @category     WordPress_Plugin
 * @package      ifp-users
 * @author       dalenguyen
 * @link         https://techcater.com
 *
 * Plugin Name:  Integrate Firebase - Users
 * Plugin URI:   https://techcater.com
 * Description:  Integrate Firebase Users is an addon for Integrate Firebase PRO plugin
 * Author:       dalenguyen
 * Author URI:   http://dalenguyen.me
 * Contributors: Dale Nguyen (@dalenguyen)
 *
 * Version:      1.3.1
 *
 * Text Domain:  ifp-users
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

define('FIREBASE_USERS_VERSION', '1.3.1');
define('FIREBASE_USERS__MINIMUM_WP_VERSION', '4.0.0');
define('FIREBASE_USERS__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FIREBASE_USERS__PLUGIN_URL', plugin_dir_url(__FILE__));

add_action('firebase_pro_init', 'init_firebase_users');

function init_firebase_users() {
  // Users
  require_once FIREBASE_USERS__PLUGIN_DIR . 'includes/dashboard/class.ifp-users.php';

  if (class_exists('Firebase')) {
    Firebase_Users_Admin::init();
  }
}
