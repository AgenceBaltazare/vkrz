<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$option_list = [
    'firebase_auth',
    'firebase_settings',
    'firebase_database',
    'firebase_wordpress',
    'firebase_credentials',
];

foreach ($option_list as $option) {
    delete_option($option);
}
?>
