<?php

/**
 * Update Integrate Firebase PRO
 */

if (!defined('ABSPATH')) exit;

class Firebase_Admin_Updater {
  private static $options_settings;

  private static $initiated = false;
  private static $api_url = '';
  private static $name = '';
  private static $slug = '';
  private static $version = '';
  private static $cache_key = '';
  private static $license = '';
  private static $site_url = '';


  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    self::$initiated = true;
    self::$options_settings = get_option("firebase_settings");

    self::$name = plugin_basename(FIREBASE_WP__PLUGIN_FILE);
    self::$api_url = trailingslashit('http://techcater.com/api-wordpress/v1/plugins');
    self::$slug = 'firebase-setting';
    self::$version = FIREBASE_WP_VERSION;
    self::$site_url = get_site_url();

    if (isset(self::$options_settings['product_key'])) {
      self::$license = self::$options_settings['product_key'];
    }

    // Local testing
    if (strpos(self::$site_url, '.local') !== false) {
      self::$api_url = trailingslashit('https://integrate-firebase-pro-dev.web.app/api-wordpress/v1/plugins');
      // self::$api_url = trailingslashit('http://localhost:5000/api-wordpress/v1/plugins');
    }

    add_filter('pre_set_site_transient_update_plugins', array('Firebase_Admin_Updater', 'check_update'));
    add_filter('plugins_api', array('Firebase_Admin_Updater', 'plugins_api_filter'), 10, 3);

    add_action('in_plugin_update_message-' . self::$name, array(
      'Firebase_Admin_Updater',
      'add_upgrade_message_link',
    ), 10, 2);
  }


  /**
   * Check for Updates at the defined API endpoint and modify the update array.
   *
   * This function dives into the update API just when WordPress creates its update array,
   * then adds a custom API call and injects the custom plugin data retrieved from the API.
   * It is reassembled from parts of the native WordPress plugin update code.
   * See wp-includes/update.php line 121 for the original wp_update_plugins() function.
   *
   * @uses api_request()
   *
   * @param array   $_transient_data Update array build by WordPress.
   * @return array Modified update array with custom plugin data.
   */
  public static function check_update($transient) {
    // Check if the transient contains the 'checked' information
    // If no, just return its value without hacking it
    if (empty($transient->checked) ||  self::$license === '') {
      return $transient;
    }


    $plugin_response = self::get_product_info('IFP_YEARLY');

    if (is_object($plugin_response)) {

      $new_version = $plugin_response->version;

      // make sure we do nothing when the current version seems to be greater than the "new" one
      if (version_compare(self::$version, $new_version, '>=')) {
        return $transient;
      }

      // create our response
      $obj = new \stdClass();
      $obj->plugin = self::$name;
      $obj->slug = self::$slug;
      $obj->new_version = $new_version;
      $obj->package = $plugin_response->download_link . '?origin=' . self::$site_url . '&license=' . self::$license;
      // here we inject our response to the given $transient
      $transient->response[$obj->plugin] = $obj;
    }

    return $transient;
  }

  /**
   *  Displays an update message for plugin list screens.
   *  Shows only the version updates from the current until the newest version
   *
   *  @type	function
   *
   *  @param	{array}		$plugin_data
   *  @param	{object}	$r
   */

  public static function add_upgrade_message_link($plugin_data, $r) {
    if (self::$license == '') {

      echo '<br><hr>';
      $url = self::$site_url . '/wp-admin/admin.php?page=firebase-setting&tab=settings';
      $redirect = sprintf('<a href="%s" target="_blank">%s</a>', $url, __('Settings', 'integrate-firebase-PRO'));

      echo sprintf(' ' . __('To receive automatic updates license activation is required. Please visit %s to activate your Integrate Firebase PRO.', 'integrate-firebase-PRO'), $redirect);
    }
  }

  /**
   * Updates information on the "View version x.x details" page with custom data.
   *
   * @uses api_request()
   *
   * @param mixed   $_data
   * @param string  $_action
   * @param object  $_args
   * @return object $_data
   */
  public static function plugins_api_filter($_data, $_action = '', $_args = null) {

    if ($_action != 'plugin_information') {
      return $_data;
    }

    if (!isset($_args->slug) || $_args->slug != self::$slug) {
      return $_data;
    }

    // $plugin_info = get_site_transient('update_plugins');
    // $_args->version = $plugin_info->checked[self::$name];

    $plugin_response = self::get_product_info('IFP_YEARLY');
    $obj = new \stdClass();

    if (is_object($plugin_response)) {
      // Create our object which should includes everything
      // see wp-admin/includes/plugin-install.php
      $obj->homepage = $plugin_response->homepage;
      $obj->version = $plugin_response->version;
      $obj->author = 'Dale Nguyen';
      $obj->slug = self::$slug;
      $obj->name = 'Integrate Firebase PRO';
      $obj->plugin_name = self::$slug;
      $obj->tested = $plugin_response->tested;
      $obj->last_updated = date($plugin_response->last_updated);
      $obj->download_link = $plugin_response->download_link;

      $obj->sections = self::convert_object_to_array($plugin_response->sections);

      $obj->banners = self::convert_object_to_array($plugin_response->banners);
    }

    return $obj;
  }

  public static function get_cached_version_info($cache_key = '') {

    if (empty($cache_key)) {
      $cache_key = self::$cache_key;
    }

    $cache = get_option($cache_key);

    if (empty($cache['timeout']) || time() > $cache['timeout']) {
      return false; // Cache is expired
    }

    // We need to turn the icons into an array, thanks to WP Core forcing these into an object at some point.
    $cache['value'] = json_decode($cache['value']);
    if (!empty($cache['value']->icons)) {
      $cache['value']->icons = (array) $cache['value']->icons;
    }

    return $cache['value'];
  }

  public static function set_version_info_cache($value = '', $cache_key = '') {

    if (empty($cache_key)) {
      $cache_key = self::$cache_key;
    }

    $data = array(
      'timeout' => strtotime('+3 hours', time()),
      'value'   => json_encode($value)
    );

    update_option($cache_key, $data, 'no');
  }

  /**
   * Convert some objects to arrays when injecting data into the update API
   *
   * Some data like sections, banners, and icons are expected to be an associative array, however due to the JSON
   * decoding, they are objects. This method allows us to pass in the object and return an associative array.
   *
   * @since 3.6.5
   *
   * @param stdClass $data
   *
   * @return array
   */
  private static function convert_object_to_array($data) {
    $new_data = array();
    foreach ($data as $key => $value) {
      $new_data[$key] = $value;
    }

    return $new_data;
  }

  public static function get_product_info($plugin_id) {
    $headers = array(
      'origin' => self::$site_url,
      'license' => self::$license
    );

    $args = array(
      'headers'   => $headers,
      'timeout'   => 60,
      'sslverify' => true,
    );

    $response = wp_remote_get(self::$api_url . "$plugin_id/info?", $args);

    if (is_wp_error($response)) {
      return false;
    }

    return json_decode($response['body']);
  }
}
