<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $id_vainkeur;
get_header();
if ($id_vainkeur) {
  if (is_user_logged_in() && env() != "local") {
    if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
      $user_tops = get_user_tops($id_vainkeur);
      set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
    } else {
      $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
    }
  } else {
    $user_tops  = get_user_tops($id_vainkeur);
  }
  $list_user_tops         = $user_tops['list_user_tops_done_ids'];
  $list_user_tops_begin   = $user_tops['list_user_tops_begin_ids'];
} else {
  $user_tops            = array();
  $list_user_tops       = array();
  $list_user_tops_begin = array();
}
?>


<?php get_footer(); ?>