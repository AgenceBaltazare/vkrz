<?php

/**
 * Firebase WordPress Util Hooks
 */

class FirebaseUtils {
    private static $initiated = false;

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;
        // Custom utils
        add_filter('firebase_generate_nice_username', array('FirebaseUtils', 'generate_nice_username'), 10, 1);
        add_filter('firebase_get_user_by_firebase_uid', array('FirebaseUtils', 'get_user_by_firebase_uid'), 10, 1);
        add_filter('firebase_validate_pro_plugin', array('FirebaseUtils', 'validate_pro_plugin'), 10, 1);
    }

    public static function get_user_by_firebase_uid(string $firebase_uid) {
        $users = get_users(
            array(
                'meta_key' => 'firebase_uid',
                'meta_value' => $firebase_uid,
                'number' => 1
            )
        );

        if (empty($users) || !is_array($users)) {
            return false;
        }

        return $users[0];
    }

    public static function generate_nice_username(array $firebase_user) {

        $nice_username = '';

        if (isset($firebase_user['email'])) {
            $nice_username = preg_replace('/@.*?$/', '', $firebase_user['email']);
        }

        if (isset($firebase_user['displayName']) && empty($nice_username)) {
            $nice_username = self::replace_accents(str_replace(' ', '_', $firebase_user['displayName']));
        }

        // Replace special characters
        $nice_username = str_replace('+', '_', $nice_username);

        return $nice_username;
    }

    private static function replace_accents($str) {
        $unwanted_array = array(
            'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ễ' => 'E', 'ễ' => 'e', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
            'Ũ' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ũ' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
        );
        return strtr($str, $unwanted_array);
    }

    public static function validate_pro_plugin(string $product_key) {
        // Validate product
        $data = new stdClass();
        $data->productKey = $product_key;
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
            update_option('firebase_pro_validated_on', date('Y-m-d'));
            $result = json_decode($response['body']);
            if (is_object($result) && $result->status == 0) {
                // Show missing error message
                update_option('firebase_pro_is_valid', false);
                new IFP_Message($result->message, 'error');
            } else {
                update_option('firebase_pro_is_valid', true);
            }
        }
    }
}
