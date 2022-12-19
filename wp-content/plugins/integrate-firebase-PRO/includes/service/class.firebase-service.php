<?php

/**
 * Firebase Service
 */

defined('ABSPATH') || exit;

if (!class_exists('FirebaseService', false)) :

  /**
   * FirebaseService Class
   */
  class FirebaseService {
    protected $firebase_settings = null;
    protected $options_wordpress = null;
    protected $options = null;

    protected $base_domain = null;
    protected $database_url = null;
    protected $api_token = null;
    protected $database_type = null;
    protected $users_collection = null;

    public function __construct() {
      $this->firebase_settings = get_option('firebase_settings');
      $this->options_wordpress = get_option("firebase_wordpress");
      $this->options = get_option("firebase_credentials");

      $this->base_domain = $this->firebase_settings['base_domain'];
      $this->api_token = $this->firebase_settings['dashboard_api_token'];
      $this->database_url = $this->options['database_url'];
      $this->database_type = isset($this->options_wordpress['wp_sync_database_type']) ? $this->options_wordpress['wp_sync_database_type'] : null;
      $this->users_collection =  isset($this->options_wordpress['wp_sync_users']) ? $this->options_wordpress['wp_sync_users'] : null;
    }

    public function get_firebase_setting() {
      return $this->firebase_settings;
    }

    private function collection_name_generator($post_type) {
      $type_object = get_post_type_object($post_type);
      $plural_name = isset($type_object->labels) ? $type_object->labels->name : $post_type;
      $name_array = preg_split("/[_,\- ]+/", $plural_name);
      $name_array = array_map('ucfirst', $name_array);

      return 'wp' . implode("", $name_array);
    }

    /**
     * Get Data from Firebase Database
     *
     * @param [type] $database_type realtime | firestore
     * @param [type] $collection_name
     * @param [type] $doc_id
     * @return void
     */
    public function get_data_from_firebase($database_type, $collection_name, $doc_id) {
      $url = $this->base_domain . "/api-database/v1/getDoc";

      // Prepare data
      $prepared_data = new stdClass();
      $prepared_data->dbType = $database_type;
      $prepared_data->collection = $collection_name;
      $prepared_data->documentId = (string) $doc_id;

      $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
          'api-token' => $this->api_token,
          'source' => 'dashboard',
          'database-url' => $this->database_url,
          'Content-Type' => 'application/json; charset=utf-8',
        ),
        'body' => json_encode($prepared_data),
      ));

      if (!is_wp_error($response)) {
        $result = json_decode($response['body']);
        if ($result->status) {
          return $result->data;
        } else {
          error_log($result->message);
          return false;
        }
      }
    }

    /**
     * Verify id token
     *
     * @param [type] token string
     * @return void
     */
    public function verify_firebase_id_token($token) {
      $url = $this->base_domain . "/api-jwt/v1/verify?idToken=$token";

      $response = wp_remote_post($url, array(
        'method' => 'GET',
        'timeout' => 45,
        'headers' => array(
          'Content-Type' => 'application/json; charset=utf-8',
        ),
      ));

      return json_decode($response['body']);
    }

    /**
     * Send Data to Firebase Database
     *
     * @param [type] $database_type realtime | firestore
     * @param [type] $collection_name
     * @param [type] $doc_id
     * @param [type] $data
     * @return void
     */
    public function send_data_to_firebase($database_type, $collection_name, $doc_id, $data) {
      $url = $this->base_domain . "/api-database/v1/updateDoc";

      // add timestamp
      if (is_object($data)) {
        $data->firebase_synced_at = time();
      }

      if (is_array($data)) {
        $data['firebase_synced_at'] = time();
      }

      // hooks
      $doc_id = apply_filters('firebase_update_doc_id_before_saving_to_database', $doc_id,  $collection_name);

      // Prepare data
      $prepared_data = new stdClass();
      $prepared_data->dbType = $database_type;
      $prepared_data->collection = $collection_name;
      $prepared_data->docId = (string) $doc_id;
      $prepared_data->data = $data;

      $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
          'api-token' => $this->api_token,
          'source' => 'dashboard',
          'database-url' => $this->database_url,
          'Content-Type' => 'application/json; charset=utf-8',
        ),
        'body' => json_encode($prepared_data),
      ));

      if (!is_wp_error($response)) {
        $result = json_decode($response['body']);
        if ($result->status) {
          return $result;
        } else {
          error_log($result->message);
          return false;
        }
      }
    }

    /**
     * Delete Data from Firebase Database
     *
     * @param [type] $database_type realtime | firestore
     * @param [type] $collection_name
     * @param [type] $doc_id
     * @return void
     */
    public function delete_data_from_database($database_type, $collection_name, $doc_id) {
      $url = $this->base_domain . "/api-database/v1/deleteDoc";

      // Prepare data
      $prepared_data = new stdClass();
      $prepared_data->dbType = $database_type;
      $prepared_data->collection = $collection_name;
      $prepared_data->docId = (string) $doc_id;

      $response = wp_remote_post($url, array(
        'method' => 'DELETE',
        'timeout' => 45,
        'headers' => array(
          'api-token' => $this->api_token,
          'source' => 'dashboard',
          'database-url' => $this->database_url,
          'Content-Type' => 'application/json; charset=utf-8',
        ),
        'body' => json_encode($prepared_data),
      ));

      if (!is_wp_error($response)) {
        $result = json_decode($response['body']);
        if ($result->status) {
          return $result;
        } else {
          error_log($result->message);
          return false;
        }
      }
    }

    public function save_taxonomy_data_to_firebase($collection_name, $taxonomy) {
      if (
        isset($this->options_wordpress['wp_sync_post_types'])
        || isset($this->options_wordpress['wp_sync_custom_post_types'])
      ) {

        $doc_id = (string) $taxonomy->id;
        apply_filters('firebase_save_data_to_database', $this->database_type, $collection_name, $doc_id, $taxonomy);
      }
    }

    public function delete_taxonomy_data_to_firebase($collection_name, $taxonomy_id) {
      if (isset($this->options_wordpress['wp_sync_database_type'])) {
        apply_filters('firebase_delete_data_from_database', $this->database_type, $collection_name, $taxonomy_id);
      }
    }

    public function save_wordpress_data_to_firebase($post_id, $post) {
      if (isset($this->options_wordpress['wp_sync_post_types']) && in_array($post->post_type, $this->options_wordpress['wp_sync_post_types'])) {
        $this->sync_wordpress_data_handler($post_id, $post);
      }

      if (isset($this->options_wordpress['wp_sync_custom_post_types']) && strpos($this->options_wordpress['wp_sync_custom_post_types'], $post->post_type) !== false) {
        $this->sync_wordpress_data_handler($post_id, $post);
      }
    }

    private function sync_wordpress_data_handler($post_id, $post) {
      $collection_name = $this->collection_name_generator($post->post_type);

      if ($collection_name) {

        $doc_id = (string) $post_id;

        // allow to modify post before saving to database
        $post = apply_filters('firebase_before_saving_post_to_database', $post);

        // Delete data before saving new one
        apply_filters('firebase_delete_data_from_database', $this->database_type, $collection_name, $doc_id);
        apply_filters('firebase_save_data_to_database', $this->database_type, $collection_name, $doc_id, $post);
      } else {
        // error_log('Integrate Firebase PRO does not support post type: ' . $post->$post_type);
      }
    }

    public function delete_wordpress_data_from_firebase($post_id, $post_type) {
      $collection_name = null;

      if (
        (isset($this->options_wordpress['wp_sync_post_types']) && in_array($post_type, $this->options_wordpress['wp_sync_post_types']))
        || (isset($this->options_wordpress['wp_sync_custom_post_types']) && strpos($this->options_wordpress['wp_sync_custom_post_types'], $post_type) !== false)
      ) {
        $collection_name = $this->collection_name_generator($post_type);
      }

      if ($collection_name) {

        $doc_id = (string) $post_id;
        apply_filters('firebase_delete_data_from_database', $this->database_type, $collection_name, $doc_id);
      } else {
        // error_log('Integrate Firebase PRO does not support post type: ' . $post_type);
      }
    }

    public function sync_user_to_firebase($firebase_user) {
      $response = $this->sync_user_data_handler($firebase_user);
      if ($response !== false) {
        update_user_meta($firebase_user['wordpressUserId'], 'synced_user_to_firebase', true);
      }
    }

    public function sync_user_profile_to_firebase($firebase_user) {
      $response = $this->sync_user_data_handler($firebase_user);
      if ($response !== false) {
        update_user_meta($firebase_user['wordpressUserId'], 'firebase_synced_data', $firebase_user);
      }
    }

    private function sync_user_data_handler($firebase_user) {

      if (empty($this->users_collection)) {
        return false;
      }

      unset($firebase_user['password']);
      $filtered_data = array_filter($firebase_user);

      if (empty($filtered_data['userId'])) {
        return false;
      }

      $doc_id = (string) $filtered_data['userId'];

      // Allow to add more data to user
      $filtered_data = apply_filters('firebase_before_saving_user_to_database', $filtered_data);

      return apply_filters('firebase_save_data_to_database', $this->database_type, $this->users_collection, $doc_id, $filtered_data);
    }

    public function import_users_to_firebase($users) {
      $url = $this->base_domain . "/api-user/v1/users/import";

      $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
          'api-token' => $this->api_token,
          'source' => 'dashboard',
          'Content-Type' => 'application/json; charset=utf-8',
        ),
        'body' => json_encode($users),
      ));

      // Set firebase_uid during import
      foreach ($users as $user) {
        update_user_meta($user->ID, "firebase_uid", $user->user_login);
      }

      return json_decode($response['body']);
    }

    public function create_new_user($user_id, $user_data) {
      $data = new stdClass();
      $data->email = $user_data['email'];
      if (isset($user_data['first_name']) && isset($user_data['last_name'])) {
        $data->displayName = $user_data['first_name'] . ' ' . $user_data['last_name'];
      }
      $data->password = $user_data['password'];

      $url = $this->base_domain . "/api-user/v1/users";

      $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
          'api-token' => $this->api_token,
          'source' => 'dashboard',
          'Content-Type' => 'application/json; charset=utf-8',
        ),
        'body' => json_encode($data),
      ));

      if (is_wp_error($response)) {
        error_log('[Firebase] send create user request for ' . $user_id);
        return;
      }

      $responseBody = json_decode($response['body']);

      if (isset($responseBody->message) && $responseBody->status) {
        $firebase_uid = trim(explode(':', $responseBody->message)[1]);
        update_user_meta($user_id, "firebase_uid", $firebase_uid);
      } else {
        error_log('[Firebase] could not create user for ' . $user_id);
      }
    }

    /**
     * Get user by firebase
     * @param: [string] $userId
     * @param: [string] $fields
     * @return: [object]
     */
    public function get_firebase_user($userId, $fields) {
      $url = $this->base_domain . "/api-user/v1/users/$userId";

      if (!empty($fields)) {
        $url .= "?fields=$fields";
      }

      $response = wp_remote_get($url, array(
        'method' => 'GET',
        'headers' => array(
          'api-token' => $this->api_token,
          'source' => 'dashboard',
          'Content-Type' => 'application/json; charset=utf-8',
        ),
      ));

      if (is_wp_error($response)) {
        error_log('ERROR - get Firebase User');
        return null;
      }

      return json_decode($response['body']);
    }

    /**
     * Update user in firebase authentication & update users collection
     * @param: [Array] firebase_user
     */
    public function update_user_account($firebase_user) {

      $user_id = $firebase_user['userId'];

      if (empty($user_id)) {
        return;
      }

      $url = $this->base_domain . "/api-user/v1/users/$user_id";

      if (!empty($this->database_type) && !empty($this->users_collection)) {
        $url .= '?dbType=' . $this->database_type . '&usersCollection=' . $this->users_collection;
      }

      $response = wp_remote_post($url, array(
        'method' => 'PATCH',
        'timeout' => 45,
        'headers' => array(
          'api-token' => $this->api_token,
          'source' => 'dashboard',
          'Content-Type' => 'application/json; charset=utf-8',
        ),
        'body' => json_encode($firebase_user),
      ));


      if (!is_wp_error($response)) {
        $result = json_decode($response['body']);
        if (is_object($result) && $result->status) {
          update_user_meta($firebase_user['wordpressUserId'], 'firebase_synced_data', $firebase_user);
          return true;
        } else {
          if (is_object($result)) {
            error_log($result->message);
          } else {
            error_log('[FIREBASE] Error in updating user email ' . $user_id);
          }
          return false;
        }
      } else {
        return false;
      }
    }
  }

endif;

return new FirebaseService();
