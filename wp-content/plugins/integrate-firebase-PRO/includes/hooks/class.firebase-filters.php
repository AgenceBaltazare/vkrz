<?php

/**
 * Firebase WordPress Filters Hooks
 */

class FirebaseWordPressFilters {
  private static $initiated = false;
  private static $firebase_service;
  private static $firebase_settings;

  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    self::$initiated = true;
    self::$firebase_settings = get_option('firebase_settings');

    if (
      self::$firebase_settings &&
      isset(self::$firebase_settings['base_domain']) &&
      isset(self::$firebase_settings['dashboard_api_token'])
    ) {
      self::$firebase_service = include FIREBASE_WP__PLUGIN_DIR . 'includes/service/class.firebase-service.php';

      // Custom filters
      add_filter('firebase_get_data_from_database', array('FirebaseWordPressFilters', 'get_data_from_database'), 10, 3);
      add_filter('firebase_save_data_to_database', array('FirebaseWordPressFilters', 'save_data_to_database'), 10, 4);
      add_filter('firebase_delete_data_from_database', array('FirebaseWordPressFilters', 'delete_data_from_database'), 10, 4);
      add_filter('firebase_import_users_to_firebase', array('FirebaseWordPressFilters', 'import_users_to_firebase'), 10, 4);
      add_filter('firebase_get_firebase_user', array('FirebaseWordPressFilters', 'get_firebase_user'), 10, 4);
      add_filter('firebase_verify_id_token', array('FirebaseWordPressFilters', 'verify_firebase_id_token'), 10, 4);
    }
  }

  public static function get_data_from_database($database_type, $collection_name, $doc_id) {
    return self::$firebase_service->get_data_from_firebase($database_type, $collection_name, $doc_id);
  }

  public static function save_data_to_database($database_type, $collection_name, $doc_id, $data) {
    return self::$firebase_service->send_data_to_firebase($database_type, $collection_name, $doc_id, $data);
  }

  public static function delete_data_from_database($database_type, $collection_name, $doc_id) {
    return self::$firebase_service->delete_data_from_database($database_type, $collection_name, $doc_id);
  }

  public static function import_users_to_firebase($users) {
    return self::$firebase_service->import_users_to_firebase($users);
  }

  public static function get_firebase_user($userId, $fields) {
    return self::$firebase_service->get_firebase_user($userId, $fields);
  }

  public static function verify_firebase_id_token($token) {
    return self::$firebase_service->verify_firebase_id_token($token);
  }
}
