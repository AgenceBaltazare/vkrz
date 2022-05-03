<?php
function do_notification($id_user, $uuiduser, $relation_uuid, $notif_text, $liens_vers)
{


  // if (strpos($notif_text, "guette")) {

  // }

  // Get user object
  $account = get_user_by('login', 'adil');
  // Get user display name
  $account_id = $account->ID;

  $id_update_account = wp_update_post($account_id);

  update_field('liste_amis_user', $id_user, $id_update_account);

  $new_notification = array(
    'post_type'   => 'notification',
    'post_title'  => 'Nouveau follow',
    'post_status' => 'publish',
  );
  $id_new_notification  = wp_insert_post($new_notification);

  update_field('id_user_notif', $id_user, $id_new_notification);
  update_field('uuid_user_notif', $uuiduser, $id_new_notification);
  update_field('relation_uuid_notif', $relation_uuid, $id_new_notification);
  update_field('texte_notif', $notif_text, $id_new_notification);
  update_field('lien_vers_notif', $liens_vers, $id_new_notification);
  update_field('statut_notif', 'nouveau', $id_new_notification);

  return die(json_encode($id_new_notification));
}
