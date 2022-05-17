<?php 
function read_notification($id_notification) {
  update_field('statut_notif', 'vu', $id_notification);
}
