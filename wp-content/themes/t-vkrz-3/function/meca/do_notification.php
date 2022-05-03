<?php
function do_notification($id_user, $uuiduser, $relation_id, $relation_uuid, $notif_text, $liens_vers)
{

  $amis = array();
  $amis = get_field('liste_amis_user', 'user_' . $relation_id, false);
  if (!is_array($amis)) {
    $amis = array();
  }
  array_push($amis, $id_user);
  update_field('liste_amis_user', $amis, 'user_' . $relation_id);

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
