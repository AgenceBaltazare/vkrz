<?php
function remove_menu_items() {
    global $menu;
    
    $current_user    = wp_get_current_user();
    $user_id         = $current_user->ID;
    $user_info       = get_userdata($user_id);
    $user_role       = $user_info->roles[0];

    if($user_role == "author"){
        remove_menu_page( 'index.php' );
        remove_menu_page( 'edit.php' );
        remove_menu_page( 'edit.php?post_type=page' );
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'users.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'edit.php?post_type=classement' ); 
        remove_menu_page( 'edit.php?post_type=vainkeur' ); 
        remove_menu_page( 'edit.php?post_type=note' ); 
        remove_menu_page( 'profile.php' );
        add_filter('acf/settings/show_admin', '__return_false');
    }
}
add_action('admin_menu', 'remove_menu_items');