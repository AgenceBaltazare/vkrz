<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$option_list = [
    // 'firebase_users',
];

foreach ($option_list as $option) {
    // delete_option($option);
}
?>
