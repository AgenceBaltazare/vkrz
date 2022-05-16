<?php
function do_notification($id_user, $uuiduser, $relation_id, $relation_uuid, $notif_text, $liens_vers)
{
  $pos = strpos($notif_text, "guette");
  if ($pos) {
    // UNE SIMPLE GUETTE ✨
    $amis = array();
    $amis = get_field('liste_amis_user', 'user_' . $relation_id, false);
    if (!is_array($amis)) {
      $amis = array();
    }
    array_push($amis, $id_user);
    update_field('liste_amis_user', $amis, 'user_' . $relation_id);

    $new_notification = array(
      'post_type'   => 'notification',
      'post_title'  => get_userdata($id_user)->user_login . ' guette ' . get_userdata($relation_id)->user_login . '!',
      'post_status' => 'publish',
    );
    $id_new_notification  = wp_insert_post($new_notification);

    update_field('id_user_notif', $id_user, $id_new_notification);
    update_field('uuid_user_notif', $uuiduser, $id_new_notification);
    update_field('relation_uuid_notif', $relation_uuid, $id_new_notification);
    update_field('texte_notif', $notif_text, $id_new_notification);
    update_field('lien_vers_notif', $liens_vers, $id_new_notification);
    update_field('statut_notif', 'nouveau', $id_new_notification);
  } else {
    $pos = strpos($notif_text, "commentaire");
    if ($pos) {
      // IL S'AGIT D'UN COMMENTAIRE.. ✨
      $new_notification = array(
        'post_type'   => 'notification',
        'post_title'  => 'Commentaire',
        'post_status' => 'publish',
      );
      $id_new_notification  = wp_insert_post($new_notification);

      update_field('id_user_notif', $id_user, $id_new_notification);
      update_field('uuid_user_notif', $uuiduser, $id_new_notification);
      update_field('relation_uuid_notif', $relation_uuid, $id_new_notification);
      update_field('texte_notif', $notif_text, $id_new_notification);
      update_field('lien_vers_notif', $liens_vers, $id_new_notification);
      update_field('statut_notif', 'nouveau', $id_new_notification);
    } else {
      // NOTIFICATION D'UN CLASSEMENT.. ✨
      $user = wp_get_current_user();
      $user_name = $user->display_name;
      $user_id = $user->ID;

      $uuiduser = get_field('uuiduser_user', 'user_' . $user_id);

      $amis_ids = array();
      $amis_ids = get_field('liste_amis_user', 'user_' . $user_id, false);
      if (is_array($amis_ids)) {
        $amis = array();
        foreach (array_unique($amis_ids) as $ami_id) :
          $ami_uuid = get_field('uuiduser_user', 'user_' . $ami_id);
          $ami_infos = get_user_infos($ami_uuid);

          array_push($amis, $ami_infos);
        endforeach;
      }

      if (!empty($amis)) {
        foreach ($amis as $ami) {
          $new_notification = array(
            'post_type'   => 'notification',
            'post_title'  => 'Nouveau follow',
            'post_status' => 'publish',
          );
          $id_new_notification  = wp_insert_post($new_notification);

          update_field('id_user_notif', $id_user, $id_new_notification);
          update_field('uuid_user_notif', $uuiduser, $id_new_notification);
          update_field('relation_uuid_notif', $ami['uuid_user_vkrz'], $id_new_notification);
          update_field('texte_notif', $notif_text, $id_new_notification);
          update_field('lien_vers_notif', $liens_vers, $id_new_notification);
          update_field('statut_notif', 'nouveau', $id_new_notification);
        }
      }
    }
  }

  // return die(json_encode($id_new_notification));
}
