<?php
include __DIR__ . '/../../../../wp-load.php';

$u=1;
$user_query = new WP_User_Query(
    array(
        'number' => 2000,
        'meta_query' => array(
          array(
            'key'     => 'maj_user',
            'compare' => 'EXISTS',
          ),
        )
    )
);
$users = $user_query->get_results();
foreach ($users as $user) {
    
    $user_id = $user->ID;
    update_field('maj_user', 'aa', 'user_' . $user_id);

    /*
    $uuiduser = get_field('uuiduser_user', 'user_'.$user_id);

    $user_infos  = get_user_infos($uuiduser);

    $utilisateur                   = new stdClass();
    $utilisateur->Pseudo           = $user_infos['pseudo'];
    $utilisateur->Image            = $user_infos['avatar'];
    $utilisateur->Email            = $user_infos['user_email'];
    $utilisateur->UUID             = $user_infos['uuid_vainkeur'];
    $utilisateur->idVainkeur       = $user_infos['id_vainkeur'];
    $utilisateur->level            = $user_infos['level_number'];
    $utilisateur->role             = $user_infos['user_role'];
    $utilisateur->Twitch           = get_userdata($user_id)->twitch_user;
    $utilisateur->YouTube          = get_userdata($user_id)->youtube_user;
    $utilisateur->Instagram        = get_userdata($user_id)->Instagram_user;
    $utilisateur->TikTok           = get_userdata($user_id)->tiktok_user;
    $utilisateur->Twitter          = get_userdata($user_id)->twitter_user;
    $utilisateur->RegistrationDate = date("d-m-Y H:i:s", strtotime(get_userdata($user_id)->user_registered));

    apply_filters('firebase_save_data_to_database', "firestore", "utilizateurs", get_userdata($user_id)->user_login, $utilisateur);

    $u++;
    */
}
echo $u;