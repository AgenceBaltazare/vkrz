<?php

/**
 * Users related actions
 */

class FirebaseUsersActions {
    private static $initiated = false;
    private static $firebase_woocommerce_general;

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;
        self::$firebase_woocommerce_general = get_option('firebase_woocommerce_general');

        if (isset(self::$firebase_woocommerce_general) && isset(self::$firebase_woocommerce_general['fw_create_new_user_at_checkout']) && self::$firebase_woocommerce_general['fw_create_new_user_at_checkout']) {
            add_action('user_register', array('FirebaseUsersActions', 'user_register_event'), 10, 2);
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

    public static function user_register_event($user_id, $user) {

        // [29-Oct-2022 08:54:29 UTC] Array
        // (
        //     [first_name] => Test
        //     [last_name] => 500
        //     [user_login] => test500
        //     [user_pass] => xxx
        //     [user_email] => test500@dalenguyen.me
        //     [role] => customer
        // )

        $firebase_uid = get_user_meta($user_id, 'firebase_uid', true);

        // normal flow only have email & password in the $user
        // consider using wp_insert_user to have custom data to the fields which 
        // will help in case of passing meta data (firebase_uid...)
        if (empty($firebase_uid) && isset($user['first_name'])) {
            // get user data 
            $user_data = array(
                'email' => $user['user_email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'password' => $user['user_pass'],
            );

            apply_filters('firebase_create_new_user', $user_id, $user_data);
        }
    }
}
